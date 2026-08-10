<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Table: pengguna (sebagai ganti users, memuat Role)
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['Superadmin', 'Admin', 'User']);
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();
        });

        // 2. Table: catering (dikontrol oleh Admin/Manager)
        Schema::create('catering', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin');
            $table->string('nama_catering', 100)->unique();
            $table->text('deskripsi')->nullable();
            $table->string('status', 20)->default('Aktif');
            $table->timestamps();

            $table->foreign('id_admin')->references('id')->on('pengguna')->onDelete('cascade');
        });

        // 3. Table: menu
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_catering');
            $table->string('kode_menu', 20)->unique();
            $table->string('nama_menu', 100);
            $table->decimal('harga', 10, 2);
            $table->integer('stok');

            $table->foreign('id_catering')->references('id')->on('catering')->onDelete('cascade');
        });

        // 4. Table: paket
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_catering');
            $table->string('nama_paket', 100);
            $table->decimal('harga', 10, 2);

            $table->foreign('id_catering')->references('id')->on('catering')->onDelete('cascade');
        });

        // 5. Table: pesanan
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_catering');
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->enum('status_pesanan', ['Pending', 'Diproses', 'Selesai', 'Batal'])->default('Pending');
            $table->decimal('total_harga', 15, 2);

            $table->foreign('id_pelanggan')->references('id')->on('pengguna')->onDelete('cascade');
            $table->foreign('id_catering')->references('id')->on('catering')->onDelete('cascade');
        });

        // 6. Table: detail_pesanan
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_menu')->nullable();
            $table->unsignedBigInteger('id_paket')->nullable();
            $table->integer('jumlah');
            $table->decimal('subtotal', 15, 2);

            $table->foreign('id_pesanan')->references('id')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_menu')->references('id')->on('menu')->onDelete('set null');
            $table->foreign('id_paket')->references('id')->on('paket')->onDelete('set null');
        });

        // 7. Table: pembayaran
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pesanan');
            $table->timestamp('tanggal_bayar')->useCurrent();
            $table->string('metode_pembayaran', 50);
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('status_pembayaran', 50)->default('Berhasil');

            $table->foreign('id_pesanan')->references('id')->on('pesanan')->onDelete('cascade');
        });

        // Laravel standard tables required for auth/session
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('paket');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('catering');
        Schema::dropIfExists('pengguna');
    }
};

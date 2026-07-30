<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Table: pengguna (sebagai ganti users, memuat Role)
        DB::statement("
            CREATE TABLE pengguna (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL CHECK(role IN ('Superadmin', 'Admin', 'User')),
                status VARCHAR(20) DEFAULT 'Aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        // 2. Table: catering (dikontrol oleh Admin/Manager)
        DB::statement("
            CREATE TABLE catering (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_admin INT NOT NULL,
                nama_catering VARCHAR(100) NOT NULL UNIQUE,
                deskripsi TEXT,
                status VARCHAR(20) DEFAULT 'Aktif',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (id_admin) REFERENCES pengguna(id) ON DELETE CASCADE
            )
        ");

        // 3. Table: menu
        DB::statement("
            CREATE TABLE menu (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_catering INT NOT NULL,
                kode_menu VARCHAR(20) NOT NULL UNIQUE,
                nama_menu VARCHAR(100) NOT NULL,
                harga DECIMAL(10,2) NOT NULL CHECK(harga > 0),
                stok INT NOT NULL CHECK(stok >= 0),
                FOREIGN KEY (id_catering) REFERENCES catering(id) ON DELETE CASCADE
            )
        ");

        // 4. Table: paket
        DB::statement("
            CREATE TABLE paket (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_catering INT NOT NULL,
                nama_paket VARCHAR(100) NOT NULL,
                harga DECIMAL(10,2) NOT NULL CHECK(harga > 0),
                FOREIGN KEY (id_catering) REFERENCES catering(id) ON DELETE CASCADE
            )
        ");

        // 5. Table: pesanan
        DB::statement("
            CREATE TABLE pesanan (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_pelanggan INT NOT NULL,
                id_catering INT NOT NULL,
                tanggal_pesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status_pesanan VARCHAR(50) DEFAULT 'Pending' CHECK(status_pesanan IN ('Pending', 'Diproses', 'Selesai', 'Batal')),
                total_harga DECIMAL(15,2) NOT NULL CHECK(total_harga >= 0),
                FOREIGN KEY (id_pelanggan) REFERENCES pengguna(id) ON DELETE CASCADE,
                FOREIGN KEY (id_catering) REFERENCES catering(id) ON DELETE CASCADE
            )
        ");

        // 6. Table: detail_pesanan
        DB::statement("
            CREATE TABLE detail_pesanan (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_pesanan INT NOT NULL,
                id_menu INT NULL,
                id_paket INT NULL,
                jumlah INT NOT NULL CHECK(jumlah > 0),
                subtotal DECIMAL(15,2) NOT NULL CHECK(subtotal >= 0),
                FOREIGN KEY (id_pesanan) REFERENCES pesanan(id) ON DELETE CASCADE,
                FOREIGN KEY (id_menu) REFERENCES menu(id) ON DELETE SET NULL,
                FOREIGN KEY (id_paket) REFERENCES paket(id) ON DELETE SET NULL
            )
        ");

        // 7. Table: pembayaran
        DB::statement("
            CREATE TABLE pembayaran (
                id INT PRIMARY KEY AUTO_INCREMENT,
                id_pesanan INT NOT NULL,
                tanggal_bayar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                metode_pembayaran VARCHAR(50) NOT NULL,
                jumlah_bayar DECIMAL(15,2) NOT NULL CHECK(jumlah_bayar > 0),
                status_pembayaran VARCHAR(50) DEFAULT 'Berhasil',
                FOREIGN KEY (id_pesanan) REFERENCES pesanan(id) ON DELETE CASCADE
            )
        ");

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
        
        DB::statement("DROP TABLE IF EXISTS pembayaran");
        DB::statement("DROP TABLE IF EXISTS detail_pesanan");
        DB::statement("DROP TABLE IF EXISTS pesanan");
        DB::statement("DROP TABLE IF EXISTS paket");
        DB::statement("DROP TABLE IF EXISTS menu");
        DB::statement("DROP TABLE IF EXISTS catering");
        DB::statement("DROP TABLE IF EXISTS pengguna");
    }
};

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
        Schema::create('menu_paket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_paket');
            $table->unsignedBigInteger('id_menu');

            $table->foreign('id_paket')->references('id')->on('paket')->onDelete('cascade');
            $table->foreign('id_menu')->references('id')->on('menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_paket');
    }
};

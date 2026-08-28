<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->unsignedBigInteger('id_catering')->nullable()->after('role');
            $table->foreign('id_catering')->references('id')->on('catering')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropForeign(['id_catering']);
            $table->dropColumn('id_catering');
        });
    }
};
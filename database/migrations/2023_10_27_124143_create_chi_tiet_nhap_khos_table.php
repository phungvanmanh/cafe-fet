<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_nhap_khos', function (Blueprint $table) {
            $table->id();
            $table->integer('id_nguyen_lieu');
            $table->integer('so_luong');
            $table->integer('don_gia');
            $table->integer('thanh_tien');
            $table->string('ghi_chu')->nullable();
            $table->integer('id_nha_cung_cap');
            $table->integer('id_hoa_don');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chi_tiet_nhap_khos');
    }
};

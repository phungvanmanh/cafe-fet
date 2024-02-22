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
        Schema::create('hoa_don_nhap_khos', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hoa_don');
            $table->date('ngay_tao_hoa_don');
            $table->string('ghi_chu');
            $table->integer('tong_tien');
            $table->integer('id_admin_nhap');
            $table->integer('id_nha_cung_cap');
            $table->integer('trang_thai');
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
        Schema::dropIfExists('hoa_don_nhap_khos');
    }
};

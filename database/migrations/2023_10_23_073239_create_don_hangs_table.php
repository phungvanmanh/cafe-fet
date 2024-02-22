<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('don_hangs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_khach_hang');
            $table->string('ma_don_hang')->nullable();
            $table->integer('is_thanh_toan')->default(0)->comment("0: Chưa Thanh Toán, 1: Đã thanh thoán");
            $table->double('tong_tien')->nullable();
            $table->string('dia_chi')->nullable();
            $table->string('ten_nguoi_nhan');
            $table->string('email');
            $table->string('so_dien_thoai');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('don_hangs');
    }
};

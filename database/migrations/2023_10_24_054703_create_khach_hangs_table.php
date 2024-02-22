<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('so_dien_thoai');
            $table->string('email');
            $table->string('password');
            $table->string('dia_chi');
            $table->double('tong_diem')->default(0);
            $table->double('diem_da_tru')->default(0);
            $table->double('diem_chua_su_dung')->default(0);
            $table->integer('trang_thai')->default(0)->comment('1: kích hoat, 0: chưa kích hoạt, 2: bị khóa');
            $table->string('avatar')->nullable();
            $table->string('hash_reset')->nullable();
            $table->string('hash_active')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('khach_hangs');
    }
};

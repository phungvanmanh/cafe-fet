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
        Schema::create('nha_cung_caps', function (Blueprint $table) {
            $table->id();
            $table->string('ma_so_thue')->nullable();
            $table->string('ten_doanh_nghiep')->nullable();
            $table->string('ten_nguoi_dai_dien');
            $table->string('so_dien_thoai');
            $table->string('email');
            $table->string('list_id_nguyen_lieu');
            $table->string('dia_chi')->nullable();
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
        Schema::dropIfExists('nha_cung_caps');
    }
};

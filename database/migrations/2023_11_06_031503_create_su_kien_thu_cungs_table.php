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
        Schema::create('su_kien_thu_cungs', function (Blueprint $table) {
            $table->id();
            $table->string('ten_su_kien');
            $table->string('slug_su_kien');
            $table->string('mo_ta');
            $table->integer('tinh_trang');
            $table->integer('so_nguoi_tham_gia');
            $table->string('list_id_client')->nullable();
            $table->string('dia_chi');
            $table->date('thoi_gian_bat_dau');
            $table->date('thoi_gian_ket_thuc');
            $table->integer('is_duyet')->comment('1:đã duyệt, 0:chưa duyệt')->nullable();
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
        Schema::dropIfExists('su_kien_thu_cungs');
    }
};

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
        Schema::create('nguyen_lieus', function (Blueprint $table) {
            $table->id();
            $table->string('ten_nguyen_lieu');
            $table->string('slug_nguyen_lieu');
            $table->integer('so_luong')->default(0); // Trường hợp do admin tạo sẵn nguyên liệu CẦN nhập về bán (lần đầu)
            $table->integer('don_gia')->default(0);  // thì cho số lượng và đơn giá bằng 0 vì chưa nhập lần nào nên chưa biết giá
            $table->integer('don_vi_tinh')->default(-1); // chưa có đơn vị
            $table->integer('trang_thai')->default(0); // Mới tạo chưa nhập kho nên chưa có để dùng
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
        Schema::dropIfExists('nguyen_lieus');
    }
};

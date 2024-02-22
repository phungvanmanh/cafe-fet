<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhapKhoController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'  =>  '/admin'], function() {
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/data', [AdminController::class, 'getDataAdmin']);
    Route::post('/create', [AdminController::class, 'createAdmin']);
    Route::post('/update', [AdminController::class, 'updateAdmin']);
    Route::post('/delete', [AdminController::class, 'deleteAdmin']);
    Route::group(['prefix'  =>  '/blog'], function() {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/data', [BlogController::class, 'getDataBlog']);
        Route::post('/create', [BlogController::class, 'createBlog']);
        Route::post('/update', [BlogController::class, 'updateBlog']);
        Route::post('/delete', [BlogController::class, 'deleteBlog']);
    });
    Route::group(['prefix'  =>  '/danh-muc'], function() {
        Route::get('/', [DanhMucController::class, 'index']);
        Route::get('/data', [DanhMucController::class, 'getDataDanhMuc']);
        Route::post('/status', [DanhMucController::class, 'statusDanhMuc']);
        Route::post('/create', [DanhMucController::class, 'createDanhMuc']);
        Route::post('/update', [DanhMucController::class, 'updateDanhMuc']);
        Route::post('/delete', [DanhMucController::class, 'deleteDanhMuc']);
    });
    Route::group(['prefix'  =>  '/san-pham'], function() {
        Route::get('/', [SanPhamController::class, 'index']);
        Route::get('/data', [SanPhamController::class, 'getDataSanPham']);
        Route::post('/status', [SanPhamController::class, 'statusSanPham']);
        Route::post('/create', [SanPhamController::class, 'createSanPham']);
        Route::post('/update', [SanPhamController::class, 'updateSanPham']);
        Route::post('/delete', [SanPhamController::class, 'deleteSanPham']);
    });
    Route::group(['prefix'  =>  '/nha-cung-cap'], function() {
        Route::get('/', [NhaCungCapController::class, 'index']);
        Route::get('/data', [NhaCungCapController::class, 'getDataNhaCungCap']);
        Route::post('/create', [NhaCungCapController::class, 'createNhaCungCap']);
        Route::post('/update', [NhaCungCapController::class, 'updateNhaCungCap']);
        Route::post('/status', [NhaCungCapController::class, 'statusNhaCungCap']);
        Route::post('/delete', [NhaCungCapController::class, 'deleteNhaCungCap']);
    });
    Route::group(['prefix'  =>  '/nhap-kho'], function() {
        Route::get('/', [NhapKhoController::class, 'index']);
        Route::post('/create', [NhapKhoController::class, 'createNhapKho']);
        Route::post('/update', [NhapKhoController::class, 'updateNhapKho']);
        Route::post('/status', [NhapKhoController::class, 'statusNhapKho']);
        Route::post('/delete', [NhapKhoController::class, 'deleteNhapKho']);
    });
    Route::group(['prefix'  =>  '/don-hang'], function() {
        Route::get('/', [DonHangController::class, 'index']);
        Route::post('/create', [DonHangController::class, 'createDonHang']);
        Route::post('/update', [DonHangController::class, 'updateDonHang']);
        Route::post('/status', [DonHangController::class, 'statusDonHang']);
        Route::post('/delete', [DonHangController::class, 'deleteDonHang']);
    });
    Route::group(['prefix'  =>  '/chi-tiet-don-hang'], function() {

    });
});

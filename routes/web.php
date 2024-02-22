<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\DonViController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\HoaDonNhapKhoController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NguyenLieuController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhapKhoController;
use App\Http\Controllers\QuyenController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\SuKienThuCungController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminController::class, 'viewLogin']);
Route::post('/admin/login', [AdminController::class, 'actionLogin']);
Route::get('/admin/lost-password', [AdminController::class, 'viewLostPass']);
Route::post('/admin/lost-password', [AdminController::class, 'actionLostPass']);

Route::group(['prefix'  =>  '/admin', 'middleware' => 'AdminMiddleware'], function () {
    Route::get('/logout', [AdminController::class, 'actionLogout']);
    Route::get('/', [AdminController::class, 'index']);
    Route::get('/data', [AdminController::class, 'getDataAdmin']);
    Route::get('/data-quyen', [AdminController::class, 'getDataQuyen']);
    Route::post('/status', [AdminController::class, 'statusAdmin']);
    Route::post('/create', [AdminController::class, 'createAdmin']);
    Route::post('/update', [AdminController::class, 'updateAdmin']);
    Route::post('/avatar', [AdminController::class, 'updateAvatar']);
    Route::post('/password', [AdminController::class, 'updatePasswordAdmin']);
    Route::post('/delete', [AdminController::class, 'deleteAdmin']);

    Route::group(['prefix' => '/profile'], function () {
        Route::get('/', [AdminController::class, 'index_profile']);
        Route::post('/data', [AdminController::class, 'getProfile']);
        Route::post('/update', [AdminController::class, 'updateProfile']);
        Route::post('/update-password', [AdminController::class, 'updatePassword']);
    });

    Route::group(['prefix'  =>  '/quyen'], function () {
        Route::get('/', [QuyenController::class, 'index']);
        Route::post('/data-quyen', [QuyenController::class, 'dataQuyen'])->name('dataQuyen');
        Route::post('/data-chuc-nang', [QuyenController::class, 'dataChucNang'])->name('dataChucNang');
        Route::post('/create', [QuyenController::class, 'store'])->name('quyenStore');
        Route::post('/update', [QuyenController::class, 'update'])->name('quyenUpdate');
        Route::post('/delete', [QuyenController::class, 'destroy'])->name('quyenDelete');
        Route::post('/status', [QuyenController::class, 'status'])->name('quyenStatus');

        Route::post('/phan-quyen', [QuyenController::class, 'phanQuyen'])->name('phanQuyen');
    });

    Route::group(['prefix'  =>  '/khach-hang'], function () {
        Route::get('/', [KhachHangController::class, 'index']);
        Route::get('/data', [KhachHangController::class, 'getDataKhachHang']);
        Route::post('/search', [KhachHangController::class, 'searchDataKhachHang']);
        Route::post('/create', [KhachHangController::class, 'createKhachHang']);
        Route::post('/update', [KhachHangController::class, 'updateKhachHang']);
        Route::post('/status', [KhachHangController::class, 'statusKhachHang']);
        Route::post('/delete', [KhachHangController::class, 'deleteKhachHang']);
        Route::post('/password', [KhachHangController::class, 'updatePasswordClient']);
        Route::post('/avatar', [KhachHangController::class, 'updateAvatar']);
    });

    Route::group(['prefix'  =>  '/blog'], function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/data', [BlogController::class, 'getDataBlog']);
        Route::post('/create', [BlogController::class, 'createBlog']);
        Route::post('/update', [BlogController::class, 'updateBlog']);
        Route::post('/status', [BlogController::class, 'statusBlog']);
        Route::post('/delete', [BlogController::class, 'deleteBlog']);
        Route::post('/avatar', [BlogController::class, 'updateAvatar']);
    });

    Route::group(['prefix'  =>  '/danh-muc'], function () {
        Route::get('/', [DanhMucController::class, 'index']);
        Route::get('/data', [DanhMucController::class, 'getDataDanhMuc']);
        Route::post('/status', [DanhMucController::class, 'statusDanhMuc']);
        Route::post('/create', [DanhMucController::class, 'createDanhMuc']);
        Route::post('/update', [DanhMucController::class, 'updateDanhMuc']);
        Route::post('/delete', [DanhMucController::class, 'deleteDanhMuc']);
    });

    Route::group(['prefix'  =>  '/san-pham'], function () {
        Route::get('/', [SanPhamController::class, 'index']);
        Route::get('/data', [SanPhamController::class, 'getDataSanPham']);
        Route::post('/status', [SanPhamController::class, 'statusSanPham']);
        Route::post('/create', [SanPhamController::class, 'createSanPham']);
        Route::post('/update', [SanPhamController::class, 'updateSanPham']);
        Route::post('/delete', [SanPhamController::class, 'deleteSanPham']);
        Route::post('/avatar', [SanPhamController::class, 'updateAvatar']);
    });

    Route::group(['prefix'  =>  '/nha-cung-cap'], function () {
        Route::get('/', [NhaCungCapController::class, 'index']);
        Route::get('/data', [NhaCungCapController::class, 'getDataNhaCungCap']);
        Route::get('/data-nguyen-lieu/{id}', [NhaCungCapController::class, 'getDataNguyenLieu']);
        Route::post('/create', [NhaCungCapController::class, 'createNhaCungCap']);
        Route::post('/update', [NhaCungCapController::class, 'updateNhaCungCap']);
        Route::post('/status', [NhaCungCapController::class, 'statusNhaCungCap']);
        Route::post('/delete', [NhaCungCapController::class, 'deleteNhaCungCap']);
    });

    Route::group(['prefix'  =>  '/nhap-kho'], function () {
        Route::get('/', [NhapKhoController::class, 'index']);
        Route::post('/create', [NhapKhoController::class, 'createNhapKho']);
        Route::post('/update', [NhapKhoController::class, 'updateNhapKho']);
        Route::post('/status', [NhapKhoController::class, 'statusNhapKho']);
        Route::post('/delete', [NhapKhoController::class, 'deleteNhapKho']);
        Route::post('/tao-hoa-don', [NhapKhoController::class, 'taoHoaDonNhapKho']);
        Route::get('/data', [NhapKhoController::class, 'dataNhapKho']);
        Route::get('/data-nguyen-lieu/{id_nha_cung_cap}', [NhapKhoController::class, 'dataNguyenLieu']);
    });

    Route::group(['prefix'  =>  '/don-hang'], function () {
        Route::get('/', [DonHangController::class, 'index']);
        Route::post('/create', [DonHangController::class, 'createDonHang']);
        Route::post('/update', [DonHangController::class, 'updateDonHang']);
        Route::post('/delete', [DonHangController::class, 'deleteDonHang']);
    });

    Route::group(['prefix'  =>  '/chi-tiet-don-hang'], function () {
        Route::get('/nhap-kho', [HoaDonNhapKhoController::class, 'index']);
        Route::get('/get-data', [HoaDonNhapKhoController::class, 'gethoadonNhapKho']);
        Route::get('/update', [HoaDonNhapKhoController::class, 'updateData']);
    });

    Route::group(['prefix'  =>  '/don-vi'], function () {
        Route::get('/', [DonViController::class, 'index']);
        Route::post('/create', [DonViController::class, 'createDonVi']);
        Route::post('/update', [DonViController::class, 'updateDonVi']);
        Route::post('/delete', [DonViController::class, 'deleteDonVi']);
        Route::get('/data', [DonViController::class, 'dataDonVi']);
    });

    Route::group(['prefix'  =>  '/nguyen-lieu'], function () {
        Route::get('/', [NguyenLieuController::class, 'index']);
        Route::post('/create', [NguyenLieuController::class, 'createNguyenLieu']);
        Route::post('/update', [NguyenLieuController::class, 'updateNguyenLieu']);
        Route::post('/status', [NguyenLieuController::class, 'doiTrangThaiNguyenLieu']);
        Route::get('/data', [NguyenLieuController::class, 'dataNguyenLieu']);
    });

    Route::group(['prefix'  =>  '/su-kien'], function () {
        Route::get('/', [SuKienThuCungController::class, 'index']);
        Route::get('/danh-sach-nguoi-tham-gia', [SuKienThuCungController::class, 'indexDanhSach']);
        Route::post('/create', [SuKienThuCungController::class, 'createSuKien']);
        Route::post('/update', [SuKienThuCungController::class, 'updateSuKien']);
        Route::post('/delete', [SuKienThuCungController::class, 'deleteSuKien']);
        Route::post('/status', [SuKienThuCungController::class, 'doiTrangThaiSuKien']);
        Route::get('/data', [SuKienThuCungController::class, 'dataSuKien']);
        Route::get('/data-danh-sach', [SuKienThuCungController::class, 'dataDanhSachSuKien']);
    });

    Route::group(['prefix' => '/don-hang'], function () {
        Route::get('/', [DonHangController::class, 'indexAdmin']);
        Route::get('/data', [DonHangController::class, 'dataDonHang']);
        Route::post('/change-status', [DonHangController::class, 'changeStatus']);
        Route::post('/delete', [DonHangController::class, 'destroy']);
    });
});

Route::group(['prefix'  =>  '/client', 'middleware' => 'ClientMiddleware'], function () {
    Route::get('/my-account', [KhachHangController::class, 'indexMyAccount']);
    Route::get('/cart', [KhachHangController::class, 'indexCart']);
    Route::post('/add-to-cart', [GioHangController::class, 'addToCart']);
    Route::post('/data-cart', [GioHangController::class, 'dataCart']);
    Route::post('/data-list-cart', [GioHangController::class, 'dataListCart']);
    Route::post('/update-cart', [GioHangController::class, 'updateCart']);
    Route::post('/delete-cart', [GioHangController::class, 'deleteCart']);
    Route::post('/update', [KhachHangController::class, 'updateClient']);
    Route::post('/dat-hang', [KhachHangController::class, 'datHang'])->name('datHang');
    Route::get('/checkout', [KhachHangController::class, 'indexCheckout']);
    Route::post('/su-kien', [KhachHangController::class, 'createSuKien']);
    Route::get('/data-hang', [KhachHangController::class, 'dataHang']);
    Route::post('/chi-tiet-don-hang', [KhachHangController::class, 'chiTietDonHang']);
    Route::post('/search', [KhachHangController::class, 'searchDonHang']);

    Route::get('/don-hang', [GioHangController::class, 'indexDonHang']);
    Route::get('/data-don-hang', [GioHangController::class, 'dataDonHang']);
    Route::post('/update-hinh-thuc-thanh-toan', [GioHangController::class, 'updateThanhToan']);
});
Route::get('/', [KhachHangController::class, 'indexClient']);
Route::post('/search-product', [KhachHangController::class, 'searchProduct']);
Route::get('/check-login', [KhachHangController::class, 'checkLogin']);
Route::get('/login-register', [KhachHangController::class, 'indexLoginRegister']);
Route::post('/login', [KhachHangController::class, 'actionLoginClient']);
Route::post('/register', [KhachHangController::class, 'createRegister']);
Route::get('/contact', [KhachHangController::class, 'indexContact']);
Route::get('/blog', [KhachHangController::class, 'indexBlog']);
Route::post('/blog/data', [KhachHangController::class, 'getDataBlog']);
Route::get('/shop', [KhachHangController::class, 'indexShop']);
Route::post('/shop/data', [KhachHangController::class, 'getDataShop']);
Route::post('/shop/data-all', [KhachHangController::class, 'getDataShopAll']);
Route::get('/single-product/{id}', [KhachHangController::class, 'indexSingleProduct']);
Route::post('/single-product/data', [KhachHangController::class, 'getDataSingleProduct']);
Route::get('/logout', [KhachHangController::class, 'actionLogout']);
Route::post('/send-contact', [ContactController::class, 'sendContact']);
Route::get('/single-blog/{id}', [KhachHangController::class, 'indexSingleBlog']);
Route::get('/su-kien', [KhachHangController::class, 'indexSuKien']);
Route::get('/su-kien/data', [KhachHangController::class, 'getDataSuKien']);


Route::get('/kich-hoat-tai-khoan/{id}', [KhachHangController::class, 'kichHoat']);
Route::get('/reset-password', [KhachHangController::class, 'resetPassword']);
Route::get('/doi-mat-khau/{id}', [KhachHangController::class, 'viewDoiMatKhau']);
Route::post('/doi-mat-khau', [KhachHangController::class, 'doiMatKhau'])->name('doiMatKhau');
Route::get('/reset-password', [KhachHangController::class, 'viewResetPassword']);
Route::post('/reset-password', [KhachHangController::class, 'resetPassword'])->name('resetPassword');
Route::get('/auto-thanh-toan', [ThanhToanController::class, 'index']);

Route::get('/transactions', [TransactionController::class, 'transaction']);

@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    Thêm Mới Sự Kiện
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="">Tên Sự Kiện</label>
                            <input v-on:keyup="slugSuKien()" v-model="add.ten_su_kien" type="text" class="form-control mt-2 ">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Slug Sự Kiện</label>
                            <input v-model="slug_su_kien" disabled type="text" class="form-control mt-2 ">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Số Lượng Người Tham Gia</label>
                            <input v-model="add.so_nguoi_tham_gia" type="number" class="form-control mt-2 ">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Địa Chỉ</label>
                            <input v-model="add.dia_chi" type="text" class="form-control mt-2 ">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Thời Gian Bắt Đầu</label>
                            <input v-model="add.thoi_gian_bat_dau" type="date" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Thời Gian Kết Thúc</label>
                            <input v-model="add.thoi_gian_ket_thuc" type="date" class="form-control mt-2">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Tình Trạng</label>
                            <select v-model="add.tinh_trang" class="form-control">
                                <option value="0">Chưa mở</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="">Mô Tả</label></label>
                            <textarea v-model="add.mo_ta" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-end" v-on:click="addSuKien()">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    Danh Sách Sự Kiện
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle">#</th>
                                    <th class="text-center align-middle">Tên Sự Kiện</th>
                                    <th class="text-center align-middle">Mô Tả</th>
                                    <th class="text-center align-middle">Địa Chỉ</th>
                                    <th class="text-center align-middle">Số Lượng Tham Gia</th>
                                    <th class="text-center align-middle">Thời Gian Bắt Đầu</th>
                                    <th class="text-center align-middle">Thời Gian Kết Thúc</th>
                                    <th class="text-center align-middle">Tình Trạng</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">@{{key + 1}}</th>
                                        <td class="text-center align-middle">@{{value.ten_su_kien}}</td>
                                        <td class="text-center align-middle"><i data-bs-toggle='modal' data-bs-target='#moTaNganModal' v-on:click='edit = Object.assign({}, value)' class="fa-solid fa-info fa-2x text-primary"></i></td>
                                        <td class="text-center align-middle">@{{value.dia_chi}}</td>
                                        <td class="text-center align-middle">@{{value.so_nguoi_tham_gia}}</td>
                                        <td class="text-center align-middle">@{{value.thoi_gian_bat_dau}}</td>
                                        <td class="text-center align-middle">@{{value.thoi_gian_ket_thuc}}</td>
                                        <td class="text-center align-middle">
                                            <template v-if="value.tinh_trang == 0">
                                                <button class="btn btn-warning" v-on:click="status(value)" style="width: 100px;">Chưa mở</button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-success" v-on:click="status(value)" style="width: 100px;">Đã mở</button>
                                            </template>
                                        </td>
                                        <td class='text-center text-nowrap align-middle' style="width: 200px;">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-edit" style="margin-left: 20%;"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" v-on:click='edit = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#updateModal'>Cập Nhật</a></li>
                                                    <li><a class="dropdown-item" v-on:click='del = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#deleteModal'>Xóa</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class='modal fade' id='deleteModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                            aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Xóa</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Bạn có muốn xóa <b>@{{ del.ten_su_kien }}</b>này không?</p>
                                        <p><b>Lưu ý:</b> Thao tác này không thể hoàn tác!!!</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary'
                                            data-bs-dismiss='modal'>Close</button>
                                        <button v-on:click='destroy()' data-bs-dismiss='modal' type='button'
                                            class='btn btn-danger'>Xác nhận xóa</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='modal fade' id='updateModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                            aria-hidden='true'>
                            <div class='modal-dialog modal-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Cập nhật</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <div class="row">
                                            <div class="col">
                                                <label for="">Tên Sự Kiện</label>
                                                <input v-on:keyup="editSlugTieuDe()" v-model="edit.ten_su_kien" type="text" class="form-control mt-2 ">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Slug Sự Kiện</label>
                                                <input v-model="edit.slug_su_kien" disabled type="text" class="form-control mt-2 ">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Số Lượng Người Tham Gia</label>
                                                <input v-model="edit.so_nguoi_tham_gia" type="number" class="form-control mt-2 ">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Địa Chỉ</label>
                                                <input v-model="edit.dia_chi" type="text" class="form-control mt-2 ">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Thời Gian Bắt Đầu</label>
                                                <input v-model="edit.thoi_gian_bat_dau" type="date" class="form-control mt-2">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Thời Gian Kết Thúc</label>
                                                <input v-model="edit.thoi_gian_ket_thuc" type="date" class="form-control mt-2">
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Tình Trạng</label>
                                                <select v-model="edit.tinh_trang" class="form-control">
                                                    <option value="0">Chưa mở</option>
                                                    <option value="1">Đã mở</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col">
                                                <label for="">Mô Tả</label></label>
                                                <textarea v-model="edit.mo_ta" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary'
                                            data-bs-dismiss='modal'>Close</button>
                                        <button id='capNhat' v-on:click='update()' type='button'
                                            class='btn btn-primary' data-bs-dismiss='modal'>Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='modal fade' id='moTaNganModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                            aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Mô Tả</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <textarea rows="5" class="form-control">@{{edit.mo_ta}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new ChildVue({
            el      :   '#app',
            data    :   {
                add     : {'tinh_trang' : 0},
                list    : [],
                slug_su_kien : "",
                del : {},
                edit : {},
            },
            created()   {
                this.loadData();
            },
            methods :   {
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                        .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },
                slugSuKien() {
                    this.slug_su_kien = this.toSlug(this.add.ten_su_kien);
                    this.add.slug_su_kien = this.slug_su_kien;
                },
                editSlugTieuDe() {
                    this.edit.slug_su_kien = this.toSlug(this.edit.ten_su_kien);
                },
                addSuKien() {
                    axios
                        .post('/admin/su-kien/create', this.add)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add = {};
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                loadData() {
                    axios
                        .get('/admin/su-kien/data')
                        .then((res) => {
                            this.list = res.data.data
                        });
                },
                status(value) {
                    axios
                        .post('/admin/su-kien/status', value)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                destroy() {
                    axios
                        .post('/admin/su-kien/delete', this.del)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                update() {
                    axios
                        .post('/admin/su-kien/update', this.edit)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                            } else {
                                toastr.error(res.data.message);
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
            },
        });
    </script>
@endsection

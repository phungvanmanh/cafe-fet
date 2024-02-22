@extends('admin.share.master')
@section('noi_dung')
<div class="row" >
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h5><b>Danh Sách Khách Hàng</b></h5>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Thêm Mới</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle text-center">Tìm kiếm</th>
                                <th colspan="6">
                                    <input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control">
                                </th>
                                <th class="text-center text-white">
                                    <button class="btn btn-info" v-on:click="search()">Tìm Kiếm</button>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                   #
                                </th>
                                <th class="text-center align-middle text-nowrap">Họ Và Tên</th>
                                <th class="text-center align-middle text-nowrap">Địa Chỉ</th>
                                <th class="text-center align-middle text-nowrap">Số Điện Thoại</th>
                                <th class="text-center align-middle text-nowrap">Email</th>
                                <th class="text-center align-middle text-nowrap">Trạng Thái</th>
                                <th class="text-center align-middle text-nowrap">Hình ảnh</th>
                                <th class="text-center align-middle text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list_khach_hang">
                                <tr>
                                    <th class="text-center align-middle">
                                        @{{key + 1}}
                                    </th>
                                    <td class="align-middle">@{{ value.full_name}}</td>
                                    <td class='text-center align-middle text-nowrap'><i class="fa-solid fa-info fa-2x text-primary" data-bs-toggle="modal" data-bs-target="#addressModal" v-on:click="edit_kh = Object.assign({}, value)"></i></td>
                                    <td class="align-middle text-center">@{{ value.so_dien_thoai}}</td>
                                    <td class="align-middle">@{{ value.email == null ? 'Chưa có' : value.email}}</td>
                                    <td class='text-center align-middle text-nowrap'>
                                        <template v-if='value.trang_thai == 1'>
                                            <button v-on:click='doiTrangThai(value)' class='btn btn-primary' style='width: 160px'>Hoạt Động</button>
                                        </template>
                                        <template v-else-if='value.trang_thai == 0'>
                                            <button v-on:click='doiTrangThai(value)' class='btn btn-success' style='width: 160px'>Chưa Kích Hoạt</button>
                                        </template>
                                        <template v-else>
                                            <button v-on:click='doiTrangThai(value)' class='btn btn-danger' style='width: 160px'>Khóa</button>
                                        </template>
                                    </td>
                                    <td class='text-center align-middle text-nowrap'><i class="fa-solid fa-info fa-2x text-primary" data-bs-toggle="modal" data-bs-target="#hinhAnhModal" v-on:click="edit_kh = Object.assign({}, value)"></i></td>
                                    <td class='text-center text-nowrap align-middle' style="width: 200px;">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-edit" style="margin-left: 20%;"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                              <li><a class="dropdown-item" v-on:click='edit_kh = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#updateModal'>Cập Nhật</a></li>
                                              <li><a class="dropdown-item" v-on:click='delete_kh = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#deleteModal'>Xóa</a></li>
                                              <li><a class="dropdown-item" v-on:click='edit_kh = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#avataModal'>Đổi avata</a></li>
                                              <li><a class="dropdown-item" v-on:click='password.id = value.id' data-bs-toggle='modal' data-bs-target='#changePasswordModal'>Đổi mật khẩu</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Thêm Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Họ Lót</label>
                                <input v-model="add_kh.first_name" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tên Khách</label>
                                <input v-model="add_kh.last_name" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Điện Thoại</label>
                                <input v-model="add_kh.so_dien_thoai" type="number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input v-model="add_kh.email" type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật Khẩu</label>
                                <input v-model="add_kh.password" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa Chỉ</label>
                                <input v-model="add_kh.dia_chi" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh</label>
                                <input type="file" class="form-control" v-on:change="readerImage($event, 'add_kh');getFile($event,'file_add')">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng Thái</label>
                                <select v-model="add_kh.trang_thai" class="form-control">
                                    <option value="1">Hoạt Động</option>
                                    <option value="0">Chưa Hoạt Động</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="addKhachHang()">Cập Nhật</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Cập Nhật</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Họ Lót</label>
                                <input v-model="edit_kh.first_name" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tên Khách</label>
                                <input v-model="edit_kh.last_name" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Điện Thoại</label>
                                <input v-model="edit_kh.so_dien_thoai" type="number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input v-model="edit_kh.email" type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa Chỉ</label>
                                <input v-model="edit_kh.dia_chi" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh</label>
                                <input v-model="edit_kh.avatar" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="updateKhachHang()">Cập Nhật</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Xóa Khách Hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Bạn có chắc chắn muốn xóa khách hàng - <b class="text-danger">@{{delete_kh.full_name}}</b> hay không?</h6>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" v-on:click="deleteKhachHang()">Xóa</button>
                        </div>
                    </div>
                    </div>
                </div>
                <div class='modal fade' id='addressModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog model-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Địa Chỉ</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <div class="row">
                                    <div class="col">
                                        <textarea name="" id="" cols="30" rows="5" class="form-control">@{{edit_kh.dia_chi}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='hinhAnhModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog model-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Avatar</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <div class="row mt-3">
                                    <div class="col">
                                        <img v-bind:src="edit_kh.avatar" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='avataModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog model-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Avatar</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <input type="file" class="form-control" v-on:change="readerImage($event, 'edit_kh'); getFile($event,'file_update')">
                                <div class="row mt-3">
                                    <div class="col">
                                        <img v-bind:src="edit_kh.avatar" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary'
                                    data-bs-dismiss='modal'>Đóng</button>
                                <button v-on:click='updateAvatar()' data-bs-dismiss='modal' type='button'
                                    class='btn btn-primary'>Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal fade' id='changePasswordModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog model-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Avatar</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="" class="mb-2">Mật Khẩu Mới</label>
                                        <input type="text" v-model="password.password_new" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="" class="mt-2 mb-2">Nhập Lại Mật Khẩu</label>
                                        <input type="text" v-model="password.re_password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary'
                                    data-bs-dismiss='modal'>Đóng</button>
                                <button v-on:click='chagePassword()' type='button'
                                    class='btn btn-primary'>Cập nhật</button>
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
     $(document).ready(function() {
        new ChildVue({
            el      :       '#app',
            data    :       {
                add_kh          : {'trang_thai' : 1},
                edit_kh         : {},
                delete_kh       : {},
                list_khach_hang : [],
                key_search      : '',
                password        : {},
                file_add        : "",
                file_update     : "",
            },
            created()   {
                this.loadData();
            },
            methods :   {
                readerImage(event, item1) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[item1].avatar = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                },

                getFile(e, item)
                {
                    this[item] = e.target.files[0];
                },

                addKhachHang() {
                    const payload = new FormData();
                    payload.append('avatar', this.file_add);
                    payload.append('first_name', this.add_kh.first_name);
                    payload.append('last_name', this.add_kh.last_name);
                    payload.append('so_dien_thoai', this.add_kh.so_dien_thoai);
                    payload.append('password', this.add_kh.password);
                    payload.append('dia_chi', this.add_kh.dia_chi);
                    payload.append('trang_thai', this.add_kh.trang_thai);
                    payload.append('email', this.add_kh.email);
                    axios
                        .post('/admin/khach-hang/create', payload,
                            {
                                headers:
                                    {
                                        'Content-Type': 'multipart/form-data'
                                    }
                            }
                        )
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_kh = {'trang_thai' : 1, 'avatar' : ''};
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                        });
                },

                updateKhachHang(){
                    axios
                        .post('/admin/khach-hang/update', this.edit_kh)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                $("updateModal").modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                            $("#add").removeAttr("disabled");
                        });
                },

                updateAvatar() {
                    const payload = new FormData();
                    payload.append('id', this.edit_kh.id);
                    payload.append('avatar', this.file_update);
                    axios
                        .post('/admin/khach-hang/avatar', payload,
                            {
                                headers:
                                    {
                                        'Content-Type': 'multipart/form-data'
                                    }
                            }
                        )
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },

                deleteKhachHang(){
                    axios
                        .post('/admin/khach-hang/delete', this.delete_kh)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                $("deleteModal").modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                            $("#add").removeAttr("disabled");
                        });
                },

                loadData(){
                    axios
                        .get('/admin/khach-hang/data')
                        .then((res) => {
                            this.list_khach_hang = res.data.data;
                        });
                },

                search() {
                    var payload = {
                        'key_search'    :   this.key_search
                    }
                    axios
                        .post('/admin/khach-hang/search', payload)
                        .then((res) => {
                            this.list_khach_hang = res.data.list;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },

                doiTrangThai(v) {
                    axios
                        .post('/admin/khach-hang/status', v)
                        .then((res) => {
                            this.loadData();
                            toastr.warning(res.data.message, 'Thành Công!')
                        });
                },

                chagePassword(){
                    axios
                        .post('/admin/khach-hang/password', this.password)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                $('#changePasswordModal').modal('hide');
                                this.password = {};
                            } else {
                                toastr.error(res.data.message, 'Lỗi!');
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                }

            }
        });
    });
</script>
@endsection

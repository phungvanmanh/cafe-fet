@extends('admin.share.master')
@section('noi_dung')
    <div id='app' class='row'>
        <div class='col-12 text-end mb-2'>
            <button type='button' class='btn btn-outline-primary round waves-effect' data-bs-toggle='modal'
                data-bs-target='#createModal'><i class='fa-solid fa-plus'></i> Thêm Mới</button>
        </div>
        <div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-xl'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'> Thêm Mới</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <div class="row">
                            <div class="col-9">
                                <div class='row'>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Họ Tên Lót</label>
                                            <input v-model='add.first_name' type='text' class='form-control'>
                                        </div>
                                    </div>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Tên</label>
                                            <input v-model='add.last_name' type='text' class='form-control'>
                                        </div>
                                    </div>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Số Điện Thoại</label>
                                            <input v-model='add.so_dien_thoai' type='tel' class='form-control'>
                                        </div>
                                    </div>

                                </div>
                                <div class='row'>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Email</label>
                                            <input v-model='add.email' type='email' class='form-control'>
                                        </div>
                                    </div>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Password</label>
                                            <input v-model='add.password' type='text' class='form-control'>
                                        </div>
                                    </div>
                                    <div class='col-4'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Trạng Thái</label>
                                            <select v-model='add.trang_thai' class='form-control'>
                                                <option value='1'>Hiển Thị</option>
                                                <option value='0'>Tạm Tắt</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col">
                                        <div class='mb-1'>
                                            <label class='form-label'>Quyền</label>
                                            <select v-model='add.id_quyen' class='form-control'>
                                                <option value="-1">Vui lòng chọn quyền</option>
                                                <template v-for="(value, key) in list_quyen">
                                                    <option v-bind:value="value.id">@{{ value.ten_quyen }}</option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col'>
                                        <div class='mb-1'>
                                            <label class='form-label'>Avatar</label>
                                            <input type="file" class="form-control"
                                                v-on:change="readerImage($event, 'add');getFile($event,'file_add')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="">Hình ảnh</label>
                                    </div>
                                </div>
                                <img style="width: 258px;height: 171px;object-fit: scale-down"
                                    v-bind:src="add.avatar"alt="">
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                        <button v-on:click='themMoi()' class='btn btn-primary'>Thêm Mới</button>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-12'>
            <div class='card'>
                <div class='card-header'>
                    <h4>Danh Sách Admin</h4>
                </div>
                <div class='card-body'>
                    <div class='row'>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th class='text-center text-nowrap'>#</th>
                                        <th class='text-center text-nowrap'>Họ Tên Lót</th>
                                        <th class='text-center text-nowrap'>Tên</th>
                                        <th class='text-center text-nowrap'>FullName</th>
                                        <th class='text-center text-nowrap'>Email</th>
                                        <th class='text-center text-nowrap'>Số Điện Thoại</th>
                                        <th class='text-center text-nowrap'>Phân Quyền</th>
                                        <th class='text-center text-nowrap'>Avatar</th>
                                        <th class='text-center text-nowrap'>Trạng Thái</th>
                                        <th class='text-center text-nowrap'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for='(value, key) in list'>
                                        <tr>
                                            <th class='text-center align-middle text-nowrap'>@{{ key + 1 }}</th>
                                            <td class='align-middle text-nowrap'>@{{ value.first_name }}</td>
                                            <td class='align-middle text-nowrap'>@{{ value.last_name }}</td>
                                            <td class='align-middle text-nowrap'>@{{ value.full_name }}</td>
                                            <td class='align-middle text-nowrap'>@{{ value.email }}</td>
                                            <td class='text-center align-middle text-nowrap'>@{{ value.so_dien_thoai }}</td>
                                            <td class='align-middle text-nowrap'>
                                                @{{ value.ten_quyen }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <img style="object-fit: scale-down; width: 60px; height: 60px;; border-radius: 50%" class="img-fluid"
                                                    v-bind:src="value.avatar" alt="">
                                            </td>
                                            <td class='text-center align-middle text-nowrap'>
                                                <template v-if='value.trang_thai == 0'>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-danger'
                                                        style='width: 100px'>Tạm Tắt</button>
                                                </template>
                                                <template v-else>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-primary'
                                                        style='width: 100px'>Hiển Thị</button>
                                                </template>
                                            </td>
                                            <td class='text-center text-nowrap align-middle' style="width: 200px;">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-primary dropdown-toggle dropdown-toggle-nocaret"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-edit" style="margin-left: 20%;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item"
                                                                v-on:click='edit = Object.assign({}, value)'
                                                                data-bs-toggle='modal' data-bs-target='#updateModal'>Cập
                                                                Nhật</a></li>
                                                        <li><a class="dropdown-item"
                                                                v-on:click='del = Object.assign({}, value)'
                                                                data-bs-toggle='modal'
                                                                data-bs-target='#deleteModal'>Xóa</a></li>
                                                        <li><a class="dropdown-item"
                                                                v-on:click='edit = Object.assign({}, value)'
                                                                data-bs-toggle='modal' data-bs-target='#avataModal'>Đổi
                                                                avatar</a></li>
                                                        <li><a class="dropdown-item" v-on:click='password.id = value.id'
                                                                data-bs-toggle='modal'
                                                                data-bs-target='#changePasswordModal'>Đổi mật khẩu</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
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
                                        <p>Bạn có muốn xóa <b>@{{ del.full_name }} </b>này không?</p>
                                        <p><b>Lưu ý:</b> Thao tác này không thể hoàn tác!!!</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary'
                                            data-bs-dismiss='modal'>Đóng</button>
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
                                        <div class='row'>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Họ Tên Lót</label>
                                                    <input v-model='edit.first_name' type='text' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Tên</label>
                                                    <input v-model='edit.last_name' type='text' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Số Điện Thoại</label>
                                                    <input v-model='edit.so_dien_thoai' type='tel'
                                                        class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Email</label>
                                                    <input v-model='edit.email' type='email' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Trạng Thái</label>
                                                    <select v-model='edit.trang_thai' class='form-control'>
                                                        <option value='1'>Hiển Thị</option>
                                                        <option value='0'>Tạm Tắt</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='col'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Quyền</label>
                                                    <select v-model='edit.id_quyen' class='form-control'>
                                                        <option value="-1">Vui lòng chọn quyền</option>
                                                        <template v-for="(value, key) in list_quyen">
                                                            <option v-bind:value="value.id">@{{ value.ten_quyen }}</option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary'
                                            data-bs-dismiss='modal'>Đóng</button>
                                        <button id='capNhat' v-on:click='update()' type='button'
                                            class='btn btn-primary' data-bs-dismiss='modal'>Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='modal fade' id='avataModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                            aria-hidden='true'>
                            <div class='modal-dialog model-lg'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Avatar</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <input type="file" class="form-control"
                                            v-on:change="readerImage($event, 'edit'); getFile($event,'file_update')">
                                        <div class="row mt-3">
                                            <div class="col">
                                                <img v-bind:src="edit.avatar" class="img-fluid" alt="">
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
                        <div class='modal fade' id='changePasswordModal' tabindex='-1'
                            aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                                                <input type="text" v-model="password.password_new"
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for="" class="mt-2 mb-2">Nhập Lại Mật Khẩu</label>
                                                <input type="text" v-model="password.re_password"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary'
                                            data-bs-dismiss='modal'>Đóng</button>
                                        <button v-on:click='chagePassword()' data-bs-dismiss='modal' type='button'
                                            class='btn btn-primary'>Cập nhật</button>
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
            el: '#app',
            data: {
                add: {
                    'trang_thai': 1,
                    'id_quyen': -1,
                    avatar: 'https://anhdephd.vn/wp-content/uploads/2022/04/avatar-trang-facebook.jpg'
                },
                list: [],
                list_quyen: [],
                edit: {},
                del: {},
                password: {},
                file_add: "",
                file_update: "",
            },
            created() {
                this.loadData();
                this.loadDataQuyen();
            },
            methods: {
                readerImage(event, item1) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[item1].avatar = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                },

                getFile(e, item) {
                    this[item] = e.target.files[0];
                },

                loadDataQuyen() {
                    axios
                        .get('/admin/data-quyen')
                        .then((res) => {
                            this.list_quyen = res.data.data;
                        });
                },

                loadData() {
                    axios
                        .get('/admin/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },

                doiTrangThai(v) {
                    axios
                        .post('/admin/status', v)
                        .then((res) => {
                            this.loadData();
                            toastr.warning(res.data.message, 'Thành Công!')
                        });
                },

                themMoi() {
                    const payload = new FormData();
                    payload.append('avatar', this.file_add);
                    payload.append('email', this.add.email);
                    payload.append('first_name', this.add.first_name);
                    payload.append('last_name', this.add.last_name);
                    payload.append('so_dien_thoai', this.add.so_dien_thoai);
                    payload.append('trang_thai', this.add.trang_thai);
                    payload.append('id_quyen', this.add.id_quyen);
                    payload.append('password', this.add.password);
                    axios
                        .post('/admin/create', payload, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                                this.add = {
                                    'trang_thai': 1,
                                    'id_quyen': -1,
                                    avatar: 'https://anhdephd.vn/wp-content/uploads/2022/04/avatar-trang-facebook.jpg'
                                };
                                $('#createModal').modal('hide');
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
                },

                updateAvatar() {
                    const payload = new FormData();
                    payload.append('id', this.edit.id);
                    payload.append('avatar', this.file_update);
                    axios
                        .post('/admin/avatar', payload, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
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
                },

                destroy() {
                    axios
                        .post('/admin/delete', this.del)
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

                update() {
                    axios
                        .post('/admin/update', this.edit)
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

                chagePassword() {
                    axios
                        .post('/admin/password', this.password)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.password = {};
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                }
            },
        });
    </script>
@endsection

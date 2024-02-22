@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col pt-2">
                        <h5>Danh sách blog</h5>
                    </div>
                    <div class="col">
                        <button class="float-end btn btn-primary" data-bs-toggle="modal" data-bs-target="#themMoiModal">Thêm
                            mới</button>
                    </div>
                    <div class="modal fade" id="themMoiModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm Mới Blog</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Tiêu Đề</label>
                                            <input v-on:keyup="slugTieuDe()" type="text" v-model="add.tieu_de"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Slug</label>
                                            <input type="text" v-model="slug" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Mô Tả Ngắn</label>
                                            <textarea v-model="add.mo_ta_ngan" class="form-control" cols="30" rows="5"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Mô Tả Ngắn</label>
                                            <textarea v-model="add.mo_ta_chi_tiet" class="form-control" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Tình Trạng</label>
                                            <select v-model="add.tinh_trang" class="form-control">
                                                <option value="1">Hiển Thị</option>
                                                <option value="0">Tạm Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2">Hình Ảnh</label>
                                            <input type="file" class="form-control"
                                                v-on:change="getFile($event,'file_add')">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" v-on:click="themMoi()">Thêm Mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">#</th>
                                <th class="text-center align-middle">Tiêu Đề</th>
                                <th class="text-center align-middle">Mô Tả Ngắn</th>
                                <th class="text-center align-middle">Mô Tả Chi Tiết</th>
                                <th class="text-center align-middle">Hình Ảnh</th>
                                <th class="text-center align-middle">Tình Trạng</th>
                                <th class="text-center align-middle">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list">
                                <tr>
                                    <th class="text-center align-middle text-nowrap">@{{ key + 1 }}</th>
                                    <td class="align-middle text-nowrap">@{{ value.tieu_de }}</td>
                                    <td class="text-center align-middle text-nowrap"><i
                                            class="fa-solid fa-info fa-2x text-primary" v-on:click="edit = value"
                                            data-bs-toggle='modal' data-bs-target='#moTaNganModal'></i></td>
                                    <td class="text-center align-middle text-nowrap"><i
                                            class="fa-solid fa-info fa-2x text-primary" v-on:click="edit = value"
                                            data-bs-toggle='modal' data-bs-target='#moTaChiTietModal'></i></td>
                                    <td class="text-center align-middle text-nowrap">
                                        <img style="width: 250px;height: 250px; object-fit: scale-down"
                                            v-bind:src="value.hinh_anh" alt="...">
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <template v-if='value.tinh_trang == 0'>
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
                                                <li><a class="dropdown-item" v-on:click='edit = Object.assign({}, value)'
                                                        data-bs-toggle='modal' data-bs-target='#updateModal'>Cập Nhật</a>
                                                </li>
                                                <li><a class="dropdown-item" v-on:click='del = Object.assign({}, value)'
                                                        data-bs-toggle='modal' data-bs-target='#deleteModal'>Xóa</a></li>
                                                <li><a class="dropdown-item" v-on:click='edit = Object.assign({}, value)'
                                                        data-bs-toggle='modal' data-bs-target='#avataModal'>Đổi avata</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Tiêu Đề</label>
                                            <input v-on:keyup="editSlugTieuDe()" type="text" v-model="edit.tieu_de"
                                                class="form-control">
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Slug</label>
                                            <input type="text" v-model="edit.slug" disabled class="form-control">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Mô Tả Ngắn</label>
                                            <textarea v-model="edit.mo_ta_ngan" class="form-control" cols="30" rows="5"></textarea>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Mô Tả Ngắn</label>
                                            <textarea v-model="edit.mo_ta_chi_tiet" class="form-control" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <label class="mb-2" for="">Tình Trạng</label>
                                            <select v-model="edit.tinh_trang" class="form-control">
                                                <option value="1">Hiển Thị</option>
                                                <option value="0">Tạm Tắt</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-primary" v-on:click="capNhat()">Cập
                                        Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Bạn có muốn xóa <b class="text-danger"> @{{ del.tieu_de }} </b>này không?</p>
                                    <p><b>Lưu ý:</b> Thao tác này không thể hoàn tác!!!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="button" class="btn btn-danger" v-on:click="xoa()">Xóa</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="moTaNganModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mô Tả Ngắn</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @{{ edit.mo_ta_ngan }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="moTaChiTietModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mô Tả Chi Tiết</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @{{ edit.mo_ta_chi_tiet }}
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
                                            <img v-bind:src="edit.hinh_anh" class="img-fluid" alt="">
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
                list: [],
                add: {
                    'tinh_trang': 1
                },
                del: {},
                edit: {},
                slug: "",
                edit_slug: "",
                file_add: "",
                file_update: "",
            },
            created() {
                this.loadData();
            },
            methods: {
                readerImage(event, item1) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[item1].hinh_anh = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                },

                getFile(e, item) {
                    this[item] = e.target.files[0];
                },

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
                loadData() {
                    axios
                        .get('/admin/blog/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                slugTieuDe() {
                    this.slug = this.toSlug(this.add.tieu_de);
                    this.add.slug = this.slug;
                },
                editSlugTieuDe() {
                    this.edit.slug = this.toSlug(this.edit.tieu_de);
                },
                themMoi() {
                    const payload = new FormData();
                    payload.append('avatar', this.file_add);
                    payload.append('tieu_de', this.add.tieu_de);
                    payload.append('slug', this.add.slug);
                    payload.append('mo_ta_ngan', this.add.mo_ta_ngan);
                    payload.append('mo_ta_chi_tiet', this.add.mo_ta_chi_tiet);
                    payload.append('tinh_trang', this.add.tinh_trang);
                    axios
                        .post('/admin/blog/create', payload, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.add = {
                                        'trang_thai': 1
                                    },
                                    this.loadData();
                                $('#themMoiModal').modal('hide');
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

                updateAvatar() {
                    const payload = new FormData();
                    payload.append('id', this.edit.id);
                    payload.append('avatar', this.file_update);
                    axios
                        .post('/admin/blog/avatar', payload, {
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

                capNhat() {
                    axios
                        .post('/admin/blog/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $("#updateModal").modal('hide');
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
                xoa() {
                    axios
                        .post('/admin/blog/delete', this.del)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $('#deleteModal').modal('hide');
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
                doiTrangThai(v) {
                    axios
                        .post('/admin/blog/status', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                            } else {
                                toastr.error(res.data.message, 'Lỗi!');
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                }
            },
        });
    </script>
@endsection

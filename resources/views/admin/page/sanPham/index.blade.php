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
                        <div class='row'>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Tên Sản Phẩm</label>
                                    <input v-model='add.ten_san_pham' v-on:keyup="slugTieuDe()" type='text' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Slug Sản Phẩm</label>
                                    <input disabled v-model='slug_san_pham' type='text' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Hình Ảnh</label>
                                    <input type="file" class="form-control" v-on:change="getFile($event,'file_add')">
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Số Lượng</label>
                                    <input v-model='add.so_luong' type='number' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Giá Bán</label>
                                    <input v-model='add.gia_ban' type='number' class='form-control'>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class='mb-1'>
                                    <label class='form-label'>Giá Khuyến Mãi</label>
                                    <input v-model='add.gia_khuyen_mai' type='number' class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class='col-6'>
                                <div class='mb-1'>
                                    <label class='form-label'>Trạng Thái</label>
                                    <select v-model='add.trang_thai' class='form-control'>
                                        <option value='1'>Hiển Thị</option>
                                        <option value='2'>Tạm Tắt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class='mb-1'>
                                    <label class='form-label'>Danh Mục</label>
                                    <select v-model='add.id_danh_muc' class='form-control'>
                                        <option value="-1">Vui lòng chọn...</option>
                                        @foreach ($danhMuc as $key => $value)
                                            @if ($value->trang_thai == 1)
                                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-6'>
                                <div class='mb-1'>
                                    <label class='form-label'>Mô Tả Ngắn</label>
                                    <textarea v-model='add.mo_ta_ngan'cols="30" rows="5" class='form-control'></textarea>
                                </div>
                            </div>
                            <div class='col-6'>
                                <div class='mb-1'>
                                    <label class='form-label'>Mô Tả Chi Tiết</label>
                                    <textarea v-model='add.mo_ta_chi_tiet'cols="30" rows="5" class='form-control'></textarea>
                                </div>
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
                    <h4>Danh Sách Sản Phẩm</h4>
                </div>
                <div class='card-body'>
                    <div class='row'>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th class='text-center text-nowrap'>#</th>
                                        <th class='text-center text-nowrap'>Tên Sản Phẩm</th>
                                        <th class='text-center text-nowrap'>Hình Ảnh</th>
                                        <th class='text-center text-nowrap'>Mô Tả Ngắn</th>
                                        <th class='text-center text-nowrap'>Mô Tả Chi Tiết</th>
                                        <th class='text-center text-nowrap'>Số Lượng</th>
                                        <th class='text-center text-nowrap'>Giá Bán</th>
                                        <th class='text-center text-nowrap'>Giá Khuyến Mãi</th>
                                        <th class='text-center text-nowrap'>Danh Mục</th>
                                        <th class='text-center text-nowrap'>Trạng Thái</th>
                                        <th class='text-center text-nowrap'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for='(value, key) in list'>
                                        <tr>
                                            <th class='text-center align-middle'>@{{ key + 1 }}</th>
                                            <td class='align-middle'>@{{ value.ten_san_pham }}</td>
                                            <td class='text-center align-middle'>
                                                <img style='width: 150px;' v-bind:src='value.hinh_anh'
                                                    class='img-thumbnail'>
                                            </td>
                                            <td class="text-center align-middle">
                                                <i data-bs-toggle='modal' data-bs-target='#moTaNganModal' v-on:click='edit = Object.assign({}, value)' class="fa-solid fa-info fa-2x text-primary"></i>
                                            </td>
                                            <td class="text-center align-middle">
                                                <i data-bs-toggle='modal' data-bs-target='#moTaChiTietModal' v-on:click='edit = Object.assign({}, value)' class="fa-solid fa-info fa-2x text-primary"></i>
                                            </td>
                                            <td class="align-middle text-end">@{{ value.so_luong }}</td>
                                            <td class='align-middle text-end'>@{{ value.gia_ban }}</td>
                                            <td class='align-middle text-end'>@{{ value.gia_khuyen_mai }}</td>
                                            <td class='align-middle'>@{{ value.ten_danh_muc }}</td>
                                            <td class='text-nowrap text-center align-middle'>
                                                <template v-if='value.trang_thai == 1'>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-primary'>Hiển Thị</button>
                                                </template>
                                                <template v-else>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-warning'>Tạm Tắt</button>
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
                                                      <li><a class="dropdown-item" v-on:click='edit = Object.assign({}, value)' data-bs-toggle='modal' data-bs-target='#avataModal'>Đổi avata</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
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
                                        <p>Bạn có muốn xóa <b>@{{ del.ten_san_pham }}</b>này không?</p>
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
                                        <div class='row'>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Tên Sản Phẩm</label>
                                                    <input v-model='edit.ten_san_pham' v-on:keyup="editSlugTieuDe()" type='text' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Slug Sản Phẩm</label>
                                                    <input disabled  v-model='edit.slug_san_pham' type='text' class='form-control'>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class='mb-1'>
                                                    <label class='form-label'>Danh Mục</label>
                                                    <select v-model='edit.id_danh_muc' class='form-control'>
                                                        <option value="-1">Vui lòng chọn...</option>
                                                        @foreach ($danhMuc as $key => $value)
                                                            @if ($value->trang_thai == 1)
                                                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Số Lượng</label>
                                                    <input v-model='edit.so_luong' type='number' class='form-control'>
                                                </div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Giá Bán</label>
                                                    <input v-model='edit.gia_ban' type='number' class='form-control'>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class='mb-1'>
                                                    <label class='form-label'>Giá Khuyến Mãi</label>
                                                    <input v-model='edit.gia_khuyen_mai' type='number' class='form-control'>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-6'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Mô Tả Ngắn</label>
                                                    <textarea v-model='edit.mo_ta_ngan'cols="30" rows="5" class='form-control'></textarea>
                                                </div>
                                            </div>
                                            <div class='col-6'>
                                                <div class='mb-1'>
                                                    <label class='form-label'>Mô Tả Chi Tiết</label>
                                                    <textarea v-model='edit.mo_ta_chi_tiet'cols="30" rows="5" class='form-control'></textarea>
                                                </div>
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
                                        <h5 class='modal-title' id='exampleModalLabel'>Mô Tả Ngắn</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <textarea rows="5" class="form-control">@{{edit.mo_ta_ngan}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='modal fade' id='moTaChiTietModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                            aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Mô Tả Chi Tiết</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'
                                            aria-label='Close'></button>
                                    </div>
                                    <div class='modal-body'>
                                        <textarea rows="5" class="form-control">@{{edit.mo_ta_chi_tiet}}</textarea>
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
                                        <input type="file" class="form-control" v-on:change="readerImage($event, 'edit'); getFile($event,'file_update')">
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
    </div>
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                add             : {'id_danh_muc' : -1, 'trang_thai' : 1},
                list            : [],
                edit            : {},
                del             : {},
                file_add        : "",
                file_update     : "",
                slug_san_pham   : "",

            },
            created() {
                this.loadData();
            },
            methods: {
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
                slugTieuDe() {
                    this.slug_san_pham = this.toSlug(this.add.ten_san_pham);
                    this.add.slug_san_pham  = this.slug_san_pham;
                },
                editSlugTieuDe() {
                    this.edit.slug_san_pham = this.toSlug(this.edit.ten_san_pham);
                },
                readerImage(event, item1) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[item1].hinh_anh = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                },

                getFile(e, item)
                {
                    this[item] = e.target.files[0];
                },

                loadData() {
                    axios
                        .get('/admin/san-pham/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },

                doiTrangThai(v) {
                    axios
                        .post('/admin/san-pham/status', v)
                        .then((res) => {
                            this.loadData();
                            toastr.warning('Đã đổi trạng thái', 'Thành Công!')
                        });
                },

                themMoi() {
                    const payload = new FormData();
                    payload.append('avatar', this.file_add);
                    payload.append('ten_san_pham', this.add.ten_san_pham);
                    payload.append('slug_san_pham', this.add.slug_san_pham);
                    payload.append('mo_ta_ngan', this.add.mo_ta_ngan);
                    payload.append('mo_ta_chi_tiet', this.add.mo_ta_chi_tiet);
                    payload.append('trang_thai', this.add.trang_thai);
                    payload.append('so_luong', this.add.so_luong);
                    payload.append('gia_ban', this.add.gia_ban);
                    payload.append('gia_khuyen_mai', this.add.gia_khuyen_mai);
                    payload.append('id_danh_muc', this.add.id_danh_muc);

                    axios
                        .post('/admin/san-pham/create', payload,
                            {
                                headers:
                                    {
                                        'Content-Type': 'multipart/form-data'
                                    }
                            }
                        )
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã thêm mới', 'Thành công!');;
                                this.loadData();
                                $('#createModal').modal('hide');
                                this.add = {'id_danh_muc' : -1, 'trang_thai' : 1, 'hinh_anh' : ""};
                            } else {
                                toastr.error('Đã thêm mới', 'Thành công!');;
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
                        .post('/admin/san-pham/avatar', payload,
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

                destroy() {
                    axios
                        .post('/admin/san-pham/delete', this.del)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã xóa', 'Thành công!');
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
                        .post('/admin/san-pham/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã cập nhật', 'Thành công!');
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
            },
        });
    </script>
@endsection

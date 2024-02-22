@extends('admin.share.master')
@section('noi_dung')
    <div >
        <div class="row">
            <div class="col-5">
                <div class='card'>
                    <div class='card-header'>
                        Thêm Mới Danh Mục
                    </div>
                    <div class='card-body'>
                        <div class='mb-1'>
                            <label class='form-label'>Tên Danh Mục</label>
                            <input v-model='add.ten_danh_muc' type='text' class='form-control' placeholder="Tên Danh Mục">
                        </div>
                        <div class='mb-1'>
                            <label class='form-label'>Slug Danh Mục</label>
                            <input v-model='add.slug_danh_muc' type='text' class='form-control'
                                placeholder='Nhập Vào Slug Danh Mục'>
                        </div>
                        <label class="mb-1" for="">Danh Mục Cha</label>
                        <select v-model='add.id_danh_muc_cha' class="form-control">
                            <option value="0">Root</option>
                            @foreach ($danhMucCha as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->ten_danh_muc }}</option>
                            @endforeach
                        </select>
                        <div class='mb-1'>
                            <label class='form-label'>Trạng Thái</label>
                            <select v-model='add.trang_thai' class='form-control'>
                                <option value='1'>Hiển Thị</option>
                                <option value='0'>Dừng Hoạt Động</option>
                            </select>
                        </div>
                    </div>
                    <div class='card-footer text-end'>
                        <button v-on:click='themMoi()' class='btn btn-primary'>Thêm Mới</button>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div id='app' class='row'>
                    <div class='col-12'>
                        <div class='card'>
                            <div class='card-header'>
                                Danh Sách Danh Mục
                            </div>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='table-responsive'>
                                        <table class='table table-bordered'>
                                            <thead>
                                                <tr>
                                                    <th class='text-center text-nowrap align-middle'>#</th>
                                                    <th class='text-center text-nowrap align-middle'>Tên Danh Mục</th>
                                                    <th class='text-center text-nowrap align-middle'>Slug Danh Mục</th>
                                                    <th class='text-center text-nowrap align-middle'>Danh Mục Cha</th>
                                                    <th class='text-center text-nowrap align-middle'>Trạng Thái</th>
                                                    <th class='text-center text-nowrap align-middle'>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for='(value, key) in list'>
                                                    <tr>
                                                        <th class='text-center align-middle'>@{{ key + 1 }}</th>
                                                        <td class="align-middle">@{{ value.ten_danh_muc }}</td>
                                                        <td class="align-middle">@{{ value.slug_danh_muc }}</td>
                                                        <td class="align-middle">
                                                            <template v-if="value.id_danh_muc_cha == 0">
                                                                Root
                                                            </template>
                                                            <template v-else>
                                                                @{{ value.ten_danh_muc_cha }}
                                                            </template>
                                                        </td>
                                                        <td class='text-nowrap text-center align-middle'>
                                                            <template v-if='value.trang_thai == 1'>
                                                                <button v-on:click='doiTrangThai(value)'
                                                                    class='btn btn-primary'>Hiển
                                                                    Thị</button>
                                                            </template>
                                                            <template v-else>
                                                                <button v-on:click='doiTrangThai(value)'
                                                                    class='btn btn-warning'>Tạm
                                                                    Tắt</button>
                                                            </template>
                                                        </td>
                                                        <td class='text-center text-nowrap align-middle'>
                                                            <i v-on:click='edit = Object.assign({}, value)'
                                                                class='fa-solid fa-pen-to-square fa-2x text-info'
                                                                data-bs-toggle='modal' data-bs-target='#updateModal'
                                                                style='margin-right: 10px'></i>
                                                            <i v-on:click='del = value'
                                                                class='fa-solid fa-trash fa-2x text-danger'
                                                                data-bs-toggle='modal' data-bs-target='#deleteModal'></i>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class='modal fade' id='deleteModal' tabindex='-1'
                                        aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='exampleModalLabel'>Xóa</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal'
                                                        aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <p>Bạn có muốn xóa <b> @{{ del.ten_danh_muc }} </b>này không?</p>
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
                                    <div class='modal fade' id='updateModal' tabindex='-1'
                                        aria-labelledby='exampleModalLabel' aria-hidden='true'>
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
                                                                <label class='form-label'>Tên Danh Mục</label>
                                                                <input v-model='edit.ten_danh_muc' type='text'
                                                                    class='form-control'>
                                                            </div>
                                                        </div>
                                                        <div class='col-4'>
                                                            <div class='mb-1'>
                                                                <label class='form-label'>Slug Danh Muc</label>
                                                                <input v-model='edit.slug_danh_muc' type='text'
                                                                    class='form-control'>
                                                            </div>
                                                        </div>
                                                        <div class='col-4'>
                                                            <div class='mb-1'>
                                                                <label class='form-label'>Danh Mục Cha</label>
                                                                <select v-model='edit.id_danh_muc_cha'
                                                                    class="form-control">
                                                                    <option value="0">Root</option>
                                                                    @foreach ($danhMucCha as $key => $value)
                                                                        <option value="{{ $value->id }}">
                                                                            {{ $value->ten_danh_muc }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='col'>
                                                            <div class='mb-1'>
                                                                <label class='form-label'>Trạng Thái</label>
                                                                <select v-model='edit.trang_thai' class='form-control'>
                                                                    <option value='1'>Hiển Thị</option>
                                                                    <option value='0'>Tạm Tắt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-secondary'
                                                        data-bs-dismiss='modal'>Close</button>
                                                    <button v-on:click='update()' type='button' class='btn btn-primary'
                                                        data-bs-dismiss='modal'>Cập nhật</button>
                                                </div>
                                            </div>
                                        </div>
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
                    'id_danh_muc_cha': 0
                },
                list: [],
                edit: {},
                del: {},
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .get('/admin/danh-muc/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                doiTrangThai(v) {
                    axios
                        .post('/admin/danh-muc/status', v)
                        .then((res) => {
                            this.loadData();
                            toastr.warning('Đã đổi trạng thái', 'Thành Công!')
                        });
                },
                themMoi() {
                    axios
                        .post('/admin/danh-muc/create', this.add)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');;
                                this.loadData();
                                this.add = {
                                    'trang_thai': 1,
                                    'id_danh_muc_cha': 0
                                };
                            } else {
                                toastr.success(res.data.message, 'Có lỗi!');
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
                        .post('/admin/danh-muc/delete', this.del)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                            } else {
                                toastr.success(res.data.message, 'Có lỗi!');
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
                        .post('/admin/danh-muc/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                            } else {
                                toastr.success(res.data.message, 'Có lỗi!');
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

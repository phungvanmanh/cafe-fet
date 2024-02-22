@extends('admin.share.master')
@section('noi_dung')
    <div class="row" >
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5> Thêm mới nhà cung cấp</h5>
                </div>

                <div class="card-body">
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Mã số thuế</label>
                        <input v-model="add.ma_so_thue" type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tên doanh nghiệp</label>
                        <input v-model="add.ten_doanh_nghiep" type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tên người đại diện</label>
                        <input v-model="add.ten_nguoi_dai_dien" type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Số điện thoại</label>
                        <input v-model="add.so_dien_thoai" type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Email</label>
                        <input v-model="add.email" type="email" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Địa chỉ</label>
                        <input v-model="add.dia_chi" type="text" class="form-control">
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Tình Trang</label>
                        <select class="form-control" v-model="add.trang_thai">
                            <option value="1">Hiển Thị</option>
                            <option value="0">Tạm Tăt</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label class="form-label">Nguyên liệu bán: </label>
                        <button class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#chonNguyenLieuModal">Chọn</button>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="button" v-on:click="addNhaCungCap()">Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5>Danh Sách Nhà Cung Cấp</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Thông Tin</th>
                                    <th class="text-center">Nguyên Liệu</th>
                                    <th class="text-center">Tình Trạng</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle">@{{ key + 1 }}</th>
                                        <td class="align-middle">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Mã số thuế</th>
                                                    <td>@{{ value.ma_so_thue }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Địa chỉ</th>
                                                    <td>@{{ value.dia_chi }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tên công ty</th>
                                                    <td>@{{ value.ten_doanh_nghiep }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Người Đại Diện</th>
                                                    <td>@{{ value.ten_nguoi_dai_dien }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Số điện thoại</th>
                                                    <td>@{{ value.so_dien_thoai }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>@{{ value.email }}</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-eye fa-2x text-secondary" data-bs-toggle="modal"
                                                data-bs-target="#nguyenLieuModal"
                                                v-on:click="loadNguyenLieuEdit(value); edit = value"></i>
                                        </td>
                                        <td class="align-middle text-center text-nowrap">
                                            <button v-on:click="changeStatus(value)" v-if="value.trang_thai == 1"
                                                class="btn btn-primary">Hiển Thị</button>
                                            <button v-on:click="changeStatus(value)" v-else class="btn btn-danger">Tạm
                                                Tắt</button>
                                        </td>
                                        <td class="text-center text-nowrap align-middle">
                                            <button class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#updateModal" v-on:click="edit = value">Cập Nhật</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" v-on:click="destroy = value">Xóa Bỏ</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cập Nhật Nhà Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <input v-model="edit.id" name="id" class="form-control mt-1" type="hidden">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Mã số thuế</label>
                                        <input v-model="edit.ma_so_thue" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Tên doanh nghiệp</label>
                                        <input v-model="edit.ten_doanh_nghiep" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Tên người đại diện</label>
                                        <input v-model="edit.ten_nguoi_dai_dien" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Số điện thoại</label>
                                        <input v-model="edit.so_dien_thoai" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Email</label>
                                        <input v-model="edit.email" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Địa chỉ</label>
                                        <input v-model="edit.dia_chi" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"data-bs-dismiss="modal">Đóng</button>
                                    <button class="btn btn-primary" v-on:click="UpdateNhaCungCap()">Cập Nhật</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xóa Nhà Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Bạn có chắc chắn xóa nhà cung cấp <b class="text-danger">@{{ destroy.ten_doanh_nghiep }}</b> không!!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" v-on:click="DeleteNhaCungCap()">Xác
                                    nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="chonNguyenLieuModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Chọn Nguyên Liệu Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <template v-for="(value, key) in listNguyenLieu">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input v-model="value.choose" class="form-check-input" type="checkbox"
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    @{{ value.ten_nguyen_lieu }}
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" v-on:click="">Cập Nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="nguyenLieuModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xem và Cập Nhật Nguyên Liệu Cung Cấp</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <template v-for="(value, key) in listNguyenLieu">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input v-model="value.choose" v-if="value.choose == true" checked
                                                    class="form-check-input" type="checkbox" id="flexCheckDefault">
                                                <input v-model="value.choose" v-else class="form-check-input"
                                                    type="checkbox" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    @{{ value.ten_nguyen_lieu }}
                                                </label>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="button" class="btn btn-primary" v-on:click="UpdateNhaCungCap()">Cập
                                    Nhật</button>
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
                    'trang_thai': 1
                },
                edit: {},
                destroy: {},
                listNguyenLieu: [],
            },
            created() {
                this.loadData();
                this.loadNguyenLieu();
            },
            methods: {
                loadNguyenLieu() {
                    axios
                        .get('/admin/nguyen-lieu/data')
                        .then((res) => {
                            this.listNguyenLieu = res.data.data;
                        });
                },

                loadNguyenLieuEdit(value) {
                    axios
                        .get('/admin/nha-cung-cap/data-nguyen-lieu/' + value.id)
                        .then((res) => {
                            if (res.data.status) {
                                this.listNguyenLieu = res.data.data;
                                console.log(this.listNguyenLieu);
                            } else {
                                toastr.error(res.data.message, 'Error');
                            }
                        });
                },

                addNhaCungCap() {
                    var payload = {
                        'listNguyenLieu': this.listNguyenLieu,
                        'nhaCungCap': this.add
                    }
                    axios
                        .post('/admin/nha-cung-cap/create', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add = {};
                                this.listNguyenLieu = [];
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })

                        });
                },
                loadData() {
                    axios
                        .get('/admin/nha-cung-cap/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                UpdateNhaCungCap() {
                    var payload = {
                        'listNguyenLieu': this.listNguyenLieu,
                        'nhaCungCap': this.edit
                    }
                    axios
                        .post('/admin/nha-cung-cap/update', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#updateModal').modal('hide');
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
                DeleteNhaCungCap() {
                    axios
                        .post('/admin/nha-cung-cap/delete', this.destroy)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                $('#deleteModal').modal('hide');
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
                changeStatus(v) {
                    axios
                        .post('/admin/nha-cung-cap/status', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            }
                        });
                },

            },
        });
    </script>
@endsection

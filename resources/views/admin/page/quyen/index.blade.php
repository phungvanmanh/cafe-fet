@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <div class="align-middle mt-2">
                                Danh Sách Quyền
                            </div>
                            <button type="button text-end" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#addModal">Thêm mới
                                quyền</button>
                        </div>

                    </div>
                </div>
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thêm mới quyền</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formdata">
                                    <div class="card-body">
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label">Tên Quyền</label>
                                            <input v-model="them_moi.ten_quyen" type="text" name="ten_quyen"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <label class="form-label">Trạng Thái</label>
                                            <select v-model="them_moi.tinh_trang" name="tinh_trang" class="form-control">
                                                <option value="1">Hoạt Động</option>
                                                <option value="0">Tạm Tắt</option>
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button v-on:click="addQuyen()" type="button" class="btn btn-primary">Xác Nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Tên Quyền</th>
                                    <th>Trạng Thái</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(v , k) in list_quyen">
                                    <tr>
                                        <th class="text-center align-middle">@{{ k + 1 }}</th>
                                        <td class="align-middle">@{{ v.ten_quyen }}</td>
                                        <td class="text-center align-middle">
                                            <button v-on:click="statusQuyen(v)" v-if="v.tinh_trang == 1" style="width:100px"
                                                class="btn btn-success">Hoạt Động</button>
                                            <button v-on:click="statusQuyen(v)" v-else style="width:100px"
                                                class="btn btn-danger">Tạm Tắt</button>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button v-on:click="chonQuyen(v)" class="btn btn-info">Cấp Quyền</button>
                                            <button v-on:click="update_quyen = Object.assign({}, v)"
                                                class="btn btn-primary ms-2" data-bs-toggle="modal"
                                                data-bs-target="#editModal"><i class="fa-solid fa-pen-to-square"
                                                    style="margin-left: 4px"></i></button>
                                            <button v-on:click="delete_quyen = v" class="btn btn-danger ms-2"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                                    class="fa-solid fa-trash" style="margin-left: 4px"></i></button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xóa Quyền</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc chắn muốn xóa quyền: <b class="text-danger">@{{ delete_quyen.ten_quyen }}</b> này
                                    không?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="deleteQuyen()" type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Xác Nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh Sửa Quyền</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Tên Quyền</label>
                                        <input v-model="update_quyen.ten_quyen" type="text" name="ten_quyen"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Trạng Thái</label>
                                        <select v-model="update_quyen.tinh_trang" class="form-control">
                                            <option value="1">Hoạt Động</option>
                                            <option value="0">Tạm Tắt</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button v-on:click="updateQuyen()" type="button" class="btn btn-primary">Xác
                                        Nhận</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Phân Quyền
                </div>
                <div class="card-body">
                    <div class="row" v-if="quyen_dang_chon.id > 0">
                        <template v-for="(v, k ) in list_chuc_nang">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input v-model="v.check" class="form-check-input" type="checkbox"
                                        :id="v.ten_chuc_nang">
                                    <label class="form-check-label" :for="v.ten_chuc_nang">@{{ v.ten_chuc_nang }}</label>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <button v-on:click="capNhatQuyen()" class="btn btn-primary" style="width: 95%">Cập Nhập Phân
                            Quyền</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                list_quyen: [],
                list_chuc_nang: [],
                them_moi: {
                    'tinh_trang': 1
                },
                delete_quyen: {},
                update_quyen: {},
                quyen_dang_chon: {},
            },
            created() {
                this.getListQuyen();
            },
            methods: {
                chonQuyen(v) {
                    this.quyen_dang_chon = Object.assign({}, v);
                    axios
                        .post('{{ Route('dataChucNang') }}', this.quyen_dang_chon)
                        .then((res) => {
                            this.list_chuc_nang = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                capNhatQuyen() {
                    var payload = {
                        'quyen': this.quyen_dang_chon,
                        'chuc_nang': this.list_chuc_nang,
                    };
                    axios
                        .post('{{ Route('phanQuyen') }}', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                            } else {
                                toastr.error(res.data.message, 'Error');
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                getListQuyen() {
                    axios
                        .post('{{ Route('dataQuyen') }}')
                        .then((res) => {
                            this.list_quyen = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                addQuyen() {
                    axios
                        .post('{{ Route('quyenStore') }}', this.them_moi)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $("#addModal").modal('hide');
                                this.them_moi = {
                                    'tinh_trang': 1
                                };
                                this.getListQuyen();
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
                deleteQuyen() {
                    axios
                        .post('{{ Route('quyenDelete') }}', this.delete_quyen)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.getListQuyen();
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
                updateQuyen() {
                    axios
                        .post('{{ Route('quyenUpdate') }}', this.update_quyen)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $("#editModal").modal('hide');
                                this.getListQuyen();
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
                statusQuyen(payload) {
                    axios
                        .post('{{ Route('quyenStatus') }}', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.getListQuyen();
                            } else {
                                toastr.error(res.data.message);
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

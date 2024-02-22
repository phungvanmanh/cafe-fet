@extends('admin.share.master')
@section('noi_dung')
    <div class="row" >
        <div class="col-md-5">
            <div class='card'>
                <div class='card-header'>
                    Thêm Mới Chi Tiết Nhập Kho
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="align-middle">
                                <th colspan="100%">
                                    <select v-on:change="loadNguyenLieu()" v-model="id_nha_cung_cap" class="form-control">
                                        <option value="0">Chọn nhà cung cấp</option>
                                        <template v-for="(value, key) in list_nha_cung_cap">
                                            <option v-bind:value="value.id">@{{ value.ten_doanh_nghiep }}</option>
                                        </template>
                                    </select>
                                </th>
                            </tr>
                            <tr class="align-middle text-center text-nowrap">
                                <th>#</th>
                                <th>Nguyên Liệu</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(value, key) in list_nguyen_lieu">
                                <tr class="align-middle">
                                    <th class="text-center">@{{ key + 1 }}</th>
                                    <td>@{{ value.ten_nguyen_lieu }}</td>
                                    <td class="text-center">
                                        <button v-on:click="themMoi(value)" class="btn btn-info">Add</button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class='card'>
                <div class='card-header'>
                    Danh Sách Chi Tiết Nhập Kho
                </div>
                <div class='card-body'>
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th class='text-center text-nowrap'>#</th>
                                    <th class='text-center text-nowrap'>Nguyên Liệu</th>
                                    <th class='text-center text-nowrap'>Nhà Cung Cấp</th>
                                    <th class='text-center text-nowrap'>Số lượng</th>
                                    <th class='text-center text-nowrap'>Đơn Giá</th>
                                    <th class='text-center text-nowrap'>Thành Tiền</th>
                                    <th class='text-center text-nowrap'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for='(value, key) in list_tmp_nhap_kho'>
                                    <tr class="align-middle text-center text-nowrap">
                                        <th class='text-center'>@{{ key + 1 }}</th>
                                        <td>@{{ value.ten_nguyen_lieu }}</td>
                                        <td>@{{ value.ten_doanh_nghiep }}</td>
                                        <td class='align-middle'><input v-on:blur="capNhatChiTiet(value)"
                                                v-model="value.so_luong" class="form-control" type="number">
                                        </td>
                                        <td class='align-middle'><input v-on:blur="capNhatChiTiet(value)"
                                                v-model="value.don_gia" class="form-control" type="number">
                                        </td>
                                        <td>@{{ value.thanh_tien }}</td>
                                        <td class='text-nowrap text-center align-middle'>
                                            <i v-on:click='xoaChiTiet(value)'
                                                class='fa-solid fa-trash fa-2x text-danger'></i>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#taoHoaDonModal">Tạo Đơn Nhập
                        Kho</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="taoHoaDonModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tạo Hóa Đơn</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Ghi Chú</label>
                            <textarea class="form-control" v-model="add.ghi_chu" cols="30" rows="10" placeholder="Nhập ghi chú..."></textarea>
                        </div>
                        <div class="mb-2">
                            <label>Tình Trạng</label>
                            <select v-model="add.trang_thai" class="form-control">
                                <option value="-1">Chọn tình trạng thanh toán</option>
                                <option value="0">Chưa Thanh Toán</option>
                                <option value="1">Đã Thanh Toán</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" v-on:click="taoHoaDon()">Tạo hóa Đơn</button>
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
                list_nha_cung_cap: [],
                list_nguyen_lieu: [],
                list_tmp_nhap_kho: [],
                id_nha_cung_cap: 0,
                add: {
                    'trang_thai': -1
                },
            },
            created() {
                this.loadNhaCungCap();
                this.loadTmpNhapKho();
            },
            methods: {
                taoHoaDon() {
                    var payload = {
                        'list_tmp_nhap_kho': this.list_tmp_nhap_kho,
                        'thong_tin': this.add
                    }
                    axios
                        .post('/admin/nhap-kho/tao-hoa-don', payload)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadTmpNhapKho();
                                $('#taoHoaDonModal').modal('hide');
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
                loadNguyenLieu() {
                    axios
                        .get('/admin/nhap-kho/data-nguyen-lieu/' + this.id_nha_cung_cap)
                        .then((res) => {
                            this.list_nguyen_lieu = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                xoaChiTiet(v) {
                    axios
                        .post('/admin/nhap-kho/delete', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadTmpNhapKho();
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

                capNhatChiTiet(v) {
                    axios
                        .post('/admin/nhap-kho/update', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadTmpNhapKho();
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

                loadNhaCungCap() {
                    axios
                        .get('/admin/nha-cung-cap/data')
                        .then((res) => {
                            this.list_nha_cung_cap = res.data.data;
                            console.log(this.list_nha_cung_cap);
                        });
                },

                loadTmpNhapKho() {
                    axios
                        .get('/admin/nhap-kho/data')
                        .then((res) => {
                            this.list_tmp_nhap_kho = res.data.data;
                            if (this.list_tmp_nhap_kho.length > 0) {
                                this.id_nha_cung_cap = this.list_tmp_nhap_kho[0].id_nha_cung_cap;
                                this.loadNguyenLieu();
                            }
                        });
                },

                themMoi(v) {
                    v.id_nha_cung_cap = this.id_nha_cung_cap;
                    axios
                        .post('/admin/nhap-kho/create', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadTmpNhapKho();
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
            },
        });
    </script>
@endsection

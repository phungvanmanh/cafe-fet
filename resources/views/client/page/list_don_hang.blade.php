@extends('client.share.master')
@section('noi_dung')
    <div class="container-fluid">
        <div class="row" id="app">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4><b>DANH SÁCH ĐƠN HÀNG</b></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Tên Người Nhận</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Địa Chỉ</th>
                                    <th>Tình Trạng</th>
                                    <th>Loại Thanh Toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(value, index) in list_don_hang">
                                    <th class="text-center align-middle">@{{ index + 1 }}</th>
                                    <td class="text-center align-middle">@{{ value.ma_don_hang }}</td>
                                    <td class="align-middle">@{{ value.ten_nguoi_nhan }}</td>
                                    <td class="text-center align-middle">@{{ value.so_dien_thoai }}</td>
                                    <td class="align-middle">@{{ value.dia_chi }}</td>
                                    <td class="text-center align-middle">
                                        <template v-if="value.is_thanh_toan == 0">
                                            <button class="btn btn-danger" v-if="value.loai_thanh_toan == 0">Chưa Thanh
                                                Toán</button>
                                            <button class="btn btn-info" v-else>Đang chờ xử lý</button>
                                        </template>
                                        <template v-else>
                                            <button class="btn btn-success">Đã Thanh Toán</button>
                                        </template>
                                    </td>
                                    <td class="text-center align-middle">
                                        <button class="btn btn-warning" v-if="value.loai_thanh_toan == 0" v-on:click="don_hang = Object.assign({}, value)" data-toggle="modal" data-target="#chonLoaiThanhToanModal">Tiền Mặt</button>
                                        <button class="btn btn-primary" v-on:click="don_hang = Object.assign({}, value)" v-else data-toggle="modal" data-target="#chonLoaiThanhToanModal">Online</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="chonLoaiThanhToanModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>HÌNH THỨC THANH TOÁN</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios1" value="0" v-model="don_hang.loai_thanh_toan"
                                            v-on:click="check_thanh_toan = false">
                                        <label class="form-check-label" for="exampleRadios1"
                                            v-on:click="check_thanh_toan = false">
                                            Thanh Toán Tiền Mặt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="exampleRadios"
                                            id="exampleRadios2" value="1" v-model="don_hang.loai_thanh_toan"
                                            v-on:click="check_thanh_toan = true">
                                        <label class="form-check-label" for="exampleRadios2"
                                            v-on:click="check_thanh_toan = true">
                                            Thanh Toán Online
                                        </label>
                                    </div>

                                    <div v-if="check_thanh_toan == true">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Chủ Tài Khoản</th>
                                                    <th>LE THANH TRUONG</th>
                                                </tr>
                                                <tr>
                                                    <th>Số Tài Khoản</th>
                                                    <th>1910061030119</th>
                                                </tr>
                                                <tr>
                                                    <th>Nội Dung Chuyển Khoản</th>
                                                    <th>@{{ don_hang.ma_don_hang }}</th>
                                                </tr>
                                                <tr>
                                                    <th>Số Tiền</th>
                                                    <th>@{{ don_hang.tong_tien }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"
                                        v-on:click="updateHinhThucThanhToan()">CẬP NHẬT THANH TOÁN</button>
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
        new Vue({
            el: "#app",
            data: {
                list_don_hang       : [],
                don_hang            : {},
                check_thanh_toan    : false
            },
            created() {
                this.getAllDonHang();
            },
            methods: {
                getAllDonHang() {
                    axios
                        .get('/client/data-don-hang')
                        .then((res) => {
                            this.list_don_hang = res.data.data;
                        })
                },

                updateHinhThucThanhToan() {
                    axios
                        .post('/client/update-hinh-thuc-thanh-toan', this.don_hang)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $("#chonLoaiThanhToanModal").modal('hide');
                                this.getAllDonHang();
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

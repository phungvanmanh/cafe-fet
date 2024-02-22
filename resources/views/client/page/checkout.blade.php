@extends('client.share.master')
@section('noi_dung')
    <div class="page-section section section-padding">
        <div class="container">
            <!-- Checkout Form s-->
            <form class="checkout-form">
                <div class="row row-50 mbn-40">
                    <div class="col-lg-7">
                        <!-- Billing Address -->
                        <div id="billing-form" class="mb-20">
                            <h4 class="checkout-title">Billing Address</h4>

                            <div class="row">

                                <div class="col-md-6 col-12 mb-5">
                                    <label>Full Name*</label>
                                    <input v-model="add.ten_nguoi_nhan" type="text" placeholder="Full Name">
                                </div>

                                <div class="col-md-6 col-12 mb-5">
                                    <label>Phone no*</label>
                                    <input v-model="add.so_dien_thoai" type="text" placeholder="Phone number">
                                </div>

                                <div class="col-md-6 col-12 mb-5">
                                    <label>Email*</label>
                                    <input v-model="add.email" type="text" placeholder="Email">
                                </div>

                                <div class="col-md-6 col-12 mb-5">
                                    <label>Địa Chỉ*</label>
                                    <input v-model="add.dia_chi" type="text" placeholder="Address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="row">
                            <!-- Cart Total -->
                            <div class="col-12 mb-40">
                                <h4 class="checkout-title">Cart Total</h4>
                                <div class="checkout-cart-total">
                                    <h4>Product <span>Total</span></h4>
                                    <ul>
                                        <template v-for="(value, key) in list">
                                            <li>@{{ value.ten_san_pham }} X @{{ value.so_luong }} <span>@{{ value.thanh_tien }}
                                                    VNĐ</span></li>
                                        </template>
                                    </ul>
                                    <h4>Grand Total <span>@{{ total }} VNĐ </span></h4>
                                </div>
                                <button class="place-order" type="button" data-toggle="modal" data-target="#chonLoaiThanhToanModal" v-on:click="datHang()">Place
                                    order</button>
                            </div>
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
                                                id="exampleRadios1" value="0" v-model="thanh_toan" v-on:click="check_thanh_toan = false">
                                            <label class="form-check-label" for="exampleRadios1"  v-on:click="check_thanh_toan = false">
                                                Thanh Toán Tiền Mặt
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="exampleRadios"
                                                id="exampleRadios2" value="1" v-model="thanh_toan"  v-on:click="check_thanh_toan = true">
                                            <label class="form-check-label" for="exampleRadios2"  v-on:click="check_thanh_toan = true">
                                                Thanh Toán Online
                                            </label>
                                        </div>

                                        <div v-if="check_thanh_toan == true">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Chủ Tài Khoản</th>
                                                        <th>HO PHUOC NGUYEN HOAN</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Số Tài Khoản</th>
                                                        <th>0186915616801</th>
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
                                        <button type="button" class="btn btn-primary" v-on:click="updateHinhThucThanhToan()">CẬP NHẬT THANH TOÁN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- Page Section End -->
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                list        : [],
                total       : 0,
                add         : {},
                don_hang    : {},
                thanh_toan  : 1,
                check_thanh_toan : false
            },
            created() {
                axios
                    .get('/check-login')
                    .then((res) => {
                        if (res.data.status == 200) {
                            this.loadData();
                            this.loadDataGioHang();
                        }
                    });
            },
            methods: {
                loadData() {
                    axios
                        .post('/client/data-list-cart')
                        .then((res) => {
                            this.list = res.data.data;
                            this.total = res.data.total;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                datHang() {
                    this.add.tong_tien = this.total;
                    this.add.ds_sp = this.list;
                    event.preventDefault();
                    axios
                        .post('{{ Route('datHang') }}', this.add)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadData();
                                this.add = {};
                                this.don_hang = res.data.don_hang;
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

                updateHinhThucThanhToan() {
                    this.don_hang.loai_thanh_toan = this.thanh_toan;
                    axios
                        .post('/client/update-hinh-thuc-thanh-toan', this.don_hang)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                $("#chonLoaiThanhToanModal").modal('hide');
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

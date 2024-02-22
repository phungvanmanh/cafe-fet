@extends('client.share.master')
@section('css')
    <style>
        .pro-quantity {
            margin-bottom: 15px;
            overflow: hidden;
            /*-- Quantity --*/
            /*-- Colors --*/
        }

        .pro-quantity .quantity {
            overflow: hidden;
            float: left;
            width: 50%;
            margin-bottom: 5px;
            margin-left: 40px;
        }

        .pro-quantity .quantity h5 {
            font-family: "Poppins", sans-serif;
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: #1a161e;
            float: left;
            margin-right: 15px;
            margin-bottom: 0;
            line-height: 24px;
            padding: 5px 0;
        }

        .pro-quantity .quantity {
            width: 100px;
            padding: 0 30px;
            float: left;
            border: 1px solid #cccccc;
            position: relative;
            border-radius: 50px;
        }

        .pro-quantity .quantity .qtybtn {
            position: absolute;
            top: 0;
            width: 30px;
            text-align: center;
            color: #1a161e;
            cursor: pointer;
        }

        .pro-quantity .quantity .qtybtn i {
            font-size: 10px;
            line-height: 34px;
        }

        .pro-quantity .quantity .qtybtn.dec {
            left: 0;
        }

        .pro-quantity .quantity .qtybtn.inc {
            right: 0;
        }

        .pro-quantity .quantity input {
            width: 100%;
            border: none;
            border-width: 0 1px;
            height: 34px;
            text-align: center;
        }
    </style>
@endsection
@section('noi_dung')
    <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col">

                    <h1>Cart</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="/cart">Cart</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div><!-- Page Banner Section End -->

    <!-- Page Section Start -->
    <div class="page-section section section-padding">
        <div class="container">

            <form action="#">
                <div class="row mbn-40">
                    <div class="col-12 mb-40">
                        <div class="cart-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Image</th>
                                        <th class="pro-title">Product</th>
                                        <th class="pro-price">Price</th>
                                        <th class="pro-quantity">Quantity</th>
                                        <th class="pro-subtotal">Total</th>
                                        <th class="pro-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, key) in list">
                                        <td class="pro-thumbnail"><a href="#"><img v-bind:src="value.hinh_anh"
                                                    alt="" /></a>
                                        </td>
                                        <td class="pro-title"><a href="#">@{{ value.ten_san_pham }}</a></td>
                                        <td class="pro-price"><span class="amount">@{{ value.don_gia }} đ</span></td>
                                        <td class="pro-quantity">
                                            <div class="quantity">
                                                <span v-if="value.so_luong == 1" class="dec qtybtn"><i
                                                        class="ti-minus"></i></span>
                                                <span v-else class="dec qtybtn"
                                                    v-on:click="value.so_luong--; update(value)">
                                                    <i class="ti-minus"></i>
                                                </span>
                                                <input type="text" v-model="value.so_luong">
                                                <span class="inc qtybtn" v-on:click="value.so_luong++; update(value)">
                                                    <i class="ti-plus"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="pro-subtotal">@{{ value.thanh_tien }}</td>
                                        <td class="pro-remove"><a v-on:click="deleteGioHang(value)">×</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 col-12 mb-40">
                        <div class="cart-buttons mb-30">
                            <a href="/shop">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-12 mb-40">
                        <div class="cart-total fix">
                            <h3>Cart Totals</h3>
                            <table>
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span class="amount">@{{ total }} đ</span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td>
                                            <strong><span class="amount">@{{ total }} đ</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="proceed-to-checkout section mt-30">
                                <a href="/client/checkout">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="cart-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Image</th>
                                            <th class="pro-title">Product</th>
                                            <th class="pro-price">Price</th>
                                            <th class="pro-quantity">Quantity</th>
                                            <th class="pro-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(value, key) in list">
                                            <td class="pro-thumbnail"><a href="#"><img v-bind:src="value.hinh_anh"
                                                        alt="" /></a>
                                            </td>
                                            <td class="pro-title"><a href="#">@{{ value.ten_san_pham }}</a></td>
                                            <td class="pro-price"><span class="amount">@{{ value.don_gia }} đ</span></td>
                                            <td class="pro-price"><span class="amount">@{{ value.so_luong }} đ</span></td>
                                            <td class="pro-subtotal">@{{ value.thanh_tien }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Page Section End -->
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                list: [],
                total: 0,
            },
            created() {
                axios
                    .get('/check-login')
                    .then((res) => {
                        if(res.data.status == 200) {
                            this.loadData();
                            this.loadDataGioHang();
                        }
                    });
            },
            methods: {
                deleteGioHang(value) {
                    axios
                        .post('/client/delete-cart', value)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadData();
                                this.loadDataGioHang();
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
                update(value) {
                    axios
                        .post('/client/update-cart', value)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                this.loadDataGioHang();
                                this.loadData();
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
            },
        });
    </script>
@endsection

@extends('client.share.master')
@section('noi_dung')
    @php
        $user = Auth::guard('khach_hang')->user();
    @endphp
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col">

                    <h1>My Account</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="/my-account">My Account</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div><!-- Page Banner Section End -->

    <!-- Page Section Start -->
    <div class="page-section section section-padding">
        <div class="container">
            <div class="row mbn-30">

                <!-- My Account Tab Menu Start -->
                <div class="col-lg-3 col-12 mb-30">
                    <div class="myaccount-tab-menu nav" role="tablist">
                        <a href="#orders" data-toggle="tab"><i class="fa fa-cart-arrow-down"></i> Orders</a>

                        <a href="#payment-method" data-toggle="tab"><i class="fa fa-credit-card"></i> Payment
                            Method</a>
                        <a href="#account-info" data-toggle="tab"><i class="fa fa-user"></i> Account Details</a>
                        <a href="/logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                </div>
                <!-- My Account Tab Menu End -->

                <!-- My Account Tab Content Start -->
                <div class="col-lg-9 col-12 mb-30">
                    <div class="tab-content" id="myaccountContent">
                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade show active" id="orders" role="tabpanel">
                            <div class="myaccount-content">
                                <h3>Orders</h3>

                                <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="align-middle text-center">Tìm kiếm</th>
                                                <th colspan="3">
                                                    <input v-model="key_search" v-on:keyup.enter="search()" type="text" class="form-control">
                                                </th>
                                                <th class="text-center text-white">
                                                    <button class="btn btn-info" v-on:click="search()">Tìm Kiếm</button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>Mã Đơn Hàng</th>
                                                <th>Tổng Tiền</th>
                                                <th>Thanh Toán</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr v-for="(v,k) in list_hang">
                                                <td>@{{k+1}}</td>
                                                <td>@{{v.ma_don_hang}}</td>
                                                <td>@{{v.tong_tien}}</td>
                                                <td>
                                                    <span v-if="v.is_thanh_toan" class="text-success">Đã Thanh Toán</span>
                                                    <span v-else class="text-danger">Chưa Thanh Toán</span>

                                                </td>
                                                <td><a class="btn btn-dark btn-round" data-toggle="modal"
                                                        data-target="#exampleModal" @click="chiTiet(v)">Chi Tiết</a></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Chi Tiết Đơn Hàng</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class='table table-bordered'>
                                                    <thead>

                                                        <tr>
                                                            <th class='text-center text-nowrap'>#</th>
                                                            <th class='text-center text-nowrap'>Tên Sản Phẩm</th>
                                                            <th class='text-center text-nowrap'>Hình Ảnh</th>
                                                            <th class='text-center text-nowrap'>Số Lượng</th>
                                                            <th class='text-center text-nowrap'>Đơn Giá</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <template v-for='(value, key) in list_chi_tiet_hang'>
                                                            <tr>
                                                                <th class='text-center align-middle'>@{{ key + 1 }}</th>
                                                                <td class='align-middle'>@{{ value.ten_san_pham }}</td>
                                                                <td class='text-center align-middle'>
                                                                    <img style='width: 150px;' v-bind:src='value.hinh_anh'
                                                                        class='img-thumbnail'>
                                                                </td>
                                                                <td class="align-middle text-end">@{{ value.so_luong }}</td>
                                                                <td class='align-middle text-end'>@{{ value.don_gia }}</td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="download" role="tabpanel">
                            <div class="myaccount-content">
                                <h3>Downloads</h3>

                                <div class="myaccount-table table-responsive text-center">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Date</th>
                                                <th>Expire</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Moisturizing Oil</td>
                                                <td>Aug 22, 2018</td>
                                                <td>Yes</td>
                                                <td><a href="#" class="btn btn-dark btn-round">Download File</a></td>
                                            </tr>
                                            <tr>
                                                <td>Katopeno Altuni</td>
                                                <td>Sep 12, 2018</td>
                                                <td>Never</td>
                                                <td><a href="#" class="btn btn-dark btn-round">Download File</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="payment-method" role="tabpanel">
                            <div class="myaccount-content">
                                <h3>Payment Method</h3>

                                <p class="saved-message">You Can't Saved Your Payment Method yet.</p>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->

                        <!-- Single Tab Content Start -->
                        <div class="tab-pane fade" id="account-info" role="tabpanel">
                            <div class="myaccount-content">
                                <h3>Account Details</h3>

                                <div class="account-details-form">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model="edit.first_name" placeholder="First Name" type="text">
                                            </div>

                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model="edit.last_name" placeholder="Last Name" type="text">
                                            </div>

                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model="edit.email" disabled placeholder="Email Address"
                                                    type="email">
                                            </div>

                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model="edit.dia_chi" placeholder="Address" type="text">
                                            </div>

                                            <div class="col-lg-12 col-12 mb-30">
                                                <input v-model="edit.so_dien_thoai" placeholder="Address" type="text">
                                            </div>

                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model = "password.password_new" placeholder="New Password"
                                                    type="password">
                                            </div>

                                            <div class="col-lg-6 col-12 mb-30">
                                                <input v-model = "password.re_password" placeholder="Confirm Password"
                                                    type="password">
                                            </div>

                                            <div class="col-12">
                                                <button type="submit" v-on:click="updateClient($event)"
                                                    class="btn btn-dark btn-round btn-lg">Save Changes</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Single Tab Content End -->
                    </div>
                </div>
                <!-- My Account Tab Content End -->

            </div>
        </div>
    </div><!-- Page Section End -->
@endsection
@section('js')
    <script>
        var user = <?php echo json_encode($user); ?>;
        new ChildVue({
            el: '#app',
            data: {
                edit: {},
                password: {},
                file: '',
                edit: {},
                file_update: '',
                list_hang:[],
                list_chi_tiet_hang:[],
                key_search:'',
            },
            created() {
                axios
                .get('/check-login')
                .then((res) => {
                    if(res.data.status == 200) {
                            this.edit = user;
                            this.loadDataGioHang();
                            this.loadDataAll();
                            this.getDataHang();
                        }
                    });
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

                chagePassword() {
                    this.password.id = this.edit.id;
                    axios
                        .post('/client/password', this.password)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.password = {};
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
                updateClient(event) {
                    event.preventDefault();
                    const payload = new FormData();
                    payload.append('id', this.edit.id);
                    payload.append('first_name', this.edit.first_name);
                    payload.append('last_name', this.edit.last_name);
                    payload.append('so_dien_thoai', this.edit.so_dien_thoai);
                    payload.append('password_new', this.password.password_new);
                    payload.append('re_password', this.password.re_password);
                    axios
                        .post('/client/update', payload, {
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
                getDataHang(){
                    axios
                        .get('/client/data-hang')
                        .then((res) => {
                            this.list_hang= res.data.data;
                        });
                },
                chiTiet(v){
                    axios
                        .post('/client/chi-tiet-don-hang', v)
                        .then((res) => {
                            if(res.data.status) {
                               this.list_chi_tiet_hang= res.data.data;
                            } else {
                                $('#exampleModal').modal('hide');
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                search() {
                    var payload = {
                        'key_search'    :   this.key_search
                    }
                    axios
                        .post('/client/search', payload)
                        .then((res) => {
                            this.list_hang = res.data.data;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
            },
        });
    </script>
@endsection

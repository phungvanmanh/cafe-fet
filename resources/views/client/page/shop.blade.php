@extends('client.share.master')
@section('noi_dung')
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col">

                    <h1>Shop</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="/shop">Shop</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="page-section section section-padding" >
        <div class="container">

            <div class="row">

                <div class="col-12">
                    <div class="product-show">
                        <h4>Show:</h4>
                        <select v-on:change="loadDataAll()" v-model="so_luong.so_luong_get">
                            <option value="8">8</option>
                            <option value="12">12</option>
                            <option value="16">16</option>
                        </select>
                    </div>
                </div>

                <template v-for="(value, key) in currentItems">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40 d-flex">

                        <div class="product-item">
                            <div class="product-inner">

                                <div class="image">
                                    <img v-bind:src="value.hinh_anh">

                                    <div class="image-overlay">
                                        <div class="action-buttons">
                                            <button v-on:click="themGioHang(value)">add to cart</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">

                                    <div class="content-left">

                                        <h4 class="title"><a
                                                v-bind:href="'/single-product/' + value.id">@{{ value.ten_san_pham }}</a></h4>

                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>

                                        <h5 class="size">Số Lượng: <span>@{{ value.so_luong }}</span></h5>
                                        <h5 class="color"></h5>

                                    </div>

                                    <div class="content-right">
                                        <span class="price">@{{ value.gia_ban }}</span>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </template>

                <div class="col-12">
                    <ul class="page-pagination">
                        <li v-if="currentPage > 1"><a v-on:click="previousPage"><i class="fa fa-angle-left"></i></a></li>
                        <li v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                            <a v-on:click="changePage(page)">@{{ page }}</a>
                        </li>
                        <li v-if="currentPage < totalPages"><a v-on:click="nextPage"><i class="fa fa-angle-right"></i></a>
                        </li>
                    </ul>
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
                so_luong: {
                    'so_luong_get': 8
                },
                list_all: [],
                currentPage: 1,
            },
            computed: {
                currentItems() {
                    const startIndex = (this.currentPage - 1) * this.so_luong.so_luong_get;
                    const endIndex = startIndex + this.so_luong.so_luong_get;
                    return this.list_all.slice(startIndex, endIndex);
                },

                totalPages() {
                    return Math.ceil(this.list_all.length / this.so_luong.so_luong_get);
                },
            },
            created() {
                axios
                    .get('/check-login')
                    .then((res) => {
                            if(res.data.status == 200) {
                                this.loadDataGioHang();
                            }
                        });
                this.loadDataAll();

            },
            methods: {
                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                changePage(page) {
                    this.currentPage = page;
                },

                async themGioHang(value) {
                    value.so_luong_mua = 1;
                    await axios
                        .post('/client/add-to-cart', value)
                        .then((res) => {
                            if (res.data.status == undefined) {
                                toastr.error('Bạn cần đăng nhập hệ thống trước!');
                                setTimeout(() => {
                                    window.location.href = "/login-register"
                                }, 1000);
                            } else {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                    this.loadDataGioHang();

                                } else {
                                    toastr.error(res.data.message);
                                }
                            }
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

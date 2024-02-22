@extends('client.share.master')
@section('noi_dung')
    <!-- Page Section Start -->
    <div class="page-section section section-padding">
        <div class="container">
            <div class="row row-30 mbn-50">

                <div class="col-12">
                    <div class="row row-20 mb-10">

                        <div class="col-lg-6 col-12 mb-40">

                            <div class="pro-large-img mb-10 fix easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                                <a href="/assets_client/images/product/product-zoom-1.jpg">
                                    <img v-bind:src="product.hinh_anh" alt="" />
                                </a>
                            </div>
                            <!-- Single Product Thumbnail Slider -->
                        </div>

                        <div class="col-lg-6 col-12 mb-40">
                            <div class="single-product-content">

                                <div class="head">
                                    <div class="head-left">

                                        <h3 class="title">@{{ product.ten_san_pham }}</h3>

                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>

                                    </div>

                                    <div class="head-right">
                                        <span class="price">@{{ product.gia_ban }}</span>
                                    </div>
                                </div>

                                <div class="description">
                                    <p>@{{ product.mo_ta_chi_tiet }}</p>
                                </div>

                                <div class="quantity-colors">
                                    <div class="quantity">
                                        <h5>Quantity:</h5>
                                        <div class="pro-qty">
                                            <span class="dec qtybtn" v-on:click="so_luong_mua--">
                                                <i class="ti-minus"></i>
                                            </span>
                                            <input type="text" v-model="so_luong_mua">
                                            <span class="inc qtybtn" v-on:click="so_luong_mua++">
                                                <i class="ti-plus"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="actions">
                                    <button v-on:click="themGioHang()"><i class="ti-shopping-cart"></i><span>ADD TO
                                            CART</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- Page Section End -->
    <div class="section section-padding pt-0">
        <div class="container">
            <div class="row">

                <div class="section-title text-left col col mb-30">
                    <h1>Related Product</h1>
                </div>

                <div class="related-product-slider related-product-slider-1 col-12 p-0 slick-initialized slick-slider">
                    <button type="button" class="slick-prev slick-arrow" style=""><i
                            class="fa fa-angle-left"></i></button>

                    <div class="slick-list draggable">
                        <div class="slick-track" style="opacity: 1; width: 4200px; transform: translate3d(-2100px, 0px, 0px);">
                            <template v-for="(value, index) in list_lien_quan">
                                <div class="col slick-slide slick-cloned" data-slick-index="-4" aria-hidden="true"
                                style="width: 300px;" tabindex="-1">
                                <div class="product-item">
                                    <div class="product-inner">
                                        <div class="image">
                                            <img v-bind:src="value.hinh_anh" alt="">
                                            {{-- <div class="image-overlay">
                                                <div class="action-buttons">
                                                    <button tabindex="-1">add to cart</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h4 class="title"><a v-bind:href="'/single-product/' + value.id" tabindex="-1">@{{ value.ten_san_pham }}</a></h4>
                                                <div class="ratting">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">@{{ value.gia_ban }} vnđ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </template>
                        </div>
                    </div>
                    <button type="button" class="slick-next slick-arrow" style=""><i
                            class="fa fa-angle-right"></i></button>
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
                id: 0,
                product: {},
                so_luong_mua: 1,
                list_lien_quan : []
            },
            created() {
                var currentURL = window.location.href;
                var urlParts = currentURL.split('/');
                this.id = urlParts[urlParts.length - 1];
                this.loadDetailProduct();
                this.loadDataGioHang();
            },
            methods: {
                loadDetailProduct() {
                    var payload = {
                        'id': this.id
                    }
                    axios
                        .post('/single-product/data', payload)
                        .then((res) => {
                            this.product = res.data.data;
                            this.list_lien_quan = res.data.list;
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                },
                themGioHang() {
                    this.product.so_luong_mua = this.so_luong_mua;
                    axios
                        .post('/client/add-to-cart', this.product)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message);
                                this.loadDataGioHang();
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

            },
        });
    </script>
@endsection

@extends('client.share.master')
@section('noi_dung')
{{-- @include('client.share.slide') --}}
 <!-- Hero Section Start -->
<div class="hero-section section">
    <!-- Hero Slider Start -->
    <div class="hero-slider hero-slider-one fix">
        <div class="hero-item" style="background-image: url(/assets_client/images/hero/hero-1.jpg)">
            <div  style="height: 250px">

            </div>
        </div>
    </div>
</div><!-- Hero Section End -->
<!-- Product Section Start -->
<div class="product-section section section-padding">
    <div class="container">

        <div class="row">
            <div class="section-title text-center col mb-30">
                <h1>Popular Products</h1>
                <p>All popular product find here</p>
            </div>
        </div>

        <div class="row mbn-40">

            {{-- <template v-for="(value, key) in list_all"> --}}
            @foreach ($data as $key => $value)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-40 d-flex">
                    <div class="product-item">
                        <div class="product-inner">
                            <div class="image">
                                <img src="{{$value->hinh_anh}}" alt="" style="height: 300px">
                                <div class="image-overlay">
                                    <div class="action-buttons">
                                        {{-- <button type="submit" v-on:click="themGioHang({!! $value !!})">add to cart</button> --}}
                                    </div>
                                </div>

                            </div>

                            <div class="content">
                                <div class="content-left">
                                    <h5 class="title" ><a href="/single-product/{{$value->id}}" style="font-size: 15px">{{ $value->ten_san_pham }}</a></h5>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                    </div>
                                    <h5 class="size">Số Lượng: <span>{{ $value->so_luong }}</span></h5>
                                    <h5 class="color"></h5>
                                </div>
                                <div class="content-right">
                                    <span class="price">{{ $value->gia_ban }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- </template> --}}

        </div>

    </div>
</div><!-- Product Section End -->
 <!-- Feature Section Start -->
<div class="feature-section bg-theme-two section section-padding fix" style="background-image: url(assets/images/pattern/pattern-dot.png);">
    <div class="container">
        <div class="feature-wrap row justify-content-between mbn-30">

            <div class="col-md-4 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="/assets_client/images/feature/feature-1.png" alt=""></div>
                    <div class="content">
                        <h3>Free Shipping</h3>
                        <p>Start from $100</p>
                    </div>

                </div>
            </div>

            <div class="col-md-4 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="/assets_client/images/feature/feature-2.png" alt=""></div>
                    <div class="content">
                        <h3>Money Back Guarantee</h3>
                        <p>Back within 25 days</p>
                    </div>

                </div>
            </div>

            <div class="col-md-4 col-12 mb-30">
                <div class="feature-item text-center">

                    <div class="icon"><img src="/assets_client/images/feature/feature-3.png" alt=""></div>
                    <div class="content">
                        <h3>Secure Payment</h3>
                        <p>Payment Security</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div><!-- Feature Section End -->

<!-- Blog Section Start -->
<div class="blog-section section section-padding">
    <div class="container">
        <div class="row mbn-40">

            <div class="col-xl-6 col-lg-5 col-12 mb-40">

                <div class="row">
                    <div class="section-title text-left col mb-30">
                        <h1>CLIENTS REVIEW</h1>
                        <p>Clients says abot us</p>
                    </div>
                </div>

                <div class="row mbn-40">

                    <div class="col-12 mb-40">
                        <div class="testimonial-item">
                            <p>Jadusona is one of the most exclusive Baby shop in the wold, where you can find all product for your baby that your want to buy for your baby. I recomanded this shop all of you</p>
                            <div class="testimonial-author">
                                <img src="/assets_client/images/testimonial/testimonial-1.png" alt="">
                                <div class="content">
                                    <h4>Zacquline Smith</h4>
                                    <p>CEO, Momens Group</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-40">
                        <div class="testimonial-item">
                            <p>Jadusona is one of the most exclusive Baby shop in the wold, where you can find all product for your baby that your want to buy for your baby. I recomanded this shop all of you</p>
                            <div class="testimonial-author">
                                <img src="/assets_client/images/testimonial/testimonial-2.png" alt="">
                                <div class="content">
                                    <h4>Nusaha Williams</h4>
                                    <p>CEO, Momens Group</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-xl-6 col-lg-7 col-12 mb-40">

                <div class="row">
                    <div class="section-title text-left col mb-30">
                        <h1>FROM THE BLOG</h1>
                        <p>Find all latest update here</p>
                    </div>
                </div>

                <div class="row mbn-40">

                    <div class="col-12 mb-40">
                        <div class="blog-item">
                            <div class="image-wrap">
                                <h4 class="date">May <span>25</span></h4>
                                <a class="image" href="single-blog.html"><img src="/assets_client/images/blog/blog-1.jpg" alt=""></a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="single-blog.html">Lates and new Trens for baby fashion</a></h4>
                                <div class="desc">
                                    <p>Jadusona is one of the most of a exclusive Baby shop in the</p>
                                </div>
                                <ul class="meta">
                                    <li><a href="#"><img src="/assets_client/images/blog/blog-author-1.jpg" alt="Blog Author">Muhin</a></li>
                                    <li><a href="#">25 Likes</a></li>
                                    <li><a href="#">05 Views</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-40">
                        <div class="blog-item">
                            <div class="image-wrap">
                                <h4 class="date">May <span>20</span></h4>
                                <a class="image" href="single-blog.html"><img src="/assets_client/images/blog/blog-2.jpg" alt=""></a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="single-blog.html">New Collection New Trend all New Style</a></h4>
                                <div class="desc">
                                    <p>Jadusona is one of the most of a exclusive Baby shop in the</p>
                                </div>
                                <ul class="meta">
                                    <li><a href="#"><img src="/assets_client/images/blog/blog-author-2.jpg" alt="Blog Author">Takiya</a></li>
                                    <li><a href="#">25 Likes</a></li>
                                    <li><a href="#">05 Views</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div><!-- Blog Section End -->
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                list_all : [],
            },
            created() {
                axios
                    .get('/check-login')
                        .then((res) => {
                            if(res.data.status == 200) {
                                this.loadDataGioHang();
                                this.loadDataAll();
                            }
                        });
            },
            methods: {
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

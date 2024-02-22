@extends('client.share.master')
@section('noi_dung')
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col">

                    <h1>Blog</h1>
                    <ul class="page-breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="/blog">Blog</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div><!-- Page Banner Section End -->

    <!-- Blog Section Start -->
    <div class="blog-section section section-padding" >
        <div class="container">
            <div class="row">
                <template v-for="(value, key) in list_blog">
                    <div class="col-lg-6 col-12 mb-50">
                        <div class="blog-item">
                            <div class="image-wrap">
                                {{-- <h4 class="date">May <span>25</span></h4> --}}
                                <a class="image" href="single-blog.html"><img v-bind:src="value.hinh_anh"
                                        alt=""></a>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="single-blog.html">@{{ value.tieu_de }}</a></h4>
                                <div class="desc">
                                    <p>@{{ value.mo_ta_ngan }}</p>
                                </div>
                                <ul class="meta">
                                    <li><a href="#"><img src="assets_client/images/blog/blog-author-1.jpg"
                                                alt="Blog Author">Muhin</a></li>
                                    <li><a href="#">25 Likes</a></li>
                                    <li><a href="#">05 Views</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div><!-- Blog Section End -->
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                list_blog: [],
            },
            created() {
                axios
                    .get('/check-login')
                    .then((res) => {
                        if(res.data.status == 200) {
                            this.loadDataGioHang();
                        }
                    });

                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .post('/blog/data')
                        .then((res) => {
                            this.list_blog = res.data.data;
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

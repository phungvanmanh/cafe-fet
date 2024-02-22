<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('client.share.css')
    @yield('css')
</head>

<body>

    <div class="main-wrapper" id="app">
        <div class="header-section section">
            @include('client.share.header')
            <div class="header-bottom header-bottom-one header-sticky">
                <div class="container-fluid">
                    <div class="row menu-center align-items-center justify-content-between">

                        <div class="col mt-15 mb-15">
                            <!-- Logo Start -->
                            <div class="header-logo">
                                <a href="/">
                                    <img src="/logo.jpg" alt="Jadusona">
                                </a>
                            </div><!-- Logo End -->
                        </div>

                        <div class="col order-2 order-lg-3">
                            <!-- Header Advance Search Start -->
                            <div class="header-shop-links">

                                <div class="header-shop-links">

                                    <div class="header-search">
                                        <button id="search" class="search-toggle">
                                            <img src="/assets_client/images/icons/search.png" alt="Search Toggle">
                                            <img class="toggle-close" src="/assets_client/images/icons/close.png" alt="Search Toggle">
                                        </button>
                                        <div class="header-search-wrap">
                                            <form action="/search-product" method="POST">
                                                @csrf
                                              <input name="key" type="text" placeholder="Type and hit enter">
                                              <button type="submit" id="searchProduct"><img src="/assets_client/images/icons/search.png" alt="Search"></button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="header-mini-cart">
                                        @php
                                            $user = Auth::guard('khach_hang')->check();
                                            $khach_hang = Auth::guard('khach_hang')->user();
                                        @endphp
                                        @if ($user)
                                        <a href="/client/cart"><img src="/assets_client/images/icons/cart.png" alt="Cart"> <span
                                                id="data_gio_hang"></span></a>
                                        @endif
                                    </div>
                                </div>

                            </div><!-- Header Advance Search End -->
                        </div>

                        <div class="col order-3 order-lg-2">
                            <div class="main-menu">
                                <nav>
                                    <ul>
                                        <li class="active">
                                            <a href="/">HOME</a>
                                        </li>
                                        <li>
                                            <a href="/shop">SHOP</a>
                                        </li>
                                        <li><a href="/client/cart">Cart</a>
                                        </li>
                                        <li>
                                            <a href="/blog">BLOG</a>
                                        </li>
                                        <li>
                                            <a href="/su-kien">SỰ KIỆN</a>
                                        </li>
                                        <li><a href="/contact">CONTACT</a></li>
                                        <li><a href="/client/don-hang">ĐƠN HÀNG</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="mobile-menu order-12 d-block d-lg-none col"></div>
                    </div>
                </div>
            </div>
            {{-- @include('client.share.menu') --}}
        </div>
        @yield('noi_dung')
        @include('client.share.footer')
    </div>
    @include('client.share.js')
    <script>
        $(document).ready(function() {
            $('#search').on('click', function() {
                $('.header-search-wrap').toggleClass('active');
                $('.search-toggle').toggleClass('active');
            });
            $('$searchProduct').on('click', function() {

            });
        });
        const ChildVue = Vue.extend({
            methods: {
                loadDataGioHang() {
                    axios
                        .post('/client/data-cart')
                        .then((res) => {
                            var data = res.data.data;
                            if(data[0].so_luong != null) {
                                $('#data_gio_hang').text('' + data[0].so_luong + '(' + data[0].tong_tien + ' đ)');
                            } else {
                                $('#data_gio_hang').text('' + 0 + '(' + 0 + ' đ)');
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0], 'Error');
                            });
                        });
                },
                async loadDataAll() {
                    await axios
                        .post('/shop/data-all')
                        .then((res) => {
                            this.list_all = res.data.data;
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
    @yield('js')
</body>

</html>

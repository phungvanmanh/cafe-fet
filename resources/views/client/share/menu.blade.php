<div class="header-bottom header-bottom-one header-sticky" id="app">
    <div class="container-fluid">
        <div class="row menu-center align-items-center justify-content-between">

            <div class="col mt-15 mb-15">
                <!-- Logo Start -->
                <div class="header-logo">
                    <a href="/">
                        <img src="/assets_client/images/logo.png" alt="Jadusona">
                    </a>
                </div><!-- Logo End -->
            </div>

            <div class="col order-2 order-lg-3">
                <!-- Header Advance Search Start -->
                <div class="header-shop-links">

                    <div class="header-shop-links">

                        <div class="header-search">
                            <button v-on:click="toggleActive" :class="{ 'search-toggle': true, 'active': isActive }">
                                <img src="/assets_client/images/icons/search.png" alt="Search Toggle">
                                <img class="toggle-close" src="/assets_client/images/icons/close.png" alt="Search Toggle">
                            </button>
                            <div :class="{ 'header-search-wrap': true, 'active': isActive }">
                                <form action="#">
                                  <input type="text" placeholder="Type and hit enter">
                                  <button><img src="/assets_client/images/icons/search.png" alt="Search"></button>
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
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="mobile-menu order-12 d-block d-lg-none col"></div>
        </div>
    </div>
</div>


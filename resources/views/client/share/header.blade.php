<!-- Header Top Start -->
<div class="header-top header-top-one bg-theme-two">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-center">

            <div class="col mt-10 mb-10 d-none d-md-flex">
                <!-- Header Top Left Start -->
                <div class="header-top-left">
                    <p>Welcome to Jadusona</p>
                    <p>Hotline: <a href="tel:0123456789">0123 456 789</a></p>
                </div><!-- Header Top Left End -->
            </div>

            <div class="col mt-10 mb-10">
                <!-- Header Language Currency Start -->
                <ul class="header-lan-curr">

                    <li><a href="#">eng</a>
                        <ul>
                            <li><a href="#">english</a></li>
                            <li><a href="#">spanish</a></li>
                            <li><a href="#">france</a></li>
                            <li><a href="#">russian</a></li>
                            <li><a href="#">chinese</a></li>
                        </ul>
                    </li>

                    <li><a href="#">$usd</a>
                        <ul>
                            <li><a href="#">pound</a></li>
                            <li><a href="#">dollar</a></li>
                            <li><a href="#">euro</a></li>
                            <li><a href="#">yen</a></li>
                        </ul>
                    </li>

                </ul><!-- Header Language Currency End -->
            </div>

            <div class="col mt-10 mb-10">
                <!-- Header Shop Links Start -->
                <div class="header-top-right">
                    @php
                        $user = Auth::guard('khach_hang')->check();
                        $khach_hang = Auth::guard('khach_hang')->user();
                    @endphp
                    @if ($user)
                        <p><a href="/client/my-account"><img src="{{$khach_hang->avatar}}" style="height: 50px;width: 50px; border-radius: 100%" alt="Blog Author"> {{$khach_hang->full_name}}</a></p>
                    @else
                        <p><a href="/login-register">Register</a><a href="/login-register">Login</a></p>
                    @endif

                </div><!-- Header Shop Links End -->
            </div>

        </div>
    </div>
</div><!-- Header Top End -->

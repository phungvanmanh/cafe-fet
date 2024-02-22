@extends('client.share.master')
@section('noi_dung')
    <div >
        <!-- Page Banner Section Start -->
        <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
            <div class="container">
                <div class="row">
                    <div class="page-banner-content col">

                        <h1>Contact us</h1>
                        <ul class="page-breadcrumb">
                            <li><a href="/">Home</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </div><!-- Page Banner Section End -->

        <!-- Page Section Start -->
        <div class="page-section section section-padding">
            <div class="container">
                <div class="row row-30 mbn-40">
                    <div class="contact-info-wrap col-md-6 col-12 mb-40">
                        <h3>Get in Touch</h3>
                        <ul class="contact-info">
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <p>256, 1st AVE, You address <br>will be here</p>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <p><a href="#">+84 235 567 89</a></p>
                            </li>
                            <li>
                                <i class="fa fa-globe"></i>
                                <p><a href="#">info@example.com</a><a href="#">www.example.com</a></p>
                            </li>
                        </ul>
                    </div>

                    <div class="contact-form-wrap col-md-6 col-12 mb-40">
                        <h3>Leave a Message</h3>
                        <form id="contact-form" action="assets_client/php/mail.php">
                            <div class="contact-form">
                                <div class="row">
                                    <div class="col-12 mb-30">
                                        <input v-model="add.name" type="text" placeholder="Your Name">
                                    </div>
                                    <div class="col-lg-6 col-12 mb-30">
                                        <input v-model="add.so_dien_thoai" type="text" placeholder="Phone number">
                                    </div>
                                    <div class="col-lg-6 col-12 mb-30">
                                        <input type="email" v-model="add.email" placeholder="Email Address">
                                    </div>
                                    <div class="col-12 mb-30">
                                        <textarea placeholder="Message" v-model="add.noi_dung"></textarea>
                                    </div>
                                    <div class="col-12"><input type="submit" value="SEND" v-on:click="send($event)">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <p class="form-messege"></p>
                    </div>

                </div>
            </div>
        </div><!-- Page Section End -->
    </div>
@endsection
@section('js')
    <script>
        new ChildVue({
            el: '#app',
            data: {
                add: {},
            },
            created() {
                axios
                    .get('/check-login')
                    .then((res) => {
                        if(res.data.status == 200) {
                            this.loadDataGioHang();
                        }
                    });
            },
            methods: {
                send(e) {
                    e.preventDefault();
                    axios
                        .post('/send-contact', this.add)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Thành công!', 'Success');
                                this.add = {};
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
            },
        });
    </script>
@endsection

@extends('client.share.master')
@section('css')
    <style>
        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover,
        .drop-container.drag-active {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title,
        .drop-container.drag-active .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }

        input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #444;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #555;
        }

        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #084cdf;
            padding: 5px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background: #0d45a5;
        }
    </style>
@endsection
@section('noi_dung')
    <!-- Page Banner Section Start -->
    <div class="page-banner-section section" style="background-image: url(/assets_client/banner-1.png)">
        <div class="container">
            <div class="row">
                <div class="page-banner-content col">
                    <ul class="page-breadcrumb">
                        <li>
                            <h1>Login & Register</h1>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div><!-- Page Banner Section End -->

    <!-- Page Section Start -->
    <div class="page-section section section-padding" >
        <div class="container">
            <div class="row mbn-40">

                <div class="col-lg-4 col-12 mb-40">
                    <div class="login-register-form-wrap">
                        <h3>Login</h3>
                        <form action="#" class="mb-30">
                            <div class="row">
                                <div class="col-12 mb-15"><input v-model="login.email" type="text"
                                        placeholder="Username or Email"></div>
                                <div class="col-12 mb-15"><input v-model="login.password" type="password"
                                        placeholder="Password"></div>
                                <div class="col-6"><input v-on:click="loginClient($event)" type="submit" value="Login">
                                </div>
                                <div class="col-6"><h4 class="text-right"><a class="mt-3" href="/reset-password">Quên mật khẩu</a></h4>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-2 col-12 mb-40 text-center">
                    <span class="login-register-separator"></span>
                </div>

                <div class="col-lg-6 col-12 mb-40 ml-auto">
                    <div class="login-register-form-wrap">
                        <h3>Register</h3>
                        <form action="#">
                            <div class="row">
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.first_name" type="text"
                                        placeholder="Your First Name"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.last_name" type="text"
                                        placeholder="Your Last Name"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.email" type="email"
                                        placeholder="Email"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.password" type="password"
                                        placeholder="Password"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.so_dien_thoai" type="text"
                                        placeholder="Phone"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="add_kh.dia_chi" type="text"
                                        placeholder="Address"></div>
                            </div>
                            <div class="col-md-12 col-12 mb-15">
                                <label for="images" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Drop files here</span>
                                    or
                                    <input type="file" id="images"
                                        v-on:change="readerImage($event, 'add');getFile($event,'file_add')">
                                </label>
                            </div>
                            <div class="col-md-6 col-12">
                                <input v-on:click="addKhachHang($event)" type="submit" value="Register">
                                {{-- <button class="btn btn-primary" type="buttom">Register</button> --}}
                            </div>
                    </div>
                    </form>
                </div>
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
                file_add: "",
                add_kh: {},
                login: {}
            },
            created() {

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

                addKhachHang(event) {
                    event.preventDefault();
                    const payload = new FormData();
                    payload.append('avatar', this.file_add);
                    payload.append('first_name', this.add_kh.first_name);
                    payload.append('last_name', this.add_kh.last_name);
                    payload.append('so_dien_thoai', this.add_kh.so_dien_thoai);
                    payload.append('password', this.add_kh.password);
                    payload.append('dia_chi', this.add_kh.dia_chi);
                    payload.append('email', this.add_kh.email);
                    axios
                        .post('/register', payload, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                this.add_kh = {};
                                this.file_add = "";
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "Error");
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message, "Warning");
                            }
                        })
                        .catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                        });
                },

                loginClient(event) {
                    event.preventDefault();
                    axios
                        .post('/login', this.login)
                        .then((res) => {
                            if (res.data.status == 1) {
                                toastr.success(res.data.message);
                                setTimeout(() => {
                                    ''
                                    window.location.href = '/';
                                }, 1000);
                            } else if (res.data.status == 2) {
                                toastr.warning(res.data.message);
                            } else {
                                toastr.error(res.data.message);
                            }
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

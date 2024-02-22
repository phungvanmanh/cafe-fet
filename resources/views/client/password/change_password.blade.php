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
                            <h1>Reset Password</h1>
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
                <div class="col-lg-2 col-12 mb-40 m-auto">

                </div>
                <div class="col-lg-8 col-12 mb-40 m-auto">
                    <div class="login-register-form-wrap">
                        <h3>Reset Password</h3>
                        <form action="#">
                            <div class="row">
                                <div class="col-md-12 col-12 mb-15"><input hidden id="id" value="{{ $id }}" type="text"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="thong_tin.password" type="password"
                                    placeholder="Nhập vào mật khẩu"></div>
                                <div class="col-md-6 col-12 mb-15"><input v-model="thong_tin.re_password" type="password"
                                    placeholder="Nhập lại mật khẩu"></div>
                                <div class="col-md-12 col-12 text-right">
                                    <input v-on:click="doiMatKhau()" type="submit" value="Reset Password">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-2 col-12 mb-40 ml-auto">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data: {
                thong_tin   :   {'id' : ""},
            },
            created() {

            },
            methods: {
                doiMatKhau() {
                    event.preventDefault();
                    this.thong_tin.id    =   $("#id").val();
                    axios
                        .post('{{ Route("doiMatKhau") }}', this.thong_tin)
                        .then((res) => {
                            if(res.data.status) {
                                toastr.success(res.data.message, 'Success');
                                setTimeout(() => {
                                    window.location.href = '/'
                                }, 1000);
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

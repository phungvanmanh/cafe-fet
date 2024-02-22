@extends('client.share.master')
@section('noi_dung')

    <div class="card-body">
        <div class="blog-section section section-padding" id="app">
            <div class="container">
                <div class="card" style="background-color: rgb(255, 255, 255)">
                    <div class="row row-30 mbn-40">
                        <template v-for="(value, key) in list">
                            <div class="col-xl-12 col-lg-12 col-12 order-1 order-lg-2 mb-40">
                                <div class="single-blog">
                                    <div class="content">
                                        <ul class="meta">
                                            <li><a href="#">@{{ value.ten_su_kien }}</a></li>
                                            <li><a href="#">@{{ value.so_nguoi_tham_gia }}</a></li>
                                            <li>@{{ value.thoi_gian_bat_dau }}</li>
                                            <li><a href="#">@{{ value.thoi_gian_ket_thuc }}</a></li>
                                        </ul>
                                        <div class="desc">
                                            <p>@{{ value.mo_ta }}</p>
                                        </div>
                                        <div class="comment-form">
                                            <form v-on:submit="submitForm(value)">
                                                <button class="btn btn-primary" type="submit">Tham gia</button>
                                            </form>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
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
                list: [],
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .get('/su-kien/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                submitForm(value) {
                    event.preventDefault();
                    const formData = new FormData();
                    formData.append('id', value.id);

                    axios
                        .post('/client/su-kien', formData)
                        .then((res) => {
                            console.log(res.data.message);
                            if (res.data.status == undefined) {
                                toastr.error('Bạn cần đăng nhập hệ thống trước!');
                                setTimeout(() => {
                                    window.location.href = "/login-register"
                                }, 1000);
                            } else {
                                if(res.data.status) {
                                    toastr.success(res.data.message);
                                } else {
                                    toastr.error(res.data.message);
                                }
                            }
                        })
                        .catch((error) => {
                            // Xử lý lỗi (nếu có)
                        });
                }
            },
        });
    </script>
@endsection

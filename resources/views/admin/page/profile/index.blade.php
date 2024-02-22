@extends('admin.share.master')
@section('noi_dung')
@php
    $user = Auth::guard('admin')->user();
@endphp
<div class="row" >
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ $user->avatar}}" width="300px" height="300px" alt="Admin" class="rounded-circle p-1 bg-primary">
                    <div class="mt-3">
                        <h4>{{$user->full_name}}</h4>
                        <p class="text-secondary mb-1">Full Stack Developer</p>
                    </div>
                </div>
                <hr class="my-4" />
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6>Thông tin Cá Nhân</h6>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">First Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" v-model="edit.first_name"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Last Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" v-model="edit.last_name"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" v-model="edit.email" disabled/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" class="form-control" v-model="edit.so_dien_thoai"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Ảnh</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="file" class="form-control" v-on:change="readerImage($event, 'edit'); getFile($event,'file_update')">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="button" class="btn btn-primary px-4" v-on:click="updateAvatar()"  value="Lưu Thông Tin"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4 text-center">
                            <div class="col-sm-3">
                                <h5 class="mb-0">Thay Đổi Mật Khẩu</h5>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mật Khẩu Mới</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="password" class="form-control" name="password" v-model="password.password_new" placeholder="Nhập vào mật khẩu của bạn"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Nhập Lại Mật Khẩu Mới</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="password" class="form-control" name="re_password" v-model="password.re_password" placeholder="Nhập vào mật khẩu của bạn"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <button class="btn btn-primary" v-on:click='chagePassword()'>Lưu Mật Khẩu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        var user = <?php echo json_encode($user); ?>;
        new ChildVue({
            el      :   '#app',
            data    :   {
                edit                : {},
                password            : {},
                file                : '',
                edit                : {},
                file_update         : '',
            },
            created()   {
                axios
                    .get('/check-login')
                    .then((res) => {
                        if(res.data.status == 200) {
                                this.edit = user;
                                this.loadDataGioHang();
                                this.loadDataAll();
                                this.getDataHang();
                            }
                        });
            },
            methods :   {
                readerImage(event, item1) {
                    if (event.target.files && event.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this[item1].avatar = e.target.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }
                },

                getFile(e, item)
                {
                    this[item] = e.target.files[0];
                },

                chagePassword(){
                    this.password.id = this.edit.id;
                    axios
                        .post('/admin/password', this.password)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.password = {};
                            } else {
                                toastr.error(res.data.message, 'Lỗi!');
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },
                updateAvatar() {
                    const payload = new FormData();
                    payload.append('id', this.edit.id);
                    payload.append('avatar', this.file_update);
                    payload.append('email', this.edit.email);
                    payload.append('first_name', this.edit.first_name);
                    payload.append('last_name', this.edit.last_name);
                    payload.append('so_dien_thoai', this.edit.so_dien_thoai);
                    payload.append('trang_thai', this.edit.trang_thai);
                    payload.append('id_quyen', this.edit.id_quyen);
                    payload.append('password', this.edit.password);
                    axios
                        .post('/admin/avatar', payload,
                            {
                                headers:
                                    {
                                        'Content-Type': 'multipart/form-data'
                                    }
                            }
                        )
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, 'Thành công!');
                                this.loadData();
                            } else {
                                toastr.error(res.data.message, 'Lỗi!');
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },
            },
        });
    </script>
@endsection

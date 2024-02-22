@extends('admin.share.master')
@section('noi_dung')
    <div class="row" >
        <div class="col-md-4">
            <div class='card'>
                <div class='card-header'>
                    Thêm Mới
                </div>
                <div class='card-body'>
                    <div class='mb-1'>
                        <label class='form-label'>Nguyên Liệu</label>
                        <input v-model='add.ten_nguyen_lieu' v-on:keyup="slug = toSlug(add.ten_nguyen_lieu)" type='text'
                            class='form-control' placeholder="Nhập tên nguyên liệu">
                    </div>
                    <div class='mb-1'>
                        <label class='form-label'>Slug Nguyên Liệu</label>
                        <input v-model='slug' disabled type='text' class='form-control'
                            placeholder="Nhập slug tên nguyên liệu">
                    </div>
                </div>
                <div class='card-footer text-end'>
                    <button v-on:click='themMoi()' class='btn btn-danger'>Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class='card'>
                <div class='card-header'>
                    Danh Sách
                </div>
                <div class='card-body'>
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th class='text-center text-nowrap'>#</th>
                                    <th class='text-center text-nowrap'>Nguyên Liệu</th>
                                    <th class='text-center text-nowrap'>Số Lượng</th>
                                    <th class='text-center text-nowrap'>Đơn Giá</th>
                                    <th class='text-center text-nowrap'>Đơn Vị Tính</th>
                                    <th class='text-center text-nowrap'>Trạng Thái</th>
                                    <th class='text-center text-nowrap'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for='(value, key) in list'>
                                    <tr class="align-middle">
                                        <th class="text-center">@{{ key + 1 }}</th>
                                        <td>@{{ value.ten_nguyen_lieu }}<br>@{{ value.slug_nguyen_lieu }}</td>
                                        <td class="text-center">@{{ value.so_luong }}</td>
                                        <td class="text-center">@{{ value.don_gia }}</td>
                                        <td class="text-center">
                                            <template v-if="value.don_vi_tinh == -1">
                                                Chưa Có
                                            </template>
                                            <template v-else>
                                                @{{ value.ten_don_vi }}
                                            </template>
                                        </td>
                                        <td class="text-center">
                                            <button v-on:click="changeStatus(value)" v-if="value.trang_thai == 1"
                                                class="btn btn-success">Còn Hàng</button>
                                            <button v-on:click="changeStatus(value)" v-else class="btn btn-warning">Cần
                                                Nhập</button>
                                        </td>
                                        <td>
                                            <i data-bs-toggle='modal' data-bs-target='#updateModal'
                                                v-on:click='edit = Object.assign({}, value); slug_edit = value.slug_nguyen_lieu'
                                                class='fa-solid fa-pen-to-square fa-2x text-info'
                                                style='margin-right: 10px'></i>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal -->
                    <div class='modal fade' id='updateModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                        aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Cập Nhật</h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'
                                        aria-label='Close'></button>
                                </div>
                                <div class="modal-body">
                                    <div class='mb-1'>
                                        <label class='form-label'>Nguyên Liệu</label>
                                        <input v-model='edit.ten_nguyen_lieu'
                                            v-on:keyup="slug_edit = toSlug(edit.ten_nguyen_lieu)" type='text'
                                            class='form-control' placeholder="Nhập tên nguyên liệu">
                                    </div>
                                    <div class='mb-1'>
                                        <label class='form-label'>Slug Nguyên Liệu</label>
                                        <input v-model='slug_edit' disabled type='text' class='form-control'
                                            placeholder="Nhập slug tên nguyên liệu">
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button v-on:click='update()' type='button' class='btn btn-primary'
                                        data-bs-dismiss='modal'>Cập
                                        Nhật</button>
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
        new ChildVue({
            el: '#app',
            data: {
                add: {},
                list: [],
                edit: {},
                del: {},
                slug: '',
                slug_edit: '',
            },
            created() {
                this.loadData();
            },
            methods: {
                loadData() {
                    axios
                        .get('/admin/nguyen-lieu/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                themMoi() {
                    this.add.slug_nguyen_lieu = this.slug;
                    console.log(this.add);
                    axios
                        .post('/admin/nguyen-lieu/create', this.add)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã thêm mới', 'Thành công!');
                                this.loadData();
                                this.add = {};
                                this.slug = '';
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },
                changeStatus(v) {
                    axios
                        .post('/admin/nguyen-lieu/status', v)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã đổi trạng thái', 'Thành công!');
                                this.loadData();
                            } else {
                                toastr.error(res.data.message, 'Có lỗi!');
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },
                update() {
                    this.edit.slug_nguyen_lieu = this.slug_edit;
                    axios
                        .post('/admin/nguyen-lieu/update', this.edit)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã cập nhật', 'Thành công!');
                                this.loadData();
                            }
                        })
                        .catch((res) => {
                            var errrors = res.response.data.errors;
                            $.each(errrors, function(k, v) {
                                toastr.error(v[0], 'Có lỗi!');
                            })
                        });
                },
                toSlug(str) {
                    str = str.toLowerCase();
                    str = str
                        .normalize('NFD') // chuyển chuỗi sang unicode tổ hợp
                        .replace(/[\u0300-\u036f]/g, ''); // xóa các ký tự dấu sau khi tách tổ hợp
                    str = str.replace(/[đĐ]/g, 'd');
                    str = str.replace(/([^0-9a-z-\s])/g, '');
                    str = str.replace(/(\s+)/g, '-');
                    str = str.replace(/-+/g, '-');
                    str = str.replace(/^-+|-+$/g, '');
                    return str;
                },
            },
        });
    </script>
@endsection

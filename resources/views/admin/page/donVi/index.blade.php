@extends('admin.share.master')
@section('noi_dung')
    <div class="row" >
        <div class="col-md-5">
            <div class='card'>
                <div class='card-header'>
                    Thêm Mới
                </div>
                <div class='card-body'>
                    <div class='mb-1'>
                        <label class='form-label'>Đơn Vị</label>
                        <input v-model='add.ten_don_vi' v-on:keyup="slug = toSlug(add.ten_don_vi)" type='text'
                            class='form-control' placeholder="Nhập tên đơn vị">
                    </div>
                    <div class='mb-1'>
                        <label class='form-label'>Slug Đơn Vị</label>
                        <input v-model='slug' disabled type='text' class='form-control'
                            placeholder="Nhập slug tên đơn vị">
                    </div>
                </div>
                <div class='card-footer text-end'>
                    <button v-on:click='themMoi()' class='btn btn-danger'>Thêm Mới</button>
                </div>
            </div>
        </div>
        <div class="col-md-7">
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
                                    <th class='text-center text-nowrap'>Đơn vị</th>
                                    <th class='text-center text-nowrap'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for='(value, key) in list'>
                                    <tr>
                                        <th class='text-center'>@{{ key + 1 }}</th>
                                        <td>@{{ value.ten_don_vi }} | @{{ value.slug_don_vi }}</td>
                                        <td class='text-nowrap text-center align-middle'>
                                            <i data-bs-toggle='modal' data-bs-target='#updateModal'
                                                v-on:click='edit = Object.assign({}, value); slug_edit = value.slug_don_vi'
                                                class='fa-solid fa-pen-to-square fa-2x text-info'
                                                style='margin-right: 10px'></i>
                                            <i data-bs-toggle='modal' data-bs-target='#deleteModal' v-on:click='del = value'
                                                class='fa-solid fa-trash fa-2x text-danger'></i>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class='modal fade' id='deleteModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                        aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h1 class='modal-title fs-5' id='exampleModalLabel'>Xóa</h1>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'
                                        aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>Bạn có muốn xóa <b>@{{ del.ten_don_vi }}</b> này không?</p>
                                    <p>
                                        <b>Lưu ý:</b> Điều này không thể hoàn tác!
                                    </p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button v-on:click='destroy()' type='button' class='btn btn-danger'
                                        data-bs-dismiss='modal'>Xác
                                        Nhận Xóa</button>
                                </div>
                            </div>
                        </div>
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
                                        <label class='form-label'>Đơn Vị</label>
                                        <input v-model='edit.ten_don_vi' v-on:keyup="slug_edit = toSlug(edit.ten_don_vi)"
                                            type='text' class='form-control' placeholder="Nhập tên đơn vị">
                                    </div>
                                    <div class='mb-1'>
                                        <label class='form-label'>Slug Đơn Vị</label>
                                        <input v-model='slug_edit' disabled type='text' class='form-control'
                                            placeholder="Nhập slug tên đơn vị">
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
                        .get('/admin/don-vi/data')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                },
                themMoi() {
                    this.add.slug_don_vi = this.slug;
                    axios
                        .post('/admin/don-vi/create', this.add)
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
                destroy() {
                    axios
                        .post('/admin/don-vi/delete', this.del)
                        .then((res) => {
                            if (res.data.status) {
                                toastr.success('Đã xóa', 'Thành công!');
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
                update() {
                    this.edit.slug_don_vi = this.slug_edit;
                    axios
                        .post('/admin/don-vi/update', this.edit)
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

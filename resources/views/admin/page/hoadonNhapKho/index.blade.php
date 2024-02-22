@extends('admin.share.master')
@section('noi_dung')
    <div id='app' class='row'>
        <div class='col-12 text-end mb-2'>
            <button type='button' class='btn btn-outline-primary round waves-effect' data-bs-toggle='modal'
                data-bs-target='#createModal'><i class='fa-solid fa-plus'></i> Thêm Mới</button>
        </div>
        <div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-xl'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'> Thêm Mới</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <div class='row'>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Mã Hóa Đơn</label>
                                    <input v-model='add.ma_hoa_don' type='text' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Ngày Tạo Hóa Đơn</label>
                                    <input v-model='add.ngay_tao_hoa_don' type='text' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Ghi Chú</label>
                                    <input v-model='add.ghi_chu' type='text' class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Tổng Tiền</label>
                                    <input v-model='add.tong_tien' type='tel' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Admin</label>
                                    <input v-model='add.id_admin_nhap' type='email' class='form-control'>
                                </div>
                            </div>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Nhà Cung Cấp</label>
                                    <input v-model='add.id_nha_cung_cap' type='text' class='form-control'>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-4'>
                                <div class='mb-1'>
                                    <label class='form-label'>Trạng Thái</label>
                                    <select v-model='add.trang_thai' class='form-control'>
                                        <option v-bind:value='1'>Hiển Thị</option>
                                        <option v-bind:value='2'>Tạm Tắt</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                        <button v-on:click='themMoi()' class='btn btn-primary' data-bs-dismiss='modal'>Thêm Mới</button>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-12'>
            <div class='card'>
                <div class='card-header'>
                    Danh Sách Hóa Đơn Nhập Kho
                </div>
                <div class='card-body'>
                    <div class='row'>
                        <div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th class='text-center text-nowrap'>STT</th>
                                        <th class='text-center text-nowrap'>Mã Hóa Đơn</th>
                                        <th class='text-center text-nowrap'>Ngày Tạo Hóa Đơn</th>
                                        <th class='text-center text-nowrap'>Ghi Chú</th>
                                        <th class='text-center text-nowrap'>Tổng Tiền</th>
                                        <th class='text-center text-nowrap'>Admin</th>
                                        <th class='text-center text-nowrap'>Nhà Cung Cấp</th>
                                        <th class='text-center text-nowrap'>Tình Trạng</th>
                                        <th class='text-center text-nowrap'>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for='(value, key) in list'>
                                        <tr>
                                            <th class='text-center'>@{{ key + 1 }}</th>
                                            <td class='text-nowrap'>@{{ value.ma_hoa_don }}</td>
                                            <td class='text-nowrap'>@{{ value.ngay_tao_hoa_don }}</td>
                                            <td class='text-nowrap'>@{{ value.ghi_chu }}</td>
                                            <td class='text-nowrap'>@{{ value.tong_tien }}</td>
                                            <td class='text-nowrap'>@{{ value.full_name }}</td>
                                            <td class='text-nowrap'>@{{ value.ten_doanh_nghiep }}</td>
                                            <td class='text-nowrap text-center'>
                                                <template v-if='value.trang_thai == 0'>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-warning'
                                                        style='width: 160px'>Tạm Tắt</button>
                                                </template>
                                                <template v-else>
                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-danger'
                                                        style='width: 160px'>Hiển Thị</button>
                                                </template>
                                            </td>
                                            <td class='text-center text-nowrap'>
                                                <i class="fa-solid fa-circle-info fa-2x" data-bs-toggle='modal' data-bs-target='#showModal'></i>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div class="modal fade" id="showModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="staticBackdropLabel">Chi Tiết Hóa Đơn</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class='table table-bordered'>
                                                <tbody>
                                                    <template v-for='(value, key) in list'>
                                                        <tr>
                                                            <th class='text-center'>@{{ key + 1 }}</th>
                                                            <td class='text-nowrap'>@{{ value.ma_hoa_don }}</td>
                                                            <td class='text-nowrap'>@{{ value.ngay_tao_hoa_don }}</td>
                                                            <td class='text-nowrap'>@{{ value.ghi_chu }}</td>
                                                            <td class='text-nowrap'>@{{ value.tong_tien }}</td>
                                                            <td class='text-nowrap'>@{{ value.full_name }}</td>
                                                            <td class='text-nowrap'>@{{ value.ten_doanh_nghiep }}</td>
                                                            <td class='text-nowrap text-center'>
                                                                <template v-if='value.trang_thai == 0'>
                                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-warning'
                                                                        style='width: 160px'>Tạm Tắt</button>
                                                                </template>
                                                                <template v-else>
                                                                    <button v-on:click='doiTrangThai(value)' class='btn btn-danger'
                                                                        style='width: 160px'>Hiển Thị</button>
                                                                </template>
                                                            </td>
                                                            <td class='text-center text-nowrap'>
                                                                <i class="fa-solid fa-circle-info fa-2x" data-bs-toggle='modal' data-bs-target='#showModal'></i>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                  </div>
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
                    },
                    created() {
                        this.loadData();
                    },
                    methods: {
                        loadData() {
                            axios
                                .get('/admin/chi-tiet-don-hang/get-data')
                                .then((res) => {
                                    this.list = res.data.data;
                                    console.log(this.list);
                                });
                        },
                        // doiTrangThai(v) {
                        //     axios
                        //         .post('', v)
                        //         .then((res) => {
                        //             this.loadData();
                        //             toastr.warning('Đã đổi trạng thái', 'Thành Công!')
                        //         });
                        // },
                        // themMoi() {
                        //     axios
                        //         .post('', this.add)
                        //         .then((res) => {
                        //             if (res.data.status) {
                        //                 toastr.success('Đã thêm mới', 'Thành công!');;
                        //                 this.loadData();
                        //                 this.add = {};
                        //             }
                        //         })
                        //         .catch((res) => {
                        //             var errrors = res.response.data.errors;
                        //             $.each(errrors, function(k, v) {
                        //                 toastr.error(v[0], 'Có lỗi!');
                        //             })
                        //         });
                        // },
                        // destroy() {
                        //     axios
                        //         .post('', this.del)
                        //         .then((res) => {
                        //             if (res.data.status) {
                        //                 toastr.success('Đã xóa', 'Thành công!');
                        //                 this.loadData();
                        //             }
                        //         })
                        //         .catch((res) => {
                        //             var errrors = res.response.data.errors;
                        //             $.each(errrors, function(k, v) {
                        //                 toastr.error(v[0], 'Có lỗi!');
                        //             })
                        //         });
                        // },
                        // update() {
                        //     axios
                        //         .post('', this.edit)
                        //         .then((res) => {
                        //             if (res.data.status) {
                        //                 toastr.success('Đã cập nhật', 'Thành công!');
                        //                 this.loadData();
                        //             }
                        //         })
                        //         .catch((res) => {
                        //             var errrors = res.response.data.errors;
                        //             $.each(errrors, function(k, v) {
                        //                 toastr.error(v[0], 'Có lỗi!');
                        //             })
                        //         });
                        // },
                    },
                });
    </script>
@endsection

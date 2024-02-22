@extends('admin.share.master')
@section('noi_dung')
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        Danh Sách Đơn Hàng
                    </div>
                    <div class="col-md-8 text-end">
                        <b>Tổng Tiền : <span class="text-danger">@{{ tong_tien }} vnđ</span></b>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Mã Đơn Hàng</th>
                                <th>Tên Người Mua</th>
                                <th>Tên Người Nhận</th>
                                <th>Tổng Tiền</th>
                                <th>Số Điện Thoại</th>
                                <th>Hình Thức Thanh Toán</th>
                                <th>Tình Trạng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(value, index) in list_don_hang">
                                <th class="text-center align-middle">@{{ index + 1 }}</th>
                                <td class="text-center align-middle">@{{ value.ma_don_hang }}</td>
                                <td class="align-middle">@{{ value.ten_nguoi_dat }}</td>
                                <td class="align-middle">@{{ value.ten_nguoi_nhan }}</td>
                                <td class="text-end align-middle">@{{ value.tong_tien }} vnđ</td>
                                <td class="text-center align-middle">@{{ value.so_dien_thoai }}</td>
                                <td  class="text-center align-middle">
                                    <button v-if="value.loai_thanh_toan == 0" class="btn btn-warning">Tiền Mặt</button>
                                    <button v-else class="btn btn-primary">Online</button>
                                </td>
                                <td  class="text-center align-middle">
                                    <template v-if="value.is_thanh_toan == 0">
                                        <button v-if="value.loai_thanh_toan == 1" class="btn btn-info">Chờ Xác Nhận</button>
                                        <button v-else class="btn btn-danger" v-on:click="changrStatus(value)">Chưa Thanh Toán</button>
                                    </template>
                                    <template v-else>
                                        <button class="btn btn-success">Đã Thanh Toán</button>
                                    </template>
                                </td>
                                <td  class="text-center align-middle">
                                    <i class="fa-solid fa-trash-can text-danger fa-2x" v-on:click="deleteDH(value)"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    new Vue({
        el          : "#app",
        data        : {
            list_don_hang   : [],
            tong_tien       : 0
        },
        created() {
            this.loadDataDonHang()
        },
        methods: {
            loadDataDonHang() {
                axios
                    .get('/admin/don-hang/data')
                    .then((res) => {
                        this.list_don_hang  = res.data.data;
                        this.tong_tien      = res.data.tong_tien
                    });
            },

            changrStatus(value) {
                axios
                    .post('/admin/don-hang/change-status', value)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message);
                            this.loadDataDonHang();
                        } else {
                            toastr.error(res.data.message);
                        }
                    })
            },

            deleteDH(value) {
                axios
                    .post('/admin/don-hang/delete', value)
                    .then((res) => {
                        if(res.data.status) {
                            toastr.success(res.data.message);
                            this.loadDataDonHang();
                        } else {
                            toastr.error(res.data.message);
                        }
                    })
            },
        },
    });
</script>
@endsection

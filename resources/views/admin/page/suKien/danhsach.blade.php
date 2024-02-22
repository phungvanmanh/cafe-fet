@extends('admin.share.master')
@section('noi_dung')
    <div class="row" id="app">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h5><b>Danh Sách Người Tham Gia Sự Kiện</b></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle text-nowrap">#</th>
                                    <th class="text-center align-middle text-nowrap">Tên Sự Kiện</th>
                                    <th class="text-center align-middle text-nowrap">Tên Người Tham Gia / Số Điện Thoại</th>
                                    <th class="text-center align-middle text-nowrap">Bắt Đầu / Kết Thúc</th>
                                    <th class="text-center align-middle text-nowrap">Địa Chỉ</th>
                                    <th class="text-center align-middle text-nowrap">Số Lượng</th>
                                    <th class="text-center align-middle text-nowrap">Tình Trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, key) in list">
                                    <tr>
                                        <th class="text-center align-middle text-nowrap">@{{ key + 1}}</th>
                                        <td class="align-middle text-nowrap">@{{value.ten_su_kien}}</td>
                                        <td class="align-middle text-nowrap">
                                            <div class="row">
                                                <template v-for="(v, k) in value.list_id_client">
                                                    <div class="col-6">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <td>@{{v.full_name}}</td>
                                                                <td class="text-center">@{{v.so_dien_thoai}}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </template>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle text-nowrap">
                                            @{{value.day_begin}} - @{{value.day_end}}
                                        </td>
                                        <td class="align-middle text-nowrap">@{{value.dia_chi}}</td>
                                        <td class="text-center align-middle text-nowrap">@{{value.so_nguoi_da_tham_gia}} / @{{value.so_nguoi_tham_gia}}</td>
                                        <td class="text-center align-middle text-nowrap">
                                            <button v-if="value.is_ket_thuc == 0" class="btn btn-primary">Chưa Bắt Đầu</button>
                                            <button v-if="value.is_ket_thuc == 1" class="btn btn-success">Đang Diễn Ra</button>
                                            <button v-else class="btn btn-danger">Đã Kết Thúc</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el      :   '#app',
            data    :   {
                list    : [],
            },
            created()   {
                this.loadData();
            },
            methods :   {
                loadData() {
                    axios
                        .get('/admin/su-kien/data-danh-sach')
                        .then((res) => {
                            this.list = res.data.data;
                        });
                }
            },
        });
    </script>
@endsection

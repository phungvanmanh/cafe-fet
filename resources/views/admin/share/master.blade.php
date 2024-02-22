<!doctype html>
<html lang="en">

<head>
    @include('admin.share.css')
    <style>
        table {
            font-family: arial !important;
            max-width: 100% !important;
            background-color: transparent !important;
            border-collapse: collapse !important;
            border-spacing: 0 !important;
        }
        .table {
            width: 100% !important;
            margin-bottom: 20px !important;
        }
        .table-responsive .dropdown,
        .table-responsive .btn-group,
        .table-responsive .btn-group-vertical {
            position: static !important;
        }
        .modal {
            overflow-y:auto !important;
        }
        div.dataTables_scrollBody.dropdown-visible {
            overflow: visible !important;
        }
        table.dataTable thead th, tbody td th {
            white-space: nowrap
        }

        select {
            height: auto !important;
        }

        .dataTables_wrapper {
            font-family: Roboto !important;
            font-size: 14px !important;
            position: relative !important;
            clear: both;
            *zoom: 1;
            zoom: 1;
        }
        .dropdown-item{
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="wrapper" id="app">
        <div class="header-wrapper">
            @include('admin.share.header')
            @include('admin.share.menu')
        </div>
        <div class="page-wrapper">
            <div class="page-content">
                @yield('noi_dung')
            </div>
        </div>
        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        @include('admin.share.footer')
    </div>
    @include('admin.share.color')
    @include('admin.share.js')
    <script>
        const ChildVue = Vue.extend({
            methods: {

            },
        });
    </script>
    <script>
        (function () {
        var dropdownMenu;
        $(window).on('show.bs.dropdown', function (e) {
        dropdownMenu = $(e.target).find('.dropdown-menu');
        $('body').append(dropdownMenu.detach());
        var eOffset = $(e.target).offset();
        dropdownMenu.css({
            'display': 'block',
                'top': eOffset.top + $(e.target).outerHeight(),
                'left': eOffset.left
        });
        });
        $(window).on('hide.bs.dropdown', function (e) {
            $(e.target).append(dropdownMenu.detach());
            dropdownMenu.hide();
        });

        $('.tbData').on('show.bs.dropdown', function () {
            $('.dataTables_scrollBody').addClass('dropdown-visible');
        })
        .on('hide.bs.dropdown', function () {
            $('.dataTables_scrollBody').removeClass('dropdown-visible');
        });
    })();
    </script>
    @yield('js')
</body>

</html>

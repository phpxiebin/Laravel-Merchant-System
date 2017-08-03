<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('merchant-asset/inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/style.css') }}" rel="stylesheet">


    @yield('styles')
</head>

<body class="top-navigation">

<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            <!-- 引入导航 -->
            @include('merchant/layouts/nav')
        </div>

        <!-- 引入面包屑 -->
        {!! Breadcrumbs::render(Route::currentRouteName()) !!}

                <!-- 加载内容 -->
        @yield('content')

                <!-- 引入底部 -->
        @include('merchant/layouts/footer')
    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('merchant-asset/inspinia/js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('merchant-asset/inspinia/js/inspinia.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/pace/pace.min.js') }}"></script>

<!-- Ladda -->
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('merchant-asset/inspinia/js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('merchant-asset/inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<!-- Toastr script -->
<script src="{{ asset('merchant-asset/inspinia/js/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $(function () {
        // Bind normal buttons
        $('.ladda-button').ladda('bind', {timeout: 10000});

        // 删除确认模态框
        $('.wrapper').on('click', 'a.del-confirm', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: $(this).data('title') || '是否确认删除?',
                text: $(this).data('text') || '此操作是删除操作，请谨慎操作',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '确认',
                cancelButtonText: '取消',
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.href = url;
                }
            });
        });

        //操作提示
        @if(!empty(session('message', '')))
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 1500
            };
            @if(session('status', 0) == 0)
                toastr.success('操作提示', '{{ session('message') }}');
            @else
                toastr.error('操作提示', '{{ session('message') }}');
            @endif
        @endif

        //搜索表单 转ajax提交
        $('.search-form').on('click', '.search', function() {
            var url = window.location.href.split('?')[0] + '?' + $('.search-form').serialize();
            $('.project-list').load(url + ' .project-list');
        });
        //禁止回车提交
        $(".search-form").keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });

        //点击分页A标签AJAX获取数据
        $('body').on('click', '.pagination a', function() {
            var url = $(this).attr('href');
            $('.project-list').load(url + ' .project-list');
            //屏蔽A标签原始提交
            return false;
        });
    });
</script>
@yield('script')
</body>
</html>

@extends('merchant.layouts.app')

{{-- CSS --}}
@section('styles')
    @parent
@endsection

{{-- JS --}}
@section('script')
    @parent
@endsection

@section('content')
    <div class="wrapper" style="padding-top:20px">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content m-b-sm border-bottom">
                    <div class="p-xs">
                        <div class="pull-left m-r-md">
                            <i class="fa fa-globe text-navy mid-icon"></i>
                        </div>
                        <h2>欢迎使用 {{ config('app.name', 'Laravel') }}</h2>
                        <span>打造领先的人脸识别,图像识别和深度学习云平台和行业解决方案</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
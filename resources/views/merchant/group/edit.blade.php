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
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper" style="padding-top:20px">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ getCurrentAction()['method_name'] }}组</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" enctype="multipart/form-data" action="{{ url('merchant/group/'.getCurrentAction()['method']) }}">
                            <div class="form-group"><label class="col-sm-2 control-label">组编号</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="group_no" value="{{ $groupData->group_no or '' }}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">组信息</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="group_info" value="{{ $groupData->group_info or '' }}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="ladda-button btn btn-warning" data-style="zoom-in" type="reset">取消</button>
                                    <button class="ladda-button btn btn-primary" data-style="expand-right" type="submit">保存</button>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $groupData->id or '' }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
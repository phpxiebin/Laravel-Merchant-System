@extends('merchant.layouts.app')

{{-- CSS --}}
@section('styles')
    @parent
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/bootstrap-fileinput/fileinput.min.css') }}"
          rel="stylesheet">
@endsection

{{-- JS --}}
@section('script')
    @parent
    <script src="{{ asset('merchant-asset/inspinia/js/plugins/bootstrap-fileinput/fileinput.js') }}"></script>
    <script src="{{ asset('merchant-asset/inspinia/js/plugins/bootstrap-fileinput/locales/zh.js') }}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            $("#test-upload").fileinput({
                language: 'zh',
                showUpload: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                elErrorContainer: '#errorBlock',
                @if (isset($faceData->face_attachment))
                    initialPreview: [
                        "<img src='{{ assetStorage($faceData->face_attachment) }}' class='kv-preview-data file-preview-image' style='width:auto;height:160px;'/>",
                    ],
                @endif
            });
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper" style="padding-top:20px">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ getCurrentAction()['method_name'] }}人脸</h5>
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
                        <form method="post" class="form-horizontal" enctype="multipart/form-data" action="{{ url('merchant/face/'.getCurrentAction()['method']) }}">
                            <div class="form-group"><label class="col-sm-2 control-label">所属组</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="group_id" @if(getCurrentAction()['method'] == 'update') disabled @endif>
                                        <option value="">请选择</option>
                                        @foreach($groupData as $key=>$val)
                                            <option value="{{ $key }}" @if(isset($faceData->group) && $key == $faceData->group->id) selected="selected" readonly="readonly" @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">人脸编号</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="face_no" value="{{ $faceData->face_no or '' }}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">人脸信息</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="face_info" value="{{ $faceData->face_info or '' }}"></div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group"><label class="col-sm-2 control-label">人脸图片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="file" id="test-upload" name="face_attachment" >
                                    <div id="errorBlock" class="help-block"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="ladda-button btn btn-warning" data-style="zoom-in" type="reset">取消</button>
                                    <button class="ladda-button btn btn-primary" data-style="expand-right" type="submit">保存</button>
                                </div>
                            </div>

                            <input type="hidden" name="id" value="{{ $faceData->id or '' }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
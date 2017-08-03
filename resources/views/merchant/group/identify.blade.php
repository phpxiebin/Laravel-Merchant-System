@extends('merchant.layouts.app')

{{-- CSS --}}
@section('styles')
    @parent
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/bootstrap-fileinput/fileinput.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/blueimp/css/blueimp-gallery.min.css') }}"
          rel="stylesheet">
@endsection

{{-- JS --}}
@section('script')
    @parent
    <script src="{{ asset('merchant-asset/inspinia/js/plugins/bootstrap-fileinput/fileinput.js') }}"></script>
    <script src="{{ asset('merchant-asset/inspinia/js/plugins/bootstrap-fileinput/locales/zh.js') }}"></script>

    <script src="{{ asset('merchant-asset/inspinia/js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>

    <script type="application/javascript">
        $(document).ready(function () {
            $("#test-upload").fileinput({
                language: 'zh',
                showUpload: false,
                allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
                elErrorContainer: '#errorBlock'
            });

            $('body').on('click', '.lightBoxGallery', function (event) {
                event = event || window.event;
                var target = event.target || event.srcElement,
                        link = target.src ? target.parentNode : target,
                        options = {index: link, event: event},
                        links = this.getElementsByTagName('a');
                blueimp.Gallery(links, options);
            })
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper" style="padding-top:20px">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>组识别</h5>
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
                        <form method="post" class="form-horizontal" enctype="multipart/form-data"
                              action="{{ url('merchant/group/identify?id='.$groupData->id) }}">

                            <div class="form-group"><label class="col-sm-2 control-label">所属组</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="group_id">
                                        <option value="">请选择</option>
                                        @foreach($group as $key=>$val)
                                            <option value="{{ $key }}" @if(isset($groupData) && $key == $groupData->id) selected="selected" readonly="readonly" @endif>{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label">人脸图片</label>
                                <div class="col-sm-10">
                                    <input type="file" class="file" id="test-upload" name="face_attachment">
                                    <div id="errorBlock" class="help-block"></div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="ladda-button btn btn-primary" data-style="expand-right"
                                            type="submit">图片识别
                                    </button>
                                </div>
                            </div>

                            @if(isset($listData) && !empty($listData))
                                <div class="ibox-title">
                                    <h5>{{ $groupData->group_info or '' }} - 识别结果</h5>
                                </div>

                                <div class="project-list">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="width: 30%">#</th>
                                            <th>匹配度</th>
                                            <th>是否本人</th>
                                            <th>人脸信息</th>
                                            <th style="text-align: center;">人脸图片</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($listData as $item)
                                            <tr>
                                                <td class="project-status">
                                                    {{$item->id}}
                                                </td>
                                                <td class="project-title">
                                                    {{$item->score}}
                                                </td>
                                                <td class="project-title">
                                                    {{ $item->myself}}
                                                </td>
                                                <td class="project-title">
                                                    {{$item->face_no}}
                                                    <br/>
                                                    <small>{{$item->face_info}}</small>
                                                </td>
                                                <td class="project-people lightBoxGallery">
                                                    <a href="{{ assetStorage($item->face_attachment) }}">
                                                        <img alt="image" class="img-circle"
                                                             src="{{ assetStorage($item->face_attachment) }}">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                                <div id="blueimp-gallery" class="blueimp-gallery">
                                    <div class="slides"></div>
                                    <h3 class="title"></h3>
                                    <a class="prev">‹</a>
                                    <a class="next">›</a>
                                    <a class="close">×</a>
                                    <a class="play-pause"></a>
                                    <ol class="indicator"></ol>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
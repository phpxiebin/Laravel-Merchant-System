@extends('merchant.layouts.app')

{{-- CSS --}}
@section('styles')
    @parent
    <link href="{{ asset('merchant-asset/inspinia/css/plugins/blueimp/css/blueimp-gallery.min.css') }}"
          rel="stylesheet">
@endsection

{{-- JS --}}
@section('script')
    @parent
    <script src="{{ asset('merchant-asset/inspinia/js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>
    <script type="application/javascript">
        $(document).ready(function () {
            $('body').on('click', '.lightBoxGallery', function(event) {
                event = event || window.event;
                var target = event.target || event.srcElement,
                        link = target.src ? target.parentNode : target,
                        options = {index: link, event: event},
                        links = this.getElementsByTagName('a');
                blueimp.Gallery(links, options);
            })
        })
    </script>
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper" style="padding-top:20px">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>人脸数据列表</h5>
                        <div class="ibox-tools">
                            <a href="{{ url('merchant/face/store') }}" class="btn btn-primary btn-xs">
                                <i class="fa fa fa-edit"></i> 添加人脸
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <form class="search-form">
                                <div class="col-sm-2 m-b-xs">
                                    <select class="input-sm form-control input-s-sm inline" name="group_id">
                                        <option value="">选择组</option>
                                        @foreach($groupData as $key=>$val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-10">
                                    <div class="input-group"><input type="text" placeholder="人脸编号/人脸信息"
                                                                    class="input-sm form-control"
                                                                    name="no_or_info"> <span
                                                class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary search"><i
                                                    class="fa fa-search"></i> 查询
                                        </button> </span></div>
                                </div>
                            </form>
                        </div>

                        <div class="project-list">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>所属分组</th>
                                    <th>人脸信息</th>
                                    <th style="text-align: right">人脸图片</th>
                                    <th style="text-align: right; padding-right: 60px">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listData as $item)
                                    <tr>
                                        <td class="project-status">
                                            {{$item->id}}
                                        </td>
                                        <td class="project-title">
                                            {{$item->group->group_info}}
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
                                        <td class="project-actions">
                                            <a href="{{ url('merchant/face/update?id='.$item->id) }}"
                                               class="btn btn-white btn-sm"><i
                                                        class="fa fa-pencil"></i> 修改 </a>
                                            <a href="{{ url('merchant/face/destroy?id='.$item->id) }}"
                                               class="btn btn-white btn-sm del-confirm"><i
                                                        class="fa fa-trash"></i> 删除 </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <!-- 分页 -->
                            @if(count(array_filter(request()->all(), 'strlen')) == 0)
                                {{ $listData->links() }}
                            @else
                                {{ $listData->appends(array_filter(request()->all(), 'strlen'))->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
@endsection
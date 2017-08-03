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
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>组数据列表</h5>
                        <div class="ibox-tools">
                            <a href="{{ url('merchant/group/store') }}" class="btn btn-primary btn-xs">
                                <i class="fa fa fa-edit"></i>添加组
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row m-b-sm m-t-sm">
                            <form class="search-form">
                                <div class="col-md-12">
                                    <div class="input-group"><input type="text" placeholder="组编号/组信息"
                                                                    class="input-sm form-control" name="no_or_info"> <span
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
                                <th>#</th>
                                <th>组编号</th>
                                <th>组信息</th>
                                <th>人脸数量</th>
                                <th style="text-align: right; padding-right: 60px">操作</th>
                                </thead>
                                <tbody>
                                @foreach($listData as $item)
                                    <tr>
                                        <td class="project-status">
                                            {{$item->id}}
                                        </td>
                                        <td class="project-title">
                                            {{$item->group_no}}
                                        </td>
                                        <td class="project-title">
                                            {{$item->group_info}}
                                        </td>
                                        <td class="project-title">
                                            {{$item->face_count}}
                                        </td>
                                        <td class="project-actions">
                                            <a href="{{ url('merchant/group/identify?id='.$item->id) }}"
                                               class="btn btn-white btn-sm"><i
                                                        class="fa fa-eye"></i> 组识别 </a>
                                            <a href="{{ url('merchant/group/update?id='.$item->id) }}"
                                               class="btn btn-white btn-sm"><i
                                                        class="fa fa-pencil"></i> 修改 </a>
                                            <a href="{{ url('merchant/group/destroy?id=').$item->id }}"
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
@endsection
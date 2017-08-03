<?php

namespace App\Http\Controllers\Merchant;

use App\Facades\Face;
use App\Models\FcFaces;
use App\Models\FcGroups;
use Illuminate\Http\Request;

/**
 * 组数据管理
 * Class GroupController
 * @package App\Http\Controllers\Merchant
 */
class GroupController extends BaseController
{
    /**
     * 组数据管理列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $page = $this->getParameter();
        $listData = FcGroups::withCount('face')->orderBy('created_at', 'desc')
            ->OfNoOrInfo($request->no_or_info)
            ->paginate($page['limit']);
        return view('merchant/group/index', compact('listData'));
    }

    /**
     * 组数据管理新增
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'group_no' => 'required|max:64',
                'group_info' => 'required|max:64',
            ]);

            $yc_group_id = $this->randYunCongGroupId();
            $params = [
                'group_no' => $request->input('group_no'),
                'group_info' => $request->input('group_info'),
                'yc_group_id' => $yc_group_id
            ];

            //调用云从接口
            $result = Face::processing('store_group', [
                'groupId' => $yc_group_id,
                'tag' => $params['group_info'],
            ]);
            if (!$result) {
                return back()->withErrors(Face::getError());
            }

            (new FcGroups())->create($params);
            return redirect('/merchant/group')->with('message', '添加成功');
        } else {
            return view('merchant/group/edit');
        }
    }

    /**
     * 组数据管理删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ErrorException
     */
    public function destroy(Request $request)
    {
        $row = $this->show($request->id);

        $count = FcFaces::ofGroup($request->id)->count();
        if ($count > 0) {
            return $this->errorTips('请确认改组下所有人脸已清除');
        }

        //调用接口
        $result = Face::processing('destroy_group', [
            'groupId' => $row->yc_group_id
        ]);
        if (!$result) { //如果调用接口失败
            return $this->errorTips(Face::getError()['msg']);
        }
        $row->delete();
        return redirect('/merchant/group')->with('message', '删除成功');
    }

    /**
     * 修改组
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \ErrorException
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            //按ID查询Group信息
            $group = $this->show($request->id);
            $this->validate($request, [
                'group_no' => 'required|max:64',
                'group_info' => 'required|max:64',
            ]);

            $params = [
                'group_no' => $request->input('group_no'),
                'group_info' => $request->input('group_info'),
            ];

            $group->update($params);
            return redirect('/merchant/group')->with('message', '修改成功');

        } else {
            $groupData = $this->show($request->id);
            return view('merchant/group/edit', compact('groupData'));
        }
    }

    /**
     * 组数据管理识别
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function identify(Request $request)
    {
        $id = $request->input('group_id', $request->input('id'));
        $groupData = $this->show($id);
        $listData = [];
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'face_attachment' => 'required|file',
            ]);
            $path = $request->file('face_attachment')->path();
            $param = [
                'groupId' => $groupData->yc_group_id,
                'img' => img2Base64($path),
                'topN' => 10
            ];
            $result = Face::processing('IDENTIFY_GROUP', $param);
            if (!$result) {
                return back()->withErrors(Face::getError());
            }
            // 获取FaceId为数组
            $ycFaceIds = array_pluck($result['faces'], 'faceId');

            // 查询数据库数据
            $listData = FcFaces::OfYcFaceId($ycFaceIds)->select(['id', 'face_no', 'face_info', 'face_attachment', 'yc_face_id'])->get();
            // 循环增加匹配度
            array_walk_recursive($listData, function (&$v) use ($result) {
                array_where($result['faces'], function ($value) use (&$v) {
                    if ($value['faceId'] == $v->yc_face_id) {
                        $v->score = $value['score'];
                        $v->myself = ($v->score > 0.8) ? '是' : '否';
                    }
                });
            });
            // 匹配度排序
            $listData = array_reverse(array_sort($listData, function ($value) {
                return $value['score'];
            }));
        }
        $group = FcGroups::getItems();
        return view('merchant/group/identify', compact('listData', 'groupData', 'group'));
    }

    /**
     * 根据ID查询详情
     * @param $id ID
     * @return mixed 返回查询结果
     * @throws \ErrorException
     */
    public function show($id)
    {
        $result = FcGroups::find($id);
        if (!$result) {
            throw new \ErrorException('数据不存在');
        }
        return $result;
    }
}

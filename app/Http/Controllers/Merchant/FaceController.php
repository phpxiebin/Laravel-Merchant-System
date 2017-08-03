<?php

namespace App\Http\Controllers\Merchant;

use App\Facades\Face;
use App\Models\FcFaces;
use App\Models\FcGroups;
use Illuminate\Http\Request;

/**
 * 人脸数据管理
 * Class FaceController
 * @package App\Http\Controllers\Merchant
 */
class FaceController extends BaseController
{

    /**
     * 人脸数组管理列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $page = $this->getParameter();
        $listData = FcFaces::with('group')
            ->OfGroup($request->group_id)
            ->OfNoOrInfo($request->no_or_info)
            ->orderBy('created_at', 'desc')
            ->paginate($page['limit']);
        $groupData = FcGroups::getItems();
        return view('merchant/face/index', compact('listData', 'groupData'));
    }

    /**
     * 人脸数据管理新增
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'face_no' => 'required|max:64',
                'face_info' => 'required|max:64',
                'group_id' => 'required',
                'face_attachment' => 'required|file',
            ]);

            $yc_face_id = $this->randYunCongFaceId();
            $params = [
                'face_no' => $request->input('face_no'),
                'face_info' => $request->input('face_info'),
                'face_attachment' => $request->file('face_attachment')->store('face', 'upload'),
                'yc_face_id' => $yc_face_id,
                'group_id' => $request->input('group_id')
            ];

            //todo 远程添加人脸
            $result = Face::processing('store_face', [
                'faceId' => $yc_face_id,
                'groupId' => FcGroups::find($request->input('group_id'))->yc_group_id ?? '',
                'tag' => $params['face_info'],
                'img' => img2Base64(assetStorage($params['face_attachment']))
            ]);
            if (!$result) { //如果调用接口失败
                return back()->withErrors(Face::getError());
            }

            //todo 本地添加
            FcFaces::create($params);

            return redirect('/merchant/face')->with('message', '添加成功');
        } else {
            $groupData = FcGroups::getItems();
            return view('merchant/face/edit', compact('groupData'));
        }
    }

    /**
     * 人脸数据管理删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \ErrorException
     */
    public function destroy(Request $request)
    {
        $row = $this->show($request->id);
        //调用接口
        $result = Face::processing('destroy_face', [
            'faceId' => $row->yc_face_id
        ]);
        if (!$result) { //如果调用接口失败
            return $this->errorTips(Face::getError()['msg']);
        }
        $row->delete();
        return redirect('/merchant/face')->with('message', '删除成功');
    }

    /**
     * 人脸数据管理修改
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ErrorException
     */
    public function update(Request $request)
    {
        if ($request->isMethod('post')) {
            //按ID查询Face信息
            $face = $this->show($request->id);
            $this->validate($request, [
                'face_no' => 'required|max:64',
                'face_info' => 'required|max:64',
                'face_attachment' => 'sometimes|required|file',
            ]);
            //判断是否上传过文件
            if ($request->hasFile('face_attachment')) {
                //todo 路径生成规则 '用户Id/upload/文件名'
                $path = $request->file('face_attachment')->store('face', 'upload');
            }else{
                $path = $face->face_attachment;
            }

            $params = [
                'face_no' => $request->input('face_no'),
                'face_info' => $request->input('face_info'),
                'face_attachment' => $path
            ];

            $result = Face::processing('update_face', [
                'faceId' => $face->yc_face_id,
                'groupId' => $face->group->yc_group_id,
                'tag' => $params['face_info'],
                'img' => img2Base64(assetStorage($path))
            ]);
            if (!$result) { //如果调用接口失败
                return back()->withErrors(Face::getError());
            }

            $face->update($params);
            return redirect('/merchant/face')->with('message', '修改成功');
        } else {
            $groupData = FcGroups::getItems();
            $faceData = $this->show($request->id);
            return view('merchant/face/edit', compact('groupData', 'faceData'));
        }
    }

    /**
     * 根据ID查询详情
     * @param $id ID
     * @param array $columns 查询字段
     * @return mixed 返回查询结果
     * @throws \ErrorException
     */
    public function show($id, $columns = ['*'])
    {
        $result = FcFaces::with('group')->find($id, $columns);
        if (!$result) {
            throw new \ErrorException('数据不存在');
        }
        return $result;
    }
}

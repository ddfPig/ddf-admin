<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 18:00
 */

namespace app\common\model;


use think\Model;

class Video extends Model
{
    /**在线视频列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function docList($request)
    {
        $map = [];
        $map[] = ['is_back','eq',0];
        $category = $request->param('category');
        if($category){
            $map[]  = ['chapterID','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['vititle','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.cname as category_text";
        $list = Video::alias('a')->field($field)->join('sunny_video_chapter b',"a.chapterID=b.ID")
            ->where($map)->wherenull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**回收站在线视频
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function docListBack($request)
    {
        $map = [];
        $map[] = ['is_back','eq',1];
        $category = $request->param('category');
        if($category){
            $map[]  = ['chapterID','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['vititle','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.cname as category_text";
        $list = Video::alias('a')->field($field)->join('sunny_video_chapter b',"a.chapterID=b.ID")
            ->where($map)->wherenull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**在线视频详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function docInfo($id)
    {
        $map = [];
        $map[] = ['a.is_back','eq',0];
        $map[] = ['a.ID','eq',$id];
        $field = "a.*,b.cname as category_text";
        return Video::alias('a')->field($field)->join('sunny_video_chapter b',"a.chapterID=b.ID")
            ->where($map)->find();
    }

    /**添加或修改在线视频
     * @param $params
     * @return bool
     */
    public function updateDoc($params)
    {
        if(empty($params['id'])){
            Video::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['is_back'] =0;
                $params['status'] =1;
                $result = Video::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    $contents = '添加在线视频:'.$params['vititle'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Video::commit();
                return $result;
            }catch(\Exception $e){
                Video::rollback();
                return false;
            }
        }else{
            Video::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Video::where('ID',$params['id'])->value('doc_pic');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);
                }
                $params['update_time'] = time();
                $result = Video::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新在线视频:'.$params['vititle'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Video::commit();
                return $result;
            }catch (\Exception $e){
                Video::rollback();
                return false;
            }
        }
    }

    /**禁用在线视频
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $title = Video::where('ID',$id)->value('vititle');
        $res = Video::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用在线视频:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用在线视频
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = Video::where('ID',$id)->value('vititle');
        $res = Video::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用在线视频:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除在线视频到回收站
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delDoc($ids)
    {
        $map = ['id' => $ids];
        $title = Video::where('ID','in',$ids)->column('vititle');
        $result = Video::where($map)->update([
            'is_back'=>1,
        ]);
        if($result){
            $contents = '删除在线视频到回收站:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**在线视频还原
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function backDoc($ids)
    {
        $map = ['id' => $ids];
        $title = Video::where('ID','in',$ids)->column('vititle');
        $result = Video::where($map)->update([
            'is_back'=>0,
        ]);
        if($result){
            $contents = '在线视频还原:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**彻底删除在线视频
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delDocTrue($ids)
    {
        $map = ['id' => $ids];
        $title = Video::where('ID','in',$ids)->column('vititle');
        $result = Video::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '彻底删除在线视频:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }
}
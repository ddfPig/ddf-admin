<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-08-03
 * Time: 14:41
 */

namespace app\common\model;


use think\Model;

class Templated extends Model
{
    /**主题管理列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function templateList($request)
    {
        $map = [];
        $category = $request->param('category');
        if($category){
            $map[]  = ['type','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['title','like','%'.$keywords.'%'];
        }
        $field = "ID,imgs,tname,title,status,update_time,type";
        $list = Templated::field($field)->where($map)->wherenull('delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**主题管理详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function templateInfo($id)
    {
        $map = [];
        $map[] = ['ID','eq',$id];
        $field = "ID,imgs,tname,title,status,update_time,type";
        return Templated::field($field)->where($map)->find();
    }

    /**添加或修改主题管理
     * @param $params
     * @return bool
     */
    public function updateTemplate($params)
    {
        if(empty($params['id'])){
            Templated::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['status'] =0;
                $result = Templated::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    $contents = '添加主题管理:'.$params['title'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Templated::commit();
                return $result;
            }catch(\Exception $e){
                Templated::rollback();
                return false;
            }
        }else{
            Templated::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Templated::where('ID',$params['id'])->value('doc_pic');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);
                }
                $params['update_time'] = time();
                $result = Templated::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新主题管理:'.$params['title'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Templated::commit();
                return $result;
            }catch (\Exception $e){
                Templated::rollback();
                return false;
            }
        }
    }

    /**模板启用
     * @param $params
     * @return int
     */
    public function setOn($params)
    {
        $map[] = ['type','eq',$params['type']];
        $status = Templated::where($map)->where('ID',$params['id'])->value('status');
        if($status==1){
            $res = Templated::where($map)->where('ID',$params['id'])->setField('status',0);
        }else{
            Templated::where($map)->where('ID','<>','')->setField('status',0);
            $res = Templated::where($map)->where('ID',$params['id'])->setField('status',1);
        }
        return $res;
    }

    /**删除模板
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delTemplate($ids)
    {
        $map = ['id' => $ids];
        $title = Templated::where('ID','in',$ids)->column('title');
        $result = Templated::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '删除模板:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 10:37
 */

namespace app\common\model;


use think\Model;

class Special extends Model
{
    /**专题列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function specList($request)
    {
        $map = [];
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['sptitle','like','%'.$keywords.'%'];
        }
        $field = "ID,sptitle,spinfo,spcontent,imgs,status,clicks,update_time,sort,shortitle";
        $list = Special::field($field)->where($map)->wherenull('delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**专题详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function specInfo($id)
    {
        $map = [];
        $map[] = ['ID','eq',$id];
        $field = "ID,sptitle,spinfo,spcontent,imgs,status,clicks,create_time,sort,shortitle";
        return Special::field($field)->where($map)->find();
    }

    /**添加或修改专题
     * @param $params
     * @return bool
     */
    public function updateSpec($params)
    {
        if(empty($params['id'])){
            Special::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['status'] =1;
                $result = Special::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    $contents = '添加专题:'.$params['sptitle'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Special::commit();
                return $result;
            }catch(\Exception $e){
                Special::rollback();
                return false;
            }
        }else{
            Special::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Special::where('ID',$params['id'])->value('imgs');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);
                }
                $params['update_time'] = time();
                $result = Special::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新专题:'.$params['sptitle'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Special::commit();
                return $result;
            }catch (\Exception $e){
                Special::rollback();
                return false;
            }
        }
    }

    /**禁用专题
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $title = Special::where('ID',$id)->value('sptitle');
        $res = Special::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用专题:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用专题
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = Special::where('ID',$id)->value('sptitle');
        $res = Special::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用专题:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**彻底删除专题
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delSpecTrue($ids)
    {
        $map = ['id' => $ids];
        $title = Special::where('ID','in',$ids)->column('sptitle');
        $result = Special::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '删除专题:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }
}
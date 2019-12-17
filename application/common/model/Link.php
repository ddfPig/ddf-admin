<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 9:17
 */

namespace app\common\model;


use think\Model;

class Link extends Model
{
    /**链接列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function linkList($request)
    {
        return Link::whereNull('delete_time')->paginate(config('web.list_rows'));
    }

    /**链接详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function linkInfo($id)
    {
        return Link::where('ID',$id)->find();
    }

    /**更新链接
     * @param $params
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function updateLink($params)
    {
        if(empty($params['id'])){
            Link::startTrans();
            try{
                $params['create_time'] = time();
                $params['status'] =1;
                $result = Link::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    $contents = '添加友情链接:'.$params['linkname'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Link::commit();
                return $result;
            }catch(\Exception $e){
                Link::rollback();
                return false;
            }
        }else{
            Link::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Link::where('ID',$params['id'])->value('pics');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);

                }
                $result = Link::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新友情链接:'.$params['linkname'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Link::commit();
                return $result;
            }catch (\Exception $e){
                Link::rollback();
                return false;
            }
        }
    }

    /**禁用友情链接
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $linkname = Link::where('ID',$id)->value('linkname');
        $res = Link::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用友情链接:'.$linkname.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用友情链接
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $linkname = Link::where('ID',$id)->value('linkname');
        $res = Link::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用友情链接:'.$linkname.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除友情链接
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delLink($ids)
    {
        $map = ['id' => $ids];
        $linkname = Link::where('ID','in',$ids)->column('linkname');
        $result = Link::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '删除友情链接:'.join(',',$linkname).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }


}
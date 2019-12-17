<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-23
 * Time: 19:07
 */

namespace app\common\model;


use think\Model;

class Ads extends Model
{
    /**广告列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function adsList($request)
    {
        $field = "a.*,b.tname";
        return Ads::alias('a')->field($field)->join('sunny_adtype b',"a.adtypeID=b.ID")->whereNull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
    }

    /**广告信息
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function gginfo($id){
        $map = [];
        $map[] = ['a.ID','eq',$id];
        $field = "a.*,b.tname";
        return Ads::alias('a')->field($field)->join('sunny_adtype b',"a.adtypeID=b.ID")->whereNull('a.delete_time')->find();
    }

    /**添加或更新广告
     * @param $params
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function updateAdvert($params)
    {
        if(empty($params['id'])){
            Ads::startTrans();
           try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['clicks'] =0;
                $params['status'] =1;
                $result = Ads::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
               if($result){
                   $contents = '添加广告:'.$params['adtitle'].',ID:'.$params['ID'];
                   sysLogs($contents);
               }
                Ads::commit();
                return $result;
            }catch(\Exception $e){
                Ads::rollback();
                return false;
            }
        }else{
            Ads::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Ads::where('ID',$params['id'])->value('pics');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);

                }
                $params['update_time'] = time();
                $result = Ads::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新广告:'.$params['adtitle'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Ads::commit();
                return $result;
            }catch (\Exception $e){
                Ads::rollback();
                return false;
            }
        }
    }

    /**禁用广告
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $adtitle = Ads::where('ID',$id)->value('adtitle');
        $res =  Ads::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用广告:'.$adtitle.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用广告
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $adtitle = Ads::where('ID',$id)->value('adtitle');
        $res = Ads::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用广告:'.$adtitle.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /** 删除广告
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delAdvert($ids)
    {
        $map = ['id' => $ids];
        $adtitle = Ads::where('ID','in',$ids)->column('adtitle');
        $result = Ads::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '删除广告:'.join(',',$adtitle).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }



}
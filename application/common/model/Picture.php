<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-31
 * Time: 9:09
 */

namespace app\common\model;


use think\Model;

class Picture extends Model
{
    /**图片素材列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function picList($request)
    {
        $map = [];
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['a.ptitle','like','%'.$keywords.'%'];
        }
        $field = "a.ID,a.ptitle,a.status,a.update_time,a.imgs,a.picinfo,a.link,b.name";
        $list = Picture::alias('a')->field($field)->join('sunny_menu b',"a.cateID=b.ID")->where($map)->wherenull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }


    /**图片素材详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function picInfo($id)
    {
        $map = [];
        $map[] = ['a.ID','eq',$id];
        $field = "a.cateID,a.ID,a.ptitle,a.status,a.update_time,a.imgs,a.picinfo,a.link,b.name";
        return Picture::alias('a')->field($field)->join('sunny_menu b',"a.cateID=b.ID")->where($map)->wherenull('a.delete_time')->find();
    }

    /**添加或修改图片素材
     * @param $params
     * @return bool
     */
    public function updatePic($params)
    {
        if(empty($params['id'])){
            Picture::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['status'] =1;
                $pics = $params['pic'];
                if($pics){
                    foreach ($pics as $k=>$v){
                        $imgs[]=[
                            'src'=>$v['src'],
                            'info'=>$v['info'],
                        ];
                        $pids[] = $v['picID'];
                    }
                }
                $params['imgs'] = json_encode($imgs,JSON_UNESCAPED_UNICODE);
                $result = Picture::allowField(true)->save($params);

                if($result){
                    $map[] = ['ID','in',$pids];
                    Picfiles::where($map)->setField('state',1);
                    $contents = '添加图片素材:'.$params['ptitle'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Picture::commit();
                return $result;
            }catch(\Exception $e){
                Picture::rollback();
                return false;
            }
        }else{
            Picture::startTrans();
            try{
                $old_imgs = Picture::field('imgs')->where('ID',$params['id'])->find();
                $old_imgs = json_decode($old_imgs['imgs'],true);
                $old_imgs = array_column($old_imgs, 'src');
                $pics = $params['pic'];
                $picArr = array_column($pics, 'src');
                $pids = [];
                if($pics){
                    foreach ($pics as $k=>$v){
                        $imgs[]=[
                            'src'=>$v['src'],
                            'info'=>$v['info'],
                        ];
                        if(isset($v['picID'])){
                            $pids[] = $v['picID'];
                        }
                    }
                }
                $params['update_time'] = time();
                $params['imgs'] = json_encode($imgs,JSON_UNESCAPED_UNICODE);
                $result = Picture::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    //更新新图片
                    if($pids){
                        $map[] = ['ID','in',$pids];
                        Picfiles::where($map)->setField('state',1);
                    }

                    //更新原有图片
                    if($old_imgs){
                        foreach ($old_imgs as $k=>$vt){
                             if(!in_array($vt,$picArr)){
                                 Picfiles::where('strPath',md5($vt))->setField('state',0);
                             }
                        }
                    }
                    $contents = '更新图片素材:'.$params['ptitle'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Picture::commit();
                return $result;
            }catch (\Exception $e){
                Picture::rollback();
                return false;
            }
        }
    }

    /**禁用图片素材
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $title = Picture::where('ID',$id)->value('ptitle');
        $res = Picture::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用图片素材:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用图片素材
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = Picture::where('ID',$id)->value('ptitle');
        $res = Picture::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用图片素材:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**彻底删除图片素材
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delPic($ids)
    {
        $map = ['id' => $ids];
        $title = Picture::where('ID','in',$ids)->column('ptitle');
        $result = Picture::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '彻底删除图片素材:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }
}
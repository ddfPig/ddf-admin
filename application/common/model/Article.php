<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:54
 */

namespace app\common\model;


use Ramsey\Uuid\Uuid;
use think\Model;

class Article extends Model
{
    /**在线文档列表
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
            $map[]  = ['cateID','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['title','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.cname as category_text";
        $list = Article::alias('a')->field($field)->join('art_chapter b',"a.cateID=b.ID")
            ->where($map)->wherenull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**回收站在线文档
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
            $map[]  = ['cateID','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['title','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.cname as category_text";
        $list = Article::alias('a')->field($field)->join('art_chapter b',"a.cateID=b.ID")
            ->where($map)->wherenull('a.delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**在线文档详情
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
        $field = "a.*,b.cname as category_text,c.info,c.content";
        return Article::alias('a')->field($field)->join('art_chapter b',"a.cateID=b.ID")
            ->join('sunny_art_detail c','a.ID=c.articleID')->where($map)->find();
    }

    /**添加或修改在线文档
     * @param $params
     * @return bool
     */
    public function updateDoc($params)
    {
        if(empty($params['id'])){
            Article::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['is_back'] =0;
                $params['status'] =1;
                $params['is_comment'] =0;
                $result = Article::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    //更新附表
                    $datas = [
                         'ID'=>Uuid::uuid1(),
                         'articleID'=>$params['ID'],
                         'info'=>$params['info'],
                         'content'=>$params['content'],
                    ];
                    $detail = new ArtDetail();
                    $detail->addDetail($datas);

                   $contents = '添加在线文档:'.$params['title'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Article::commit();
                return $result;
            }catch(\Exception $e){
                Article::rollback();
                return false;
            }
        }else{
            Article::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = Article::where('ID',$params['id'])->value('doc_pic');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);

                }
                $params['update_time'] = time();
                $result = Article::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    //更新附表
                    $datas = [
                        'info'=>$params['info'],
                        'content'=>$params['content'],
                    ];
                    $detail = new ArtDetail();
                    $detail->updateDetail($params['id'],$datas);
                    $contents = '更新在线文档:'.$params['title'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Article::commit();
                return $result;
            }catch (\Exception $e){
                Article::rollback();
                return false;
            }
        }
    }

    /**禁用在线文档
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $title = Article::where('ID',$id)->value('title');
        $res = Article::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用在线文档:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用在线文档
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = Article::where('ID',$id)->value('title');
        $res = Article::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用在线文档:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除在线文档到回收站
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delDoc($ids)
    {
        $map = ['id' => $ids];
        $title = Article::where('ID','in',$ids)->column('title');
        $result = Article::where($map)->update([
            'is_back'=>1,
        ]);
        if($result){
            $contents = '删除在线文档到回收站:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**在线文档还原
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function backDoc($ids)
    {
        $map = ['id' => $ids];
        $title = Article::where('ID','in',$ids)->column('title');
        $result = Article::where($map)->update([
            'is_back'=>0,
        ]);
        if($result){
            $contents = '在线文档还原:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**彻底删除在线文档
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delDocTrue($ids)
    {
        $map = ['id' => $ids];
        $title = Article::where('ID','in',$ids)->column('title');
        $result = Article::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '彻底删除在线文档:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

}
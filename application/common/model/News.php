<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 15:37
 */

namespace app\common\model;


use think\Model;

class News extends Model
{
    /**文章列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function newsList($request)
    {
        $map = [];
        $map[] = ['news_back','eq',0];
        $category = $request->param('category');
        if($category){
            $map[]  = ['news_columnid','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['news_title','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.name as category_text";
        $list = News::alias('a')->field($field)->join('sunny_menu b',"a.news_columnid=b.ID")
                                      ->where($map)->wherenull('a.delete_time')->order('news_modified desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**回收站文章
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function newsListBack($request)
    {
        $map = [];
        $map[] = ['news_back','eq',1];
        $category = $request->param('category');
        if($category){
            $map[]  = ['news_columnid','=',$category];
        }
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['news_title','like','%'.$keywords.'%'];
        }
        $field = "a.*,b.name as category_text";
        $list = News::alias('a')->field($field)->join('sunny_menu b',"a.news_columnid=b.ID")
            ->where($map)->wherenull('a.delete_time')->order('news_modified desc')->paginate(config('web.list_rows'));
        return $list;
    }

    /**文章详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newsInfo($id)
    {
        $map = [];
        $map[] = ['a.news_back','eq',0];
        $map[] = ['a.ID','eq',$id];
        $field = "a.*,b.name as category_text";
        return News::alias('a')->field($field)->join('sunny_menu b',"a.news_columnid=b.ID")
            ->where($map)->find();
    }

    /**添加或修改文章
     * @param $params
     * @return bool
     */
    public function updateNews($params)
    {
        if(empty($params['id'])){
            News::startTrans();
            try{
                $params['news_time'] = time();
                $params['news_modified'] = time();
                $params['news_back'] =0;
                $params['news_open'] =1;
                $params['comment_status'] =0;
                $result = News::allowField(true)->save($params);
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                }
                if($result){
                    $contents = '添加门户文章:'.$params['news_title'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                News::commit();
                return $result;
            }catch(\Exception $e){
                News::rollback();
                return false;
            }
        }else{
            News::startTrans();
            try{
                //存在图片ID即已经上传新的图片
                if($params['picID']){
                    $map[] = ['ID','eq',$params['picID']];
                    Picfiles::where($map)->setField('state',1);
                    //原有图片注释为未使用
                    $oldPic = News::where('ID',$params['id'])->value('news_img');
                    Picfiles::where('strPath',md5($oldPic))->setField('state',0);

                }
                $params['news_modified'] = time();
                $result = News::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新门户文章:'.$params['news_title'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                News::commit();
                return $result;
            }catch (\Exception $e){
                News::rollback();
                return false;
            }
        }
    }

    /**禁用文章
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $news_title = News::where('ID',$id)->value('news_title');
        $res = News::where('ID',$id)->setField('news_open',0);
        if($res){
            $contents = '禁用文章:'.$news_title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用文章
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $news_title = News::where('ID',$id)->value('news_title');
        $res = News::where('ID',$id)->setField('news_open',1);
        if($res){
            $contents = '启用文章:'.$news_title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**删除文章到回收站
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delNews($ids)
    {
        $map = ['id' => $ids];
        $news_title = News::where('ID','in',$ids)->column('news_title');
        $result = News::where($map)->update([
            'news_back'=>1,
        ]);
        if($result){
            $contents = '删除文章到回收站:'.join(',',$news_title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**文章还原
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function backNews($ids)
    {
        $map = ['id' => $ids];
        $news_title = News::where('ID','in',$ids)->column('news_title');
        $result = News::where($map)->update([
            'news_back'=>0,
        ]);
        if($result){
            $contents = '文章还原:'.join(',',$news_title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

    /**彻底删除文章
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delNewsTrue($ids)
    {
        $map = ['id' => $ids];
        $news_title = News::where('ID','in',$ids)->column('news_title');
        $result = News::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '彻底删除文章:'.join(',',$news_title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }

}
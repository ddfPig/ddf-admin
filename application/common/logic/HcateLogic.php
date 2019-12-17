<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 14:18
 */

namespace app\common\logic;


use app\common\model\ArtChapter;
use app\manage\controller\Base;

class HcateLogic extends Base
{
    /**在线文档分类列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function menuList()
    {
        $menu = new ArtChapter();
        return $menu->menuList($id = 0,$field = 'ID,cname,sort,pid,status');
    }

    /**获取单个在线文档分类信息
     * @param $pid
     */
    public function menuInfo($pid)
    {
        $menu = new ArtChapter();
        return $menu->menuInfo($pid);
    }

    /**添加或更新在线文档分类
     * @return array
     * @throws \Exception
     */
    public function updateMenu($params)
    {
        $menu = new ArtChapter();
        $result = $menu->updateMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置在线文档分类状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = ArtChapter::where('ID',$params['id'])->value('status');
        $menu = new ArtChapter();
        if($status==1){
            $result = $menu->forbid($params['id']);
        }else{
            $result = $menu->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除在线文档分类
     * @param $params
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMenu($params)
    {
        $menu = new ArtChapter();
        $result = $menu->delMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-24
 * Time: 18:08
 */

namespace app\common\logic;


use app\common\model\VideoChapter;
use app\manage\controller\Base;

class VcateLogic extends Base
{
    /**在线视频分类列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function menuList()
    {
        $menu = new VideoChapter();
        return $menu->menuList($id = 0,$field = 'ID,cname,sort,pid,status');
    }

    /**获取单个在线视频分类信息
     * @param $pid
     */
    public function menuInfo($pid)
    {
        $menu = new VideoChapter();
        return $menu->menuInfo($pid);
    }

    /**添加或更新在线视频分类
     * @return array
     * @throws \Exception
     */
    public function updateMenu($params)
    {
        $menu = new VideoChapter();
        $result = $menu->updateMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置在线视频分类状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = VideoChapter::where('ID',$params['id'])->value('status');
        $menu = new VideoChapter();
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

    /**删除在线视频分类
     * @param $params
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMenu($params)
    {
        $menu = new VideoChapter();
        $result = $menu->delMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}
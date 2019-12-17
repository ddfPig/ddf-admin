<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-19
 * Time: 14:22
 */

namespace app\common\logic;


use app\common\model\Menu;
use app\manage\controller\Base;

class MenuLogic extends Base
{
    /**门户菜单列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function menuList()
    {
        $menu = new Menu();
        return $menu->menuList($id = 0,$field = 'ID,name,sort,pid,status');
    }

    /**获取单个菜单信息
     * @param $pid
     */
    public function menuInfo($pid)
    {
        $menu = new Menu();
        return $menu->menuInfo($pid);
    }

    /**添加或更新菜单
     * @return array
     * @throws \Exception
     */
    public function updateMenu($params)
    {
        $menu = new Menu();
        $result = $menu->updateMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置菜单状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = Menu::where('ID',$params['id'])->value('status');
        $menu = new Menu();
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

    /**删除菜单
     * @param $params
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delMenu($params)
    {
        $menu = new Menu();
        $result = $menu->delMenu($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }




}
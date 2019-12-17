<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-18
 * Time: 16:04
 */

namespace app\common\logic;


use app\common\model\AuthRule;
use app\manage\controller\Base;

class RuleLogic extends Base
{
    /**权限菜单列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function ruleList()
    {
        $ruleModel = new AuthRule();
        return $ruleModel->ruleList($id = 0,$field = 'ID,title,link,num,level,sort,pid,status');
    }

    /**获取单个权限规则信息
     * @param $pid
     */
    public function ruleInfo($pid)
    {
        $ruleModel = new AuthRule();
        return $ruleModel->ruleInfo($pid);
    }

    /**添加或更新权限规则
     * @return array
     * @throws \Exception
     */
    public function updateRule($params)
    {
        $ruleModel = new AuthRule();
        $result = $ruleModel->updaterule($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**设置权限规则状态
     * @param $params
     * @return array
     */
    public function setStatus($params)
    {
        $status = AuthRule::where('ID',$params['id'])->value('status');
        $ruleModel = new AuthRule();
        if($status==1){
            $result = $ruleModel->forbid($params['id']);
        }else{
            $result = $ruleModel->resume($params['id']);
        }
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

    /**删除权限规则
     * @param $params
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteRole($params)
    {
        $ruleModel = new AuthRule();
        $result = $ruleModel->deleteRule($params);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }

}
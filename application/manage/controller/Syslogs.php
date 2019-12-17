<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 14:50
 */

namespace app\manage\controller;




use app\common\model\Oplog;
use think\Request;

class Syslogs extends Base
{
    /**日志列表
     * @return mixed
     */
    public function index(Request $request)
    {
        $model = new Oplog();
        $list = $model->logList($request);
        $this->assign('list',$list);
        $this->assign('keywords',$request->param('keywords'));
        $this->assign('start',$request->param('start'));
        $this->assign('end',$request->param('end'));
        return $this->fetch();
    }

    /**删除日志
     * @param Request $request
     * @return array
     * @throws \Exception
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteLogs(Request $request)
    {
        $idArray = array_unique((array)$this->request->param('id'));
        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $model = new Oplog();
        $result = $model->deleteLogs($idArray);
        if($result){
            return $this->sendData('操作成功',1);
        }else{
            return $this->sendData('操作失败',0);
        }
    }
}
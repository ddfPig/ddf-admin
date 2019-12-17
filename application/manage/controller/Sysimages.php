<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 16:15
 */

namespace app\manage\controller;


use app\common\model\Picfiles;
use think\facade\Env;
use think\Request;

class Sysimages extends Base
{
    /**图片列表
     * @param Request $request
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        $start = strtotime($request->param('start'));
        $end = strtotime($request->param('end').' 23:55:55');
        $map[]  = ['state','eq',0];
        if($start && $end){
            $map[]  = ['uploadTime','between',[$start,$end]];
        }
        $field = "ID,dirName,fileName,filePath,if(state=0,'未使用','已使用') as state,size,imgType,uploadTime";
        $list = Picfiles::field($field)->where($map)->order('uploadTime DESC')->paginate(config('web.list_rows'));
        $this->assign('list',$list);
        $this->assign('start',$request->param('start'));
        $this->assign('end',$request->param('end'));
        return $this->fetch();
    }

    /**删除图片
     * @param Request $request
     * @return array
     */
    public function delPic(Request $request)
    {
        //数据验证
        $idArray = array_unique((array)$this->request->param('id'));

        if (empty($idArray) ) {
            return $this->sendData('请选择要操作的数据',0);
        }
        $picRoot = Env::get('root_path').DIRECTORY_SEPARATOR.'public';

        try{
            foreach ($idArray as $k=>$v){
                $info = Picfiles::where('ID',$v)->find();
                $path = $picRoot.$info['filePath'];
                if(file_exists($path)){
                    unlink($path);
                    Picfiles::where('ID',$v)->delete();
                    $contents = '删除系统图片:'.$info['fileName'].',ID:'.$v;
                    sysLogs($contents);
                }
            }
            return $this->sendData('删除成功',1);
        }catch (\Exception $e){
            return $this->sendData('删除失败',0);
        }

    }


}
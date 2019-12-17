<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 16:34
 */

namespace app\common\controller;

use app\common\model\AuthRule;
use app\manage\controller\Auth;
use PFinal\Excel\Excel;
use Ramsey\Uuid\Uuid;
use think\Controller;
use think\Db;
use think\facade\Env;


class Common extends Controller
{

    public function initialize()
    {
        if (!defined('MODULE_NAME')){define('MODULE_NAME', $this->request->module());}
        if (!defined('CONTROLLER_NAME')){define('CONTROLLER_NAME', $this->request->controller());}
        if (!defined('ACTION_NAME')){define('ACTION_NAME', $this->request->action());}

        $this->checkLogin();
        $this->getMenu();

    }

    /**
     * 检查是否登录
     */
    protected function checkLogin()
    {
        $aid_s=session('admin_auth')['uid'];
        if(empty($aid_s)){
            $this->redirect('manage/signin/index');
        }
    }

    /**
     * 获取后台菜单
     */
    protected function getMenu()
    {
        // 获取主菜单
        $auth = new Auth();
        $where  =  ['pid'=>'00000000-0000-0000-0000-000000000000','status'=>1];
        $menus['main']  =   AuthRule::where($where)->order('sort asc')->select();
        $aid_s=session('admin_auth')['uid'];
        //dump($aid_s);
        $menus['child'] = []; //设置子节点
        //高亮主菜单
        foreach ($menus['main'] as $key => $item) {
            if(!$auth->check($item['link'], $aid_s)){
                unset($menus['main'][$key]);
            }
            $groups = AuthRule::where([['group','<>',''],['pid','=',$item['ID']]])->order('sort asc')->column("group");

            foreach ($groups as $k=>$g) {
                $map = ['group'=>$g,'pid'=>$item['ID'],'status'=>1];
                $child = AuthRule::where($map)->field('ID,num,pid,title,link,icon')->order('sort asc')->select();
                foreach ($child as $s=>$d){
                    if(!$auth->check($d['link'], $aid_s)){
                        unset($child[$s]);
                     }
                }
               if(!empty($child) && count($child) >0){
                   $menus['child'][$key][$g] = $child->toArray();
               }
            }
        }
        $this->assign('menu',$menus);
    }

    /**生成主键
     * @return \Ramsey\Uuid\UuidInterface
     * @throws \Exception
     */
    protected function uuid()
    {
        return Uuid::uuid1();
    }

    /**返回数据
     * @param $message       消息
     * @param array $data    返回数据
     * @param int $code      状态码
     * @return array
     */
    protected function sendData($message,$code=1,$data=[])
    {
        return [
            'code'=>$code,
            'message'=>$message,
            'data'=>$data
        ];
    }

    /** excel 导入excel视频
     * @param $excelFile    excel文件
     * @param $field        字段
     * @param $table        数据表
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    protected function importExcelToVideo($path)
    {
        if(!file_exists($path)){
            return  $this->sendData('excel文件不存在!',0);
        }

        $field = [
            'vititle'     => '视频标题',
            'chapterID'   => '视频分类',
            'shortitle'   => '简短标题',
            'tags'        => '标签',
            'info'        => '视频描述',
            'imgs'        => '视频封面名称',
            'videourl'    => '视频名称',
            'sort'
            => '排序',
            'create_time' => '上传时间',
        ];

        $data = Excel::readExcelFile($path,$field);
        if(empty($data)) {
            return $this->sendData('excel文件为空!', 0);
        }
        //处理日期
        array_walk($data, function (&$item) {
            $reg_date= \PFinal\Excel\Excel::convertTime($item['create_time'], 'Y-m-d');
            $item['create_time'] = strtotime($reg_date);
            $item['update_time'] = strtotime($reg_date);
        });

        //处理状态
        array_walk($data, function (&$item) {
                $item['ID'] = $this->uuid();
                $item['status'] = 1;
                $item['is_back'] = 0;
                $item['clicks'] = rand(500,9999);
                $item['comments'] = rand(200,500);

        });

        //处理封面图片
        array_walk($data, function (&$item) {
            if($item['imgs']){
                $item['imgs'] = DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."news".DIRECTORY_SEPARATOR.date('Y-m-d').DIRECTORY_SEPARATOR.$item['imgs'];
            }
        });

        //处理封面图片
        array_walk($data, function (&$item) {
            if($item['videourl']){
                $item['videourl'] = DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.date('Y-m-d').DIRECTORY_SEPARATOR.$item['videourl'];
            }
        });



        //处理分类
        array_walk($data, function (&$item) {
            $cateID = Db::name('video_chapter')->where('cname',$item['chapterID'])->value('ID');
            if($cateID){
                $item['chapterID'] = $cateID;
            }else{
                //系统默认分类
                $item['chapterID'] = 'e127a0b6-0000-11e9-946e-30b49efad619';
            }
        });
        //数据写入到数据库表中
        $res = Db::name('video')->insertAll($data);
        if($res){
            return  $this->sendData('导入成功',1);
        }else{
            return  $this->sendData('导入失败',0);
        }
    }

}
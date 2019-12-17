<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-17
 * Time: 17:14
 */

namespace app\common\logic;


use app\common\facade\Logind;
use app\common\model\Admin;
use app\common\model\LoginLog;
use Ramsey\Uuid\Uuid;
use think\Controller;
use think\facade\Request;
use think\facade\Session;

class LoginLogic extends Controller
{
    /**
     * 定义所有的登入方式
     */
    private $loginWay = ['username', 'email', 'mobile',];

    /**登录逻辑验证
     * @param $params
     * @return array|\think\response\Json
     */
    public function login($params)
    {
        $admin = new Admin();
        //多账号登录
        foreach ($this->loginWay as $key => $value) {
            $info = $admin->getAdmin($value,$params['username'])->toArray();
            if ($info) {
                break;
            }
        }
        if(!$info){
            return json(['code'=>0,'message'=>'登录账号错误','data'=>'']);
        }

        //登录错误次数限制
        $login_where = [
            ['uid','eq',$info['ID']],
            ['state','eq',2],
            ['vtime','>',time()-10*60],
        ];
        $login_count = LoginLog::where($login_where)->order('vtime desc')->count();
        $login_count = $login_count?$login_count+1:1;
        $errorCount = 3;
        if($login_count > $errorCount){
            $login_time = LoginLog::where(array('uid'=>$info['ID'],'state'=>2))->order('vtime desc')->value('vtime');
            $point_time = 10 - (round((time() - $login_time)/60));
            return json(['code'=>0,'message'=>'错误次数频繁，请'.$point_time.'分钟后再登录']);
        }

        if(!password_verify($params['userpass'],$info['userpass'])){
            $this->loginLog($info,2);
            $Count = $errorCount-$login_count;
            $msg = "剩余".$Count."次机会，超出锁定10分钟";
            if($Count == 0){
                $msg = $errorCount."次机会已使用，锁定10分钟";
            }
            return json(['code'=>0,'message'=>'密码错误,'.$msg,'data'=>'']);
        }

        if($info['status'] == 0){
            $this->loginLog($info,3);
            return json(['code'=>0,'message'=>'账号已经禁用','data'=>'']);
        }

        if($info['gstatus'] == 0){
            $this->loginLog($info,3);
            return json(['code'=>0,'message'=>'角色已经禁用','data'=>'']);
        }

        $this->loginLog($info,1);

        //更新信息及写入session
        $this->autoLogin($info);

        $url = url('manage/index/index');
        return  ['code'=>true,'message'=>'登录成功','data'=>'','url'=>$url];
    }

    /**更新登录信息及session
     * @param $info
     */
    protected function autoLogin($info)
    {
        //更新登录信息
        $data['sessionID'] = session_id();
        $data['lastime']= \request()->time();
        $data['IP'] = \request()->ip();
        //更新首次登录时间
        if(empty($info['sessionID'])){
            $data['firstime'] = \request()->time();
        }

        Admin::where('ID',$info['ID'])->update($data);

        //session操作
        $auth = [
            'uid'             => $info['ID'],
            'username'        => $info['gname'],
            'last_login_time' => $info['lastime']
        ];

        Session::set('admin_auth',$auth);
        session('admin_auth_sign', signatureLogin($auth));
    }

    /**登录日志
     * @param $info
     */
    protected  function loginLog($info,$state)
    {
        $log= [
            'ID'        =>Uuid::uuid1(),
            'sessionID' =>session_id(),
            'uid'       =>$info['ID'],
            'uname'     =>$info['username'],
            'IP'        =>\request()->ip(),
            'vtime'     =>\request()->time(),
            'browser'   =>\request()->header('user-agent'),
            'osname'    =>getOS(),
            'state'     =>$state
        ];
        LoginLog::insert($log);
    }

    /**
     * 退出登录
     */
    public function loginOut(){
        session('admin_auth', null);
        session('admin_auth_sign', null);
    }

}
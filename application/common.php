<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/***************业务***************************************************************************************************/
//门户菜单
function get_tree(){
    $map['status'] = 1;
    $list = db("menu")->wherenull('delete_time')->where($map)->field('ID,pid,name')->order('pid asc,sort asc')->select();
    $Tree = new \tree\Tree();
    $Tree::$treeList = [];
    return $Tree->tree($list);
}

//在线分类
function get_tree2(){
    $map['status'] = 1;
    $list = db("art_chapter")->wherenull('delete_time')->where($map)->field('ID,pid,cname')->order('pid asc,sort asc')->select();
    $Tree = new \tree\Tree();
    $Tree::$treeList = [];
    return $Tree->tree($list);
}


//在线视频
function get_tree3(){
    $map['status'] = 1;
    $list = db("video_chapter")->wherenull('delete_time')->where($map)->field('ID,pid,cname')->order('pid asc,sort asc')->select();
    $Tree = new \tree\Tree();
    $Tree::$treeList = [];
    return $Tree->tree($list);
}

/**处理图片素材的json字段
 * @param $imgs
 */
function handleImage($imgs)
{
    $pics = json_decode($imgs,true);
    $str_img = '';
    foreach ($pics as $v){
        $str_img .= "<dl style='float: left;'><dt><img src='".$v['src']."' style='width:90px;height:90px;margin:0 5px;border: 1px solid #ccc'></dt><dd><p style='width: 90px;'>".$v['info']."</p></dd></dl>";
    }
    return $str_img;
}

/**添加日志
 * @param $contents    日志描述
 * @throws \Exception
 */
function sysLogs($contents)
{
    $log = [
        'ID'=>\Ramsey\Uuid\Uuid::uuid1(),
        'operationID'=>session('admin_auth')['uid'],
        'operationName'=>session('admin_auth')['username'],
        'contents'=>$contents,
        'IP'=>request()->ip(),
        'optime'=>time(),
    ];

    $op = new \app\common\model\Oplog();
    $op->add($log);
}

/**登录信息验证
 * @param $data
 * @return string
 */
function signatureLogin($data){
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data);
    $code = http_build_query($data);
    $sign = sha1($code);
    return $sign;
}

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 */
function is_login($type='admin'){
    $user = session($type.'_auth');
    if (empty($user)){
        return 0;
    } else {
        return session($type.'_auth_sign') == signatureLogin($user) ? $user['uid'] : 0;
    }
}

/**
 * 获取数据库中的配置列表
 * @return array 配置数组
 */
function config_lists(){
    $data   = db('options')->field('type,name,value')->select();
    $config = [];
    if($data && is_array($data)){
        foreach ($data as $value) {
            $config[$value['name']] = config_parse($value['type'], $value['value']);
        }
    }
    return $config;
}

/**
 * 问题属性
 * @param number $pos 属性的值
 * @param number $contain 指定推荐位
 * @return boolean true 包含 ， false 不包含
 */
function check_document_position($pos = 0, $contain = 0){
    if(empty($pos) || empty($contain)){
        return false;
    }
    //将两个参数进行按位与运算，不为0则表示$contain属于$pos
    $res = $pos & $contain;
    if($res !== 0){
        return true;
    }else{
        return false;
    }
}
function questionType($flag)
{
    $str = '';
    switch ($flag){
        case 1:
            $str = '最新';
            break;
        case 2:
            $str = '最热';
            break;
        case 3:
            $str = '实用';
            break;
        case 4:
            $str = '置顶';
            break;
        default:
            $str = '常见';
            break;
    }
    return $str;
}

function templateType($type)
{
    $str = '';
    switch ($type){
        case 1:
            $str = '电脑端';
            break;
        case 2:
            $str = '移动端';
            break;
        case 3:
            $str = '智能适应';
            break;
    }
    return $str;
}

/**************辅助***************************************************************************************************/

//判断pc或是手机
function isMobile(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $mobile_agents = Array("240x320","acer","acoon","acs-","abacho","ahong","airness","alcatel","amoi","android","anywhereyougo.com","applewebkit/525","applewebkit/532","asus","audio","au-mic","avantogo","becker","benq","bilbo","bird","blackberry","blazer","bleu","cdm-","compal","coolpad","danger","dbtel","dopod","elaine","eric","etouch","fly ","fly_","fly-","go.web","goodaccess","gradiente","grundig","haier","hedy","hitachi","htc","huawei","hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt","kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9","lg-","lge-","lge9","longcos","maemo","mercator","meridian","micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-","moto","nec-","netfront","newgen","nexian","nf-browser","nintendo","nitro","nokia","nook","novarra","obigo","palm","panasonic","pantech","philips","phone","pg-","playstation","pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo","samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens","sie-","softbank","sony","spice","sprint","spv","symbian","tablet","talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm","up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel","vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte");

    $is_mobile = false;

    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device)) {
            $is_mobile = true;
            break;
        }
    }

    return $is_mobile;
}

/**
 * 递归重组节点信息为多维数组
 *
 */
function node_merge(&$node, $pid = 0, $id_name = 'ID', $pid_name = 'pid', $child_name = '_child')
{
    $arr = array();
    foreach ($node as $v) {
        if ($v [$pid_name] == $pid) {
            $v [$child_name] = node_merge($node, $v [$id_name], $id_name, $pid_name, $child_name);
            $arr [] = $v;
        }
    }
    return $arr;
}


/**
 * 删除目录及目录下所有文件或删除指定文件
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function del_dir_file($path, $delDir = FALSE) {
    if(is_dir($path)){
        $handle = opendir($path);
        if ($handle) {
            while (false !== ( $item = readdir($handle) )) {
                if ($item != "." && $item != "..")
                    is_dir("$path/$item") ? del_dir_file("$path/$item", $delDir) : unlink("$path/$item");
            }
            closedir($handle);
            if ($delDir)
                return rmdir($path);
        }else {
            if (file_exists($path)) {
                return unlink($path);
            } else {
                return FALSE;
            }
        }
    }

}

/**替换反斜杠
 * @param $imgs
 * @return mixed
 */
function imgzy($imgs)
{
    return str_replace('\\','/',$imgs);
}

// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}


/**
 * 根据配置类型解析配置
 * @param  integer $type  配置类型
 * @param  string  $value 配置值
 */
function config_parse($type, $value){

    switch ($type) {
        case 3: //解析数组
            $array = preg_split('/[\r\n]+/', trim($value, "\r\n"));
            if(strpos($value,':')===false){
                $value = $array;
            }else{
                $value  = [];
                foreach ($array as $val) {
                    list($k, $v) = explode(':', $val);
                    $value[$k]   = $v;
                }
            }
            break;
    }
    return $value;
}

//获取操作系统
function getOS(){
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);

    if(strpos($agent, 'windows nt')) {
        $platform = 'windows';
    } elseif(strpos($agent, 'macintosh')) {
        $platform = 'mac';
    } elseif(strpos($agent, 'ipod')) {
        $platform = 'ipod';
    } elseif(strpos($agent, 'ipad')) {
        $platform = 'ipad';
    } elseif(strpos($agent, 'iphone')) {
        $platform = 'iphone';
    } elseif (strpos($agent, 'android')) {
        $platform = 'android';
    } elseif(strpos($agent, 'unix')) {
        $platform = 'unix';
    } elseif(strpos($agent, 'linux')) {
        $platform = 'linux';
    } else {
        $platform = 'other';
    }

    return $platform;
}

/** 时间格式化函数1
 * @param null $time
 * @param string $format
 * @param int $type
 * @return false|string
 */
function time_format($time = NULL,$format='Y-m-d H:i',$type=0){
    $time = $time === NULL ? time() : intval($time);
    if(empty($type)){
        return date($format, $time);
    }else{
        $current_time=time();
        $span=$current_time-$time;
        if($span<60){
            return "刚刚";
        }else if($span<3600){
            return intval($span/60)."分钟前";
        }else if($span<24*3600){
            return intval($span/3600)."小时前";
        }else if($span<(7*24*3600)){
            return intval($span/(24*3600))."天前";
        }else{
            return date($format,$time);
        }
    }
}

/** 格式化日期
 * @param $time
 * @return false|string
 */
function timeFormat($time)
{
    if(empty($time)){
        return '';
    }
    return date('Y-m-d H:i:s',$time);
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}




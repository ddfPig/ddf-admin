<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 17:53
 */

namespace app\manage\controller;

use database\Databasebak;
use think\Db;
use think\Request;

class Sysdatabase extends Base
{
    /**数据列表
     * @param Request $request
     * @return mixed
     */
     public function index(Request $request)
     {
         $list  = Db::query('SHOW TABLE STATUS');
         $list  = array_map('array_change_key_case', $list);
         $this->assign('list', $list);
          return $this->fetch();
     }

    /**
     * 优化表
     * @param  String $tables 表名
     */
    public function optimize($tables = null){
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = Db::query("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    return $this->sendData('数据表优化完成！',1);
                } else {
                    return $this->sendData('数据表优化出错请重试！',0);
                }
            } else {
                $list = Db::query("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    return $this->sendData("数据表'{$tables}'优化完成！",1);
                } else {
                    return $this->sendData("数据表'{$tables}'优化出错请重试！",0);
                }
            }
        } else {
            return $this->sendData("请指定要优化的表",0);
        }
    }

    /**
     * 修复表
     * @param  String $tables 表名
     */
    public function repair($tables = null){
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = Db::query("REPAIR TABLE `{$tables}`");

                if($list){
                    return $this->sendData("数据表修复完成!",1);
                } else {
                    return $this->sendData("数据表修复出错请重试!",0);
                }
            } else {
                $list = Db::query("REPAIR TABLE `{$tables}`");
                if($list){
                    return $this->sendData("数据表'{$tables}'修复完成！",1);
                } else {
                    return $this->sendData("数据表'{$tables}'修复出错请重试！",0);
                }
            }
        } else {
            return $this->sendData("请指定要修复的表",0);
        }
    }

    /**
     * 备份数据库
     * @param  String  $tables 表名
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     */
    public function export($tables = null, $id = null, $start = null){
        if($this->request->isPost() && !empty($tables) && is_array($tables)){
            //读取备份配置
            $config = [
                'path'     => config('web.data_backup_path') . DIRECTORY_SEPARATOR,
                'part'     => config('web.data_backup_part_size'),
                'compress' => config('web.data_backup_compress'),
                'level'    => config('web.data_backup_compress_level'),
            ];
            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";

            if(is_file($lock)){
                return $this->sendData("检测到有一个备份任务正在执行，请稍后再试！",0);
            } else {
                //创建锁文件
                file_put_contents($lock, time());
            }
            //检查备份目录是否可写
            if(!is_writeable($config['path'])){
                return $this->sendData("备份目录不存在或不可写，请检查后重试！",0);
            }
            session('backup_config', $config);

            //生成备份文件信息
            $file = [
                'name' => date('Ymd-His', time()),
                'part' => 1,
            ];
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new Databasebak($file, $config);
            if(false !== $Database->create()){
                $tab = ['id' => 0, 'start' => 0];
                return $this->sendData("初始化成功",1,['tables' => $tables, 'tab' => $tab]);
            } else {
                return $this->sendData("初始化失败，备份文件创建失败！",0);
            }
        } elseif ($this->request->isGet() && is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = session('backup_tables');
            //备份指定表
            $Database = new Databasebak(session('backup_file'), session('backup_config'));
            $start  = $Database->backup($tables[$id], $start);
            if(false === $start){ //出错
                return $this->sendData("备份出错!",0);
            } elseif (0 === $start) { //下一表
                if(isset($tables[++$id])){
                    $tab = ['id' => $id, 'start' => 0];
                    return $this->sendData("备份完成",1,['tab' => $tab]);
                } else { //备份完成，清空缓存
                    unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    return $this->sendData("备份完成",1);
                }
            } else {
                $tab  = ['id' => $id, 'start' => $start[0]];
                $rate = floor(100 * ($start[0] / $start[1]));
                return $this->sendData("正在备份...({$rate}%)",1,['tab' => $tab]);
            }
        } else {
            return $this->sendData("请指定要备份的表",0);
        }
    }













}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-30
 * Time: 19:04
 */

namespace app\common\model;


use think\Model;

class Question extends Model
{
    /**常见问题列表
     * @param $request
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function questionList($request)
    {
        $map = [];
        $keywords = $request->param('keywords');
        if($keywords){
            $map[]  = ['question','like','%'.$keywords.'%'];
        }
        $field = "ID,question,answer,status,flag,update_time,sort";
        $list = Question::field($field)->where($map)->wherenull('delete_time')->order('update_time desc')->paginate(config('web.list_rows'));
        return $list;
    }


    /**常见问题详情
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function questionInfo($id)
    {
        $map = [];
        $map[] = ['ID','eq',$id];
        $field = "ID,question,answer,status,flag,update_time,sort";
        return Question::field($field)->where($map)->find();
    }

    /**添加或修改常见问题
     * @param $params
     * @return bool
     */
    public function updateQuestion($params)
    {
        if(empty($params['id'])){
            Question::startTrans();
            try{
                $params['create_time'] = time();
                $params['update_time'] = time();
                $params['status'] =1;
                $result = Question::allowField(true)->save($params);
                if($result){
                    $contents = '添加常见问题:'.$params['question'].',ID:'.$params['ID'];
                    sysLogs($contents);
                }
                Question::commit();
                return $result;
            }catch(\Exception $e){
                Question::rollback();
                return false;
            }
        }else{
            Question::startTrans();
            try{
                $params['update_time'] = time();
                $result = Question::allowField(true)->isUpdate(true)->save($params);
                if($result){
                    $contents = '更新常见问题:'.$params['question'].',ID:'.$params['id'];
                    sysLogs($contents);
                }
                Question::commit();
                return $result;
            }catch (\Exception $e){
                Question::rollback();
                return false;
            }
        }
    }

    /**禁用常见问题
     * @param $id
     * @return int
     */
    public function forbid($id)
    {
        $title = Question::where('ID',$id)->value('question');
        $res = Question::where('ID',$id)->setField('status',0);
        if($res){
            $contents = '禁用常见问题:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**启用常见问题
     * @param $id
     * @return int
     */
    public function resume($id)
    {
        $title = Question::where('ID',$id)->value('question');
        $res = Question::where('ID',$id)->setField('status',1);
        if($res){
            $contents = '启用常见问题:'.$title.',ID:'.$id;
            sysLogs($contents);
        }
        return $res;
    }

    /**彻底删除常见问题
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delQuestion($ids)
    {
        $map = ['id' => $ids];
        $title = Question::where('ID','in',$ids)->column('question');
        $result = Question::where($map)->update([
            'delete_time'=>time(),
        ]);
        if($result){
            $contents = '彻底删除常见问题:'.join(',',$title).',ID:'.join(',',$ids);
            sysLogs($contents);
        }
        return $result;
    }
}
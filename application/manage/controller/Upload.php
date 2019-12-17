<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-07-20
 * Time: 12:24
 */

namespace app\manage\controller;


use app\common\model\Picfiles;
use think\facade\Env;
use think\Image;
use think\Request;

class Upload extends Base
{
    /**上传图片
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function upload(Request $request)
    {
        $file = $this->request->file('file');
        $dir = $request->param('dir');
        //验证过滤
        $validate = [
            'size' => 5242880,
            'ext'=>['jpg', 'gif', 'png', 'jpeg'],
        ];
        //图片地址根目录
        $dates = date('Y-m-d');
        $picRoot = Env::get('root_path').DIRECTORY_SEPARATOR.'public';
        $picPath = DIRECTORY_SEPARATOR.config('web.upload_path').DIRECTORY_SEPARATOR.$dir;

        $info = $file->validate($validate)->rule('uniqid')->move($picRoot.$picPath . DIRECTORY_SEPARATOR . $dates);
        $picInfo = $file->getInfo();
        if($info){
            //图片原图上传路径
            $img_org_path = $picRoot.$picPath . DIRECTORY_SEPARATOR . $dates.DIRECTORY_SEPARATOR.$info->getFilename();

            //图片缩略
            $image = Image::open($img_org_path);
            $size = $image->width();
            $thumbName = $info->getFilename();
            $thumb = $picPath.DIRECTORY_SEPARATOR.$dates.DIRECTORY_SEPARATOR.$thumbName;
            if($size > 1000){
                //缩略图保存路径
                $thumbName = 'thumb_'.$info->getFilename();
                $thumb = $picPath.DIRECTORY_SEPARATOR.$dates.DIRECTORY_SEPARATOR.$thumbName;
                $image->thumb(600, 400)->save($picRoot.$thumb);
                //删除原图
                if(file_exists($img_org_path)){
                    unset($info);
                    unlink($img_org_path);
                }
            }

            //图片写入中间库
            $ID = $this->uuid();
            $picData = [
                'ID'=>$ID,
                'dirName'=>$dir,
                'fileName'=>$thumbName,
                'filePath'=>$thumb,
                'state'=>0,
                'size'=>$picInfo['size'],
                'imgType'=>$picInfo['type'],
                'strPath'=>md5($thumb),
                'uploadTime'=>time(),
            ];
            $Picfiles = new Picfiles();
            $Picfiles->save($picData);
            return $this->sendData('操作成功',1,['url'=>$thumb,'ID'=>$ID]);
        }else{
            return $this->sendData('操作失败'.$file->getError(),0);
        }
    }

    /**上传excel
     * @param Request $request
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function uploadexcel(Request $request)
    {
        $file = $this->request->file('file');

        $dir = $request->param('dir');
        //验证过滤
        $validate = [
            'size' => 5242880,
            'ext'=>['xls', 'xlsx'],
        ];
        //地址根目录
        $dates = date('Y-m-d');
        $picRoot = Env::get('root_path').DIRECTORY_SEPARATOR.'public';
        $picPath = DIRECTORY_SEPARATOR.config('web.upload_path').DIRECTORY_SEPARATOR.$dir;

        $info = $file->validate($validate)->rule('uniqid')->move($picRoot.$picPath . DIRECTORY_SEPARATOR . $dates);

        if($info){
            //原上传路径
            $img_org_path = $picRoot.$picPath . DIRECTORY_SEPARATOR . $dates.DIRECTORY_SEPARATOR.$info->getFilename();
            $res = $this->importExcelToVideo($img_org_path);
            return $res;
        }else{
            return $this->sendData('操作失败'.$file->getError(),0);
        }
    }

    /**上传视频
     * @param Request $request
     * @return array
     */
    public function uploadVideo(Request $request)
    {
        $file = $this->request->file('layuiVideo');
        $dir = $request->param('dir');
        //验证过滤
        $validate = [
            //25M
            'size' => 62914560,
            'ext'=>['mp4','flv'],
        ];
        //图片地址根目录
        $dates = date('Y-m-d');
        $picRoot = Env::get('root_path').DIRECTORY_SEPARATOR.'public';
        $picPath = DIRECTORY_SEPARATOR.config('web.upload_path').DIRECTORY_SEPARATOR.$dir;

        $info = $file->validate($validate)->rule('uniqid')->move($picRoot.$picPath . DIRECTORY_SEPARATOR . $dates);
        if($info){
            $thumbName = $info->getFilename();
            $thumb = $picPath.DIRECTORY_SEPARATOR.$dates.DIRECTORY_SEPARATOR.$thumbName;
            return $this->sendData('操作成功',1,['url'=>$thumb]);
        }else{
            return $this->sendData('操作失败!'.$file->getError(),0);
        }
    }

    /**显示预览视频
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function goLook(Request $request)
    {
        $vid = $request->param('vid');
        $info = \app\common\model\Video::where('ID',$vid)->field('imgs,videourl')->find();
        $this->assign('video',str_replace('\\','\/',$info['videourl']));
        $this->assign('pic',str_replace('\\','\/',$info['imgs']));
        return $this->fetch('video/goLook');
    }
}
<?php
// +----------------------------------------------------------------------
// | KyxsCMS [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018~2019 http://www.kyxscms.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: kyxscms
// +----------------------------------------------------------------------

namespace app\manage\controller;


class Ueditor extends Base
{
	public function index(){
		$config = preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("../public/static/ueditor/config.json"));

		$action = $this->request->get('action');
		switch ($action) {
			 case 'config':
		        $result = $config;
		        break;
		    case 'uploadimage':
		       	$result = $this->uploadPicture();
		        break;
		    case 'uploadvideo':
				$result = $this->uploadvideo();
		        break;
		}
		$callback=$this->request->get('callback');
        //dump($callback);exit;
		if (isset($callback)) {
		    if (preg_match("/^[\w_]+$/",$callback)) {
		        return  $callback . '(' . $result . ')';
		    } else {
		        return json(array(
		            'state'=> 'callback参数不合法'
		        ));
		    }
		} else {
		    return  $result;
		}
	}
	
	 private function uploadPicture(){
	 	$file = $this->request->file('upfile');
	 	$upload_path = '.'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
        $info = $file->validate(['ext'=>'jpg,jpeg,png,gif,webp,bmp','type'=>'image/jpeg,image/png,image/gif,image/webp,image/bmp'])->move($upload_path.'ueditor');
        if($info){
            $data=array(
				'state'=>'SUCCESS',
				'url'=>substr($upload_path,1).'ueditor/'.str_replace('\\','/',$info->getSaveName()),
				'title'=>$info->getFilename(),
				'original'=>$info->getInfo('name'),
				'type'=>'.' . $info->getExtension(),
				'size'=>$info->getSize()
			);
        }else{
            $data=['state'=>$file->getError()];
        }
		return json_encode($data);
    }
	
	private function uploadvideo(){
        $file = $this->request->file('upfile');
        $upload_path = '.'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
        $info = $file->validate(['ext'=>'flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,mov,mp4'])->move($upload_path.'ueditor');
		if($info){
			$data=array(
				'state'=>'SUCCESS',
				'url'=>substr($upload_path,1).'ueditor/'.str_replace('\\','/',$info->getSaveName()),
				'title'=>$info->getFilename(),
				'original'=>$info->getInfo('name'),
				'type'=>'.' . $info->getExtension(),
				'size'=>$info->getSize()
			);
		}else{
			$data=['state'=>$file->getError()];
		}
		return json_encode($data);
    }
}
?>
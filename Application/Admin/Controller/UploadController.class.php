<?php
namespace Admin\Controller;
use Common\Controller\BackendController;
use Common\ORG\qiniu;
class UploadController extends BackendController{
	public function _initialize() {
		parent::_initialize();
	}
	/**
	 * [ajaxReturn description]
	 * @param  integer $status [0:正确]
	 * @param  string  $msg    [description]
	 * @return [type]          [description]
	 */
	protected function ajaxReturn($status=1, $msg='', $url='', $dialog=''){
		// 返回JSON数据格式到客户端 包含状态信息
        $data = array(
            'error' => $status,
            'message' => $msg,
            'url' => $url
        );
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($data));
	}
	/**
	 * [attach 附件上传]
	 * @return [type] [description]
	 */
	public function index(){
		if(IS_POST){
			$dir = I('request.dir','image','trim');
			if(!in_array($dir,array('file','flash','image'))) return false;
			if (!empty($_FILES['imgFile']['name'])) {
				$this->$dir();
			}else{
				$this->ajaxReturn(1, L('illegal_parameters'));
			}
		}
	}
	/**
	 * [image 图片上传]
	 * @return [type] [description]
	 */
	protected function image(){
		$config_params = array(
			'upload_ok'=>false,
			'url'=>'',
			'info'=>''
		);
		//如果开启七牛云，执行七牛云接口，否则执行系统内置程序
		if(C('qscms_qiniu_open')==1){
            $qiniu = new qiniu(array(
            	'maxSize'=>C('qscms_resume_photo_max'),
            	'exts'=>'bmp,png,gif,jpeg,jpg'
            ));
            $img_url = $qiniu->upload($_FILES,'imgFile');
            if($img_url){
            	$config_params['upload_ok'] = true;
				$config_params['url'] = $img_url;
				$config_params['info'] = '';
            }else{
            	$config_params['info'] = $qiniu->getError();
            }
        }else{
        	$date = date('ym/d/');
			$result = $this->_upload($_FILES['imgFile'], 'images/' . $date, array(
					'maxSize' => C('qscms_resume_photo_max'),//图片大小上限
					'uploadReplace' => true,
					'attach_exts' => 'bmp,png,gif,jpeg,jpg'
			));
			if ($result['error']) {
				$config_params['upload_ok'] = true;
				$config_params['url'] = attach($date.$result['info'][0]['savename'],'images');
				$config_params['info'] = '';
			} else {
				$config_params['info'] = $result['info'];
			}
        }
		if($config_params['upload_ok']){
        	$this->ajaxReturn(0, L('upload_success'), $config_params['url']);
        }else{
        	$this->ajaxReturn(1, $config_params['info']);
        }
	}
	protected function flash(){
		$config_params = array(
			'upload_ok'=>false,
			'url'=>'',
			'info'=>''
		);
		//如果开启七牛云，执行七牛云接口，否则执行系统内置程序
		if(C('qscms_qiniu_open')==1){
            $qiniu = new qiniu(array(
            	'maxSize'=>5*1024,
            	'exts'=>'swf,flv'
            ));
            $img_url = $qiniu->upload($_FILES,'imgFile');
            if($img_url){
            	$config_params['upload_ok'] = true;
				$config_params['url'] = $img_url;
				$config_params['info'] = '';
            }else{
            	$config_params['info'] = $qiniu->getError();
            }
        }else{
			$date = date('ym/d/');
			$result = $this->_upload($_FILES['imgFile'], 'flash/' . $date, array(
					'maxSize' => 5*1024,//flash大小上限
					'uploadReplace' => true,
					'attach_exts' => 'swf,flv'
			));
			if ($result['error']) {
				$config_params['upload_ok'] = true;
				$config_params['url'] = attach($date.$result['info'][0]['savename'],'flash');
				$config_params['info'] = '';
			}else {
				$config_params['info'] = $result['info'];
			}
		}
		if($config_params['upload_ok']){
        	$this->ajaxReturn(0, L('upload_success'), $config_params['url']);
        }else{
        	$this->ajaxReturn(1, $config_params['info']);
        }
	}
	protected function file(){
		$config_params = array(
			'upload_ok'=>false,
			'url'=>'',
			'info'=>''
		);
		//如果开启七牛云，执行七牛云接口，否则执行系统内置程序
		if(C('qscms_qiniu_open')==1){
            $qiniu = new qiniu(array(
            	'maxSize'=>5*1024,
            	'exts'=>'doc,docx,xls,xlsx,ppt,htm,html,txt,zip,rar,gz,bz2'
            ));
            $img_url = $qiniu->upload($_FILES,'imgFile');
            if($img_url){
            	$config_params['upload_ok'] = true;
				$config_params['url'] = $img_url;
				$config_params['info'] = '';
            }else{
            	$config_params['info'] = $qiniu->getError();
            }
        }else{
        	$date = date('ym/d/');
			$result = $this->_upload($_FILES['imgFile'], 'file/' . $date, array(
					'maxSize' => 5*1024,//文件大小上限
					'uploadReplace' => true,
					'attach_exts' => 'doc,docx,xls,xlsx,ppt,htm,html,txt,zip,rar,gz,bz2'
			));
			if ($result['error']) {
				$config_params['upload_ok'] = true;
				$config_params['url'] = attach($date.$result['info'][0]['savename'],'file');
				$config_params['info'] = '';
			} else {
				$config_params['info'] = $result['info'];
			}
        }
		if($config_params['upload_ok']){
        	$this->ajaxReturn(0, L('upload_success'), $config_params['url']);
        }else{
        	$this->ajaxReturn(1, $config_params['info']);
        }
	}
	/**
	 * [attach 4.2.23图片上传]
	 * @return [type] [description]
	 */
	public function form_upload(){
		$name = I('request.name','logo_home','trim');
		$dir = I('request.dir','resource','trim');
		if(!in_array($dir,array('resource','images','mall','jobfair','jobfair_tpl','link_logo','hrtools','consultant'))) return false;
		if(IS_POST){		
			if (!empty($_FILES[$name]['name']))
			{
				$maxSize   = 2097152;
				$rootPath  = C('qscms_attach_path').$dir.'/'; 
				$upload = new \Common\ORG\UploadFile();// 实例化上传类
				$upload->maxSize   =     $maxSize ;// 设置附件上传大小
				$upload->uploadReplace=true;//存在同名文件是否是覆盖 
				$upload->allowExts      =     array('png','gif','bmp','jpg','jpeg');// 设置附件上传类型
				$upload->rootPath  =     $rootPath; // 设置附件上传根目录
				$upload->savePath  =     $rootPath; // 设置附件上传（子）目录
            	$upload->thumbPrefix = '';//缩略图的文件前缀，默认为thumb_
            	$upload->thumbSuffix = '_thumb';//缩略图的文件后缀，默认为空 
            	$upload->thumbExt = '';//指定缩略图的扩展名
            	$upload->thumbRemoveOrigin = false;//生成缩略图后是否删除原图 
				// 上传文件 
				if(in_array($name, array('logo_home','logo_user','logo_other'))){
					$upload->saveRule = $name;
				}
				$info   =   $upload->uploadOne($_FILES[$name]);
				if(!$info) {// 上传错误提示错误信息
					$this->ajaxReturn(0,$upload->getErrorMsg());
				}else{// 上传成功
					//生成缩略图
					$image = new \Common\ORG\ThinkImage();
	                $path = $info[0]['savepath'].$info[0]['savename'];
	                $imageModel = $image->open($path);
	                $thumb_width = $imageModel->width();
	                $thumb_height = $imageModel->height();
	                $imageModel->thumb($thumb_width,$thumb_height)->save($path);
					//生成缩略图完毕
					$this->ajaxReturn(1,'上传成功',array('src'=>$info[0]['savepath'].$info[0]['savename'].'?_t='.time(),'savename'=>$info[0]['savename']));
				}				
			}
			else
			{
				$this->ajaxReturn(0,'参数非法');
			}
		}
	}
}
?>
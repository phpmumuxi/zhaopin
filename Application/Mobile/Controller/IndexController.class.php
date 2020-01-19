<?php
namespace Mobile\Controller;
use Mobile\Controller\MobileController;
class IndexController extends MobileController{
	// 初始化函数
	public function _initialize(){
		parent::_initialize();
	}
	public function index(){
		$this->show_index_jobs();
		$this->show_index_total();
		$this->show_index_ads();
        $this->wx_share();
		$this->display();
	}
	/**
	 * 首页统计
	 */
	public function show_index_total(){
		$total['company'] = D('CompanyProfile')->count();
		$total['job'] = D('Jobs')->count();
		$total['resume'] = D('Resume')->count();
		$this->assign('index_total',$total);
	}
	/**
	 * 首页广告
	 */
	protected function show_index_ads(){
		$time_now = time();
		$index_focus_where['is_display'] = 1;
		$index_focus_where['alias'] = 'QS_mobile_indexfocus';
		$index_focus_where['starttime'] = array('elt', $time_now);
        $index_focus_where['deadline'] = array(array('egt',$time_now),array('eq',0), 'or');
		$index_focus = D('AdMobile')->get_ad_list($index_focus_where);
		$this->assign('index_focus',$index_focus);
		$this->assign('index_block',$index_block);
	}
	/**
	 * 首页显示推荐职位
	 */
	protected function show_index_jobs(){
		//已登录，千人千面是否开启
		if(C('qscms_mobile_index_login_recommend')==1 && C('visitor.uid')){
			$type = 'recommend_jobs';
		}else{
			$type = C('qscms_mobile_index_jobs_type').'_jobs';
		}
		if($type=='nearby_jobs'){
			$recommend_jobs_nearby = 1;
		}else{
			$recommend_jobs_nearby = 0;
		}
		$this->assign('recommend_jobs_nearby',$recommend_jobs_nearby);
		$this->assign('recommend_jobs_type',$type);
	}
    public function recommend_jobs_index($type=''){
        $type = $type ? $type : I('get.type','','trim,badword');
        !$type && IS_AJAX && $this->ajaxReturn(0,'数据类型错误！');
        if(!in_array($type, array('recommend_jobs','nearby_jobs','new_jobs','allowance_jobs'))) $this->ajaxReturn(0,'数据类型错误！');
        $where = array(
            '显示数目' => '5'
        );
        if($type=='recommend_jobs'){
            $jobcategory = M('Resume')->where(array('uid'=>C('visitor.uid')))->getField('intention_jobs_id');
            $where['职位分类'] = $jobcategory;
            $where['排序'] = 'stickrtime';
            $title = "推荐职位";
            $more_url = url_rewrite('QS_jobslist');
        }elseif($type=='nearby_jobs'){
        	$lng = I('get.lng','0','trim,badword');
        	$lat = I('get.lat','0','trim,badword');
            $where['经度'] = $lng;//112.732929
            $where['纬度'] = $lat;//37.714684
            $where['搜索范围'] = 20;
            $where['分页显示'] = 1;
            $title = "附近职位";
            $more_url = url_rewrite('QS_jobslist',array('lng'=>$lng,'lat'=>$lat,'range'=>20));
        }
        elseif($type=='allowance_jobs'){
        	$where['搜索内容'] = 'allowance';
            $title = "红包职位";
            $more_url = url_rewrite('QS_jobslist');
        }else{
            $where['排序'] = 'rtime';
            $title = "最新职位";
            $more_url = url_rewrite('QS_jobslist');
        }
        $jobs_mod = new \Common\qscmstag\jobs_listTag($where);
        $jobs_list = $jobs_mod->run();
        if(empty($jobs_list['list'])){
        	unset($where['职位分类']);
        	$where['排序'] = 'rtime';
            $title = "最新职位";
            $more_url = url_rewrite('QS_jobslist');
            $jobs_mod = new \Common\qscmstag\jobs_listTag($where);
        	$jobs_list = $jobs_mod->run();
        }
        $this->assign('title',$title);
        $this->assign('more_url',$more_url);
        $this->assign('jobs_list',$jobs_list['list']);
        if(IS_AJAX){
            $data['html'] = $this->fetch('Ajax_tpl/recommend_jobs_index');
            $this->ajaxReturn(1,'职位信息获取成功！',$data);
        }
    }
	public function compatibility(){
		$this->display();
	}
	public function app_download(){
		$page_seo['title'] = 'APP下载 - '.C('qscms_site_name');
		$this->assign('page_seo',$page_seo);
		$this->display();
	}
	public function ajax_jump_nearby($url,$lat,$lng){
		$range = strstr($url,'range');
		$range = ltrim($range,'range=');
		$range = ltrim($range,'range/');
		$this->ajaxReturn(1,'success',U('Mobile/Jobs/index',array('range'=>$range,'lat'=>$lat,'lng'=>$lng)));
	}
}
?>
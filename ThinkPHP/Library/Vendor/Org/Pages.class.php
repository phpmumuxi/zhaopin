<?php
// +----------------------------------------------------------------------
// |分页类
// +----------------------------------------------------------------------
// | Author: justmepzy(justmepzy@gmail.com)
// +----------------------------------------------------------------------
class Pages{
    // 起始行数
    public $firstRow;
    // 列表每页显示行数
    public $listRows;
    // 分页总页面数
    protected $totalPages;
    // 总行数
    protected $totalRows;
    // 当前页数
    protected $nowPage;
    // 分页的栏的总页数
    protected $coolPages;
    // 分页栏每页显示的页数
    protected $rollPage;
    //是否显示linkpage
    protected $isShowLinkPage = FALSE;
    //是否显示输入页数跳转
    public $isJumpPage = FALSE;
    //是否使用Ajax,默认不使用
    public $AjaxType = FALSE;
    //JavaScript中使用的获取数据方法名
    public $function_name = 'ajax_page';
    // 分页显示定制
    protected $config = array('header'=>'条','prev'=>'上一页','next'=>'下一页','first'=>'首页','last'=>'末页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end% %jump%');
    /**
     *
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $rollpage  是否显示linkpage条数
     */
    public function __construct($totalRows,$listRows,$rollpage){
        $this->totalRows = $totalRows;
        $this->listRows = $listRows;
        $this->rollPage = $rollpage;
        $this->listRows = !empty($listRows)?$listRows:10;
        $this->isShowLinkPage = empty($rollpage)?false:true;
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->nowPage  = !empty($_REQUEST['page'])?$_REQUEST['page']:1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);

    }
    /**
     * 设置显示样式
     * @access public
     */
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = 'page';
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $request_url = $_SERVER['REQUEST_URI'];

        if(strpos($request_url,'?')){
            $url  =  $request_url;
        }else{
            $url  =  $request_url.'?';
        }

        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }

        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            if($this->AjaxType)
                $upPage='<a href=javascript:'.$this->function_name.'('.$upRow.');>'.$this->config['prev'].'</a>';//ajax方式
            else
                $upPage='<a href=\''.$url.'&'.$p.'='.$upRow.'\'>'.$this->config['prev'].'</a>';
        }else{
            $upPage='';
        }

        if ($downRow <= $this->totalPages){
            if($this->AjaxType)
                $downPage='<a href=javascript:'.$this->function_name.'('.$downRow.');>'.$this->config['next'].'</a>';//ajax方式
            else
                $downPage='<a href=\''.$url.'&'.$p.'='.$downRow.'\'>'.$this->config['next'].'</a>';
        }else{
            $downPage='';
        }
        // << < > >>
        if($this->nowPage == 1){
            $theFirst = '';
            $prePage = '';
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
            if($this->AjaxType)
                $theFirst = '<a href=javascript:'.$this->function_name.'(1);>'.$this->config['first'].'</a>';//ajax方式
            else
                $theFirst = '<a href=\''.$url.'&'.$p.'=1\' >'.$this->config['first'].'</a>';
        }
        if($this->nowPage == $this->totalPages){
            $nextPage = '';
            $theEnd='';
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            if($this->AjaxType)
                $theEnd = '<a href=javascript:'.$this->function_name.'('.$theEndRow.');>'.$this->config['last'].'</a>';//ajax方式
            else
                $theEnd = '<a href=\''.$url.'&'.$p.'='.$theEndRow.'\' >'.$this->config['last'].'</a>';
        }
        // 1 2 3 4 5
        if($this->isShowLinkPage){
            $linkPage = '';
            for($i=1;$i<=$this->rollPage;$i++){
                $page=($nowCoolPage-1)*$this->rollPage+$i;
                //保证linkpage保持当前页不是最后一个
                if($this->nowPage%$this->rollPage ==0 ){
                    $page = ($nowCoolPage-1)*$this->rollPage+$i+$this->rollPage-1;
                }
                if($page!=$this->nowPage){
                    if($page<=$this->totalPages){
                        if($this->AjaxType)
                            $linkPage .= '&nbsp;<a href=javascript:'.$this->function_name.'('.$page.');>&nbsp;'.$page.'&nbsp;</a>';//ajax方式
                        else
                            $linkPage .= '&nbsp;<a href=\''.$url.'&'.$p.'='.$page.'\'>&nbsp;'.$page.'&nbsp;</a>';
                    }else{
                        break;
                    }
                }else{
                    if($this->totalPages != 1){
                        $linkPage .= '&nbsp;<span class=\'current\'>'.$page.'</span>';
                    }
                }
            }
        }
        //jump page
        if($this->isJumpPage){
            $jump = '<input type=\'text\' id=\'jumppage\' value = \''.$this->nowPage.'\' style="border:1px solid #ccc;text-align:center;width:36px;height:23px;margin-right:10px;">';
            $jump .='<input type=\'button\' id=\'jumppagebutton\' value=\'确定\' onclick=\'go_page('.$this->nowPage.')\' style="background:#090;color:#fff;text-align:center;width:43px;height:25px;">';
            $jump .='<script>function go_page(page){var jumptopage = document.getElementById(\'jumppage\').value;var topage;';
            $jump .='if(jumptopage==page||isNaN(jumptopage)){return false;}else{ ';
            $jump .='if(jumptopage>'.$this->totalPages.'){topage = '.$this->totalPages.'}';
            $jump .='else if(jumptopage<1){topage = 1;}else{topage = jumptopage;}';
            if($this->AjaxType){
                $jump .= $this->function_name.'(topage);';
            }else{
                $jump .='window.location.href = \''.$url.'&'.$p.'=\'+topage;';
            }
            $jump .='}}</script>';
        }
        $pageStr=str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%','%jump%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd,$jump),$this->config['theme']);
        return $pageStr;
    }

}
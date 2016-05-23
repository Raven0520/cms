<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    
    public function index(){

        $news = D("News")->maxCount();
        //调试
//        print_r($news);exit();
        $newsCount =D("News")->getNewsCount(array('status'=>1));
        $positionCount = D("Position")->getPositionsCount(array('status'=>1));
        $adminCount = D("Admin")->getLastLoginUsers();

        $this->assign("news",$news);
        $this->assign("newsCount",$newsCount);
        $this->assign("positionCount",$positionCount);
        $this->assign("adminCount",$adminCount);

    	$this->display();
    }

    public function main() {
    	$this->display();
    }
}
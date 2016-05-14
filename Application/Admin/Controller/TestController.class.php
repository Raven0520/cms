<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/13
 * Time: 0:42
 */

namespace Admin\Controller;
use Think\Controller;


class TestController extends CommonController
{
    public function index(){

        $conds = array();
        $title = $_GET['title'];
        if($title){
            $conds['title'] = $title;
        }
        if($_GET['catid']){
            $conds['catid'] = intval($_GET['catid']);
        }

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 10;
        $news = D("News")->getNews($conds,$page,$pageSize);
        $count = D("News")->getNewsCount($conds);

        $res = new \Think\Page($count,$pageSize);
        $pageres = $res->show();

        $this->assign("pageres",$pageres);
        $this->assign("news",$news);
        $test = D("Menu")->getBarMenus();

        print_r($news);
        echo "<br/>";
        print_r($test);
        $this->assign("webSiteMenu",D("Menu")->getBarMenus());
        $this->display();
    }
}
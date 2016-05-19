<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends CommonController {
    public function index(){
        //获取排行
        $rankNews = $this->getRank();

        //获取首页大图
        $topPicNews = D("PositionContent")->select(array('status'=>1,'position_id'=>1),1);
        //获取首页三小图
        $topSmallNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),3);

        //获取文章内容
        $listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),30);
        //获取右侧广告位
        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>10),2);

        $this->assign('result', array(
            'topPicNews' =>$topPicNews,
            'topSmallNews' =>$topSmallNews,
            'listNews' => $listNews,
            'advNews' => $advNews,
            'rankNews' => $rankNews,
            'catid' => 0,
        ));
        $this->display();
    }
}
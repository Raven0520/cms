<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/19
 * Time: 10:38
 */

namespace Home\Controller;
use Think\Controller;

class DetailController extends CommonController
{
    public function index(){
        //获取文章id
        $id = intval($_GET['id']);
        if (!$id || $id<0){
            $this->error('ID不合法');
        }

        $news = D("News")->find($id);
        if (!$news || $news['status'] !=1){
            $this->error('ID不存在或者咨询被关闭');
        }

        $count = intval($news['count']) + 1;
        D("News")->updateCount($id,$count);
        $content = D("NewsContent")->find($id);
        $news['content'] = htmlspecialchars_decode($content['content']);

        //获取排行
        $rankNews = $this->getRank();
        //获取右侧广告位
        $advNews = D("PositionContent")->select(array('status'=>1,'position_id'=>10),2);

        $this->assign('result',array(
            'rankNews' => $rankNews,
            'advNews' => $advNews,
            'catid' => $news['catid'],
        ));
        $this->assign('news',$news);

        $this->display();
    }
}
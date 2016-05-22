<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;

class IndexController extends CommonController {
    public function index($type = ''){
        //获取排行
        $rankNews = $this->getRank();

        //获取首页大图
        $topPicNews = D("PositionContent")->select(array('status'=>1,'position_id'=>1),1);
        //获取首页三小图
        $topSmallNews = D("PositionContent")->select(array('status'=>1,'position_id'=>3),3);

        //获取文章内容
        $listNews = D("News")->select(array('status'=>1,'thumb'=>array('neq','')),20);
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
        /*
         * 生成页面静态化
         */
        if ($type == 'buildHtml'){
            $this->buildHtml('index',HTML_PATH,'Index/index');
        }else {
            $this->display();
        }
    }

    public function build_html(){
        $this->index('buildHtml');
        return show(1,'首页缓存生成成功');
    }
    /*
     * 通过Linux定时任务完成定时生成静态化页面操作
     */
    public function crontab_build_html(){
        if (APP_CRONTAB !=1){
            die("the_file_must_exec_crontab");
        }
        $result = D("Basic")->select();
        if (!$result['cacheindex']){
            die("系统没有设置自动更新");
        }
        $this->index('buildHtml');

    }

    public function getCount(){
        if (!$_POST){
            return show(0,'没有任何内容');
        }
        $newsIds = array_unique($_POST);
        try{
            $list = D("News")->getNewsByNewsIdIn($newsIds);
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
        if (!$list){
            return show(0,'Not Data');
        }
        $data = array();
        foreach ($list as $k => $v){
            $data[$v['news_id']] = $v['count'];
        }
        return show(1,'success',$data);
    }
}
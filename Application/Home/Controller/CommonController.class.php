<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/18
 * Time: 17:25
 */

namespace Home\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
        header("Content-type: text/html; charset=utf-8");
        parent::__construct();
    }

    /*
     * 获取排行数据
     */
    public function getRank()
    {
        $conds ['status'] = 1;
        $news = D("News")->getRank($conds, 10);
        return $news;
    }

    //404页面处理
    public function error($message = '')
    {
        $message = $message ? $message : '系统发生错误';
        $this->assign('message', $message);
        $this->display("Index/error");
    }
}
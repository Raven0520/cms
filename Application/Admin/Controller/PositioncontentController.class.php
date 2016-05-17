<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/15
 * Time: 11:10
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends CommonController
{
    public function index(){
        //获取推荐位名称
        $positions = D("Position")->getNormalPositions();
        //获取推荐位内容
        $data['status'] = array('neq',-1);
        if($_GET['title']){
            $data['title'] = trim($_GET['title']);
            $this->assign('title',$data['title']);
        }
        $data['position_id'] = $_GET['position_id']? intval($_GET['position_id']):$positions[0]['id'];
        $contents = D("PositionContent")->select($data);

        $this->assign('positions',$positions);
        $this->assign('contents',$contents);
        $this->assign('position_id',$data['position_id']);

        $this->display();
    }

    public function add(){
        //判断传入数值是否正确
        if ($_POST){
            if (!$_POST['position_id'] || !isset($_POST['position_id'])){
                return show(0,'推荐位ID不能为空');
            }
            if (!$_POST['title'] || !isset($_POST['title'])){
                return show(0,'推荐位标题不能为空');
            }
            if (!$_POST['url'] && !$_POST['news_id']){
                return show(0,'url和news_id不能同时为空');
            }
            if (!$_POST['thumb'] || !isset($_POST['thumb'])){
                if ($_POST['news_id']){
                    $res = D("News")->find($_POST['news_id']);
                    if ($res && is_array($res)){
                        $_POST['thumb'] = $res['thumb'];
                    }
                }else{
                    return show(0,'图片不能为空');
                }
            }
            //插入数据库
            try{
                $id = D("PositionContent")->insert($_POST);
                if ($id){
                    return show(1,'新增成功');
                }
                return show(0,'新增失败');
            }catch (Exception $e){
                return show(0,$e->getMessage());
            }

        }else {
            $positions = D("Position")->getNormalPositions();

            $this->assign('positions', $positions);
        }
        $this->display();
    }
}
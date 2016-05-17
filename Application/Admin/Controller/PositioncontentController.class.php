<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/15
 * Time: 11:10
 */

namespace Admin\Controller;
use Think\Controller;

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
}
<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/15
 * Time: 11:48
 */

namespace Admin\Controller;
use Think\Controller;

class PositionController extends CommonController
{
    public function index(){

        $data = array();
        if (isset($_REQUEST['status']) && in_array($_REQUEST['status'], array(1, 0))) {
            $data['status'] = intval($_REQUEST['status']);
            $this->assign('status', $data['status']);
        } else {
            $this->assign('status', -1);
        }

        /**
         * 分页操作逻辑
         */
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 3;
        $Positions = D("Position")->getPositions($data, $page, $pageSize);
        $PositionsCount = D("Position")->getPositionsCount($data);

        $res = new \Think\Page($PositionsCount, $pageSize);
        $pageRes = $res->show();
        $this->assign('pageRes', $pageRes);
        $this->assign('Positions', $Positions);

        $this->display();
    }

    public function add(){
        //判断是否有提交数据
        if($_POST && is_array($_POST)) {
            if (!isset($_POST['name']) || !$_POST['name']) {
                return show(0, '推荐位名称不能为空');
            }
            //执行新增操作
            $positionId = D("Position")->insert($_POST);
            if ($positionId) {
                return show(1, '新增推荐位成功');
            }
            return show(0, '新增推荐位失败');
        }

        $this->display();
    }
}
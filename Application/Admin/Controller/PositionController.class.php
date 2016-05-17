<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/15
 * Time: 11:48
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class PositionController extends CommonController
{
    public function index()
    {

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

    public function add()
    {
        //判断是否有提交数据
        if ($_POST) {
            if (!isset($_POST['name']) || !$_POST['name']) {
                return show(0, '推荐位名称不能为空');
            }
            //判断是否为更新操作
            if ($_POST['id']) {
                return $this->save($_POST);
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

    //改变推荐位状态
    //改变推荐位状态
    public function setStatus(){
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data,'Position');
    }

    //获取推荐位编辑器内容
    public function edit()
    {
        $positionId = $_GET['id'];
        if (!$positionId) {
            $this->redirect('/admin.php?c=position');
        }
        $positions = D("Position")->find($positionId);
        if (!$positions) {
            $this->redirect('/admin.php?c=position');
        }

        $this->assign('position', $positions);

        $this->display();
    }

    //保存推荐位修改内容
    public function save($data)
    {
        $positionId = $data['id'];
        unset($data['id']);

        try {
            $id = D("Position")->updatePositionsById($positionId, $data);
            if (!$id) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        } catch (Exception $e) {
            return show(0, $e->getMessage());
        }
    }
}
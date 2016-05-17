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
                        $_POST['create_time'] = $res['create_time'];
                    }
                }else{
                    return show(0,'图片不能为空');
                }
            }
            //判断是否为更新操作
            if ($_POST['id']){
                return $this->save($_POST);
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

    //推荐位内容修改功能
    public function edit(){

        $id = $_GET['id'];
        if (!$id){
            $this->redirect('/admin.php?c=positioncontent');
        }
        $position = D("PositionContent")->find($id);
        if (!$position){
            $this->redirect(('/admin.php?c=positioncontent'));
        }
        $positions = D("Position")->getNormalPositions();

        $this->assign('positions',$positions);
        $this->assign('vo',$position);
        $this->display();
    }
    //更新推荐位内容数据
    public function save($data){
        $id = $data['id'];
        unset($data['id']);

        try{
            $res = D("PositionContent")->updateById($id,$data);
            if ($res){
                return show(1,'更新成功');
            }
            return show(0,'更新失败');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
    }
    //改变推荐位状态
    public function setStatus(){
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data,'PositionContent');
    }
    //调用父类方法排序
    public function listorder($model = 'PositionContent')
    {
        return parent::listorder($model);
    }
}
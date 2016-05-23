<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/20
 * Time: 16:50
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class AdminController extends CommonController
{
    public function index(){
        $admins = D("Admin")->getAdmins();

        $this->assign('admins',$admins);
        $this->display();
    }

    public function add(){
        if ($_POST){
            if (!isset($_POST['username']) || !$_POST['username']){
                return show(0,'用户名不能为空');
            }
            if (!isset($_POST['password']) || !$_POST['password']){
                return show(0,'密码不能为空');
            }
            $_POST['password'] = getMd5Password($_POST['password']);
            //判断用户名是否存在
            $admin = D("Admin")->getAdminByUsername($_POST['username']);
            if ($admin && $admin['status'] !=-1){
                return show(0,'用户名已存在');
            }
            $id = D("Admin")->insert($_POST);
            if (!$id){
                return show(0,'新增失败');
            }
            return show(1,'新增成功');
        }
        $this->display();
    }
    //修改用户状态
    public function setStatus()
    {
        $data = array(
            'id' => intval($_POST['id']),
            'status' => intval($_POST['status']),
        );
        return parent::setStatus($data, "Admin");
    }
    /**
     * 用户中心
     */
    public function personal(){
        $res = $this->getLoginUser();//从session中获取的数据
        $user = D("Admin")->getAdminByAdminId($res['admin_id']);//从数据库中获取的数据
        $this->assign("vo",$user);
        $this->display();
    }
    /**
     * 保存修改后的数据
     */
    public function save()
    {
        $user = $this->getLoginUser();
        if (!$user) {
            return show(0, '用户不存在');
        }
        $data['realname'] = $_POST['realname'];
        $data['email'] = $_POST['email'];

        try {
            $id = D("Admin")->updateByAdminId($user['admin_id'], $data);
            if ($id === false) {
                return show(0, '配置失败');
            }
            return show(1, '配置成功');
        } catch (Exception $e) {
            return show(0, $e->getMessage());
        }
    }
}
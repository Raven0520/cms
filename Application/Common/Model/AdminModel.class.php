<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/9
 * Time: 16:12
 */

namespace Common\Model;

use Think\Model;

class AdminModel extends Model
{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('admin');
    }

    public function getAdminByUsername($username)
    {
        $ret = $this->_db->where('username="' . $username . '"')->find();
        return $ret;
    }

    //获取用户管理列表
    public function getAdmins()
    {
        return $this->_db->select();
    }

    /**
     * 通过Admin_id 更新状态
     */
    public function updateStatusById($id, $status)
    {
        if (!is_numeric($status)) {
            throw_exception("status不能为非数字");
        }
        if (!is_numeric($id) || !$id) {
            throw_exception("ID不合法");
        }
        $data['status'] = $status;
        return $this->_db->where("admin_id=" . $id)->save($data);
    }

    /**
     * 增加新用户
     */
    public function insert($data)
    {
        if (!$data || !is_array($data)) {
            return 0;
        }

        return $this->_db->add($data);
    }

    /**
     * 更新用户最后登录时间
     */
    public function updateByAdminId($where, $data = array())
    {
        return $this->_db->where("admin_id=" . $where)->save($data);
    }

    /**
     * 从数据表中获取用户数据
     */
    public function getAdminByAdminId($id)
    {
        if (!$id || !is_numeric($id)) {
            return show(0, 'ID不合法');
        }
        return $this->_db->where("admin_id=" . $id)->find();
    }

    /**
     * 获取用户登录数
     */
    public function getLastLoginUsers()
    {
        //标注起始时间
        $time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $data = array(
            'status' => 1,
            'lastlogintime' => array("gt", $time),
        );
        $res = $this->_db->where($data)->count();
        return $res['tp_count'];
    }
}
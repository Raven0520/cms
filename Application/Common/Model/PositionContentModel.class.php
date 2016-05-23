<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/16
 * Time: 15:43
 */

namespace Common\Model;

use Think\Model;

class PositionContentModel extends Model
{
    private $_db = '';

    public function __construct()
    {
        return $this->_db = M("position_content");
    }

    //执行插入操作
    public function insert($data = array())
    {
        if (!$data || !is_array($data)) {
            return 0;
        }
        if (!$data['news_id']) {
            $data['create_time'] = time();
        }
        return $this->_db->add($data);
    }

    //执行查询操作
    public function select($data = array(), $limit = 0)
    {
        if ($data['title']) {
            $data['title'] = array('like', '%' . $data['title'] . '%');
        }
        $this->_db->where($data)->order('listorder desc,id desc');
        if ($limit) {
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();

        return $list;
    }

    //提取编辑框内容
    public function find($id)
    {
        $data = $this->_db->where('id=' . $id)->find();
        return $data;
    }

    //更新数据
    public function updateById($id, $data)
    {
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        if (!$data || !is_array($data)) {
            throw_exception('数据不合法');
        }
        return $this->_db->where('id=' . $id)->save($data);
    }

    public function updateStatusById($id, $status)
    {
        if (!is_numeric($status)) {
            throw_exception('status不能为非数字');
        }
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data['status'] = $status;

        return $this->_db->where("id=" . $id)->save($data);
    }

    //排序的方法
    public function updateListorderById($id, $listorder)
    {
        if (!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }
        $data = array('listorder' => intval($listorder));
        return $this->_db->where("id=" . $id)->save($data);
    }
}
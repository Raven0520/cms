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
    public function insert($data =array()){
        if (!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }

    //执行查询操作
    public function select($data = array(),$limit = 0){
        if ($data['title']){
            $data['title'] = array('like','%'.$data['title'].'%');
        }
        $this->_db->where($data)->order('listorder desc,id desc');
        if ($limit){
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();

        return $list;
    }
}
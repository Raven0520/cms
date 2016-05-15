<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/15
 * Time: 12:21
 */

namespace Common\Model;
use Think\Model;

class PositionModel extends Model
{
    private $_db = "";

    public function __construct()
    {
        //实例化数据库
        $this->_db = M("position");
    }

    public function insert($data = array()){

        if (!$data || !is_array($data)){
            return 0;
        }
        $data['create_time'] = time();
        return $this->_db->add($data);
    }

    //获取推荐位信息
    public function getPositions($data,$page,$pageSize = 10){

        $data['status'] = array('neq' , -1);
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($data)->limit($offset,$pageSize)->select();
        return $list;
    }

    public function getPositionsCount($data = array()){
        $data['status'] = array('neq',-1);
        return $this->_db->where($data)->count();
    }

    public function getNormalPositions(){
        $condition = array('status' => 1);
        $list = $this->_db->where($condition)->order('id')->select();
        return $list;
    }

    public function updateStatusById($id,$status){
        if(!is_numeric($status)){
            throw_exception('status不能为非数字');
        }
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        $data['status'] = $status;

        return $this->_db->where("id=".$id)->save($data);
    }

    //查找数据 用于填充编辑器内容
    public function find($id){
        $data = $this->_db->where('id='.$id)->find();
        return $data;
    }
    
}
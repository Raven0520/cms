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
        return $this->_db->add($_POST);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/18
 * Time: 14:15
 */

namespace Common\Model;
use Think\Model;

class BasicModel extends Model
{
    //储存基本配置信息
    public function save($data = array()){
        if (!$data){
            return show(0,'没有提交的数据');
        }
        $id = F("Basic_web_config",$data);
        return $id;
    }
    //读取基本配置信息
    public function select(){
        return F("Basic_web_config");
    }

}
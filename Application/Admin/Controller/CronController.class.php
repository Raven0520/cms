<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/20
 * Time: 14:25
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class CronController
{
    public function dumpmysql(){
        $result = D("Basic")->select();
        if (!$result['dumpmysql']){
            die("系统没有开启自动备份数据库");
        }
        
        $shell = "mysqldump -u".C("DB_USER")
                ." -p".C("DB_PWD")." ".C("DB_NAME")." > /tep/cms".date("Ymd").".sql";
        exec($shell);
    }
}
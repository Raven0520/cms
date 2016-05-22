<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/19
 * Time: 15:16
 */
//应用入口文件

//检测PHP环境
if (version_compare(PHP_VERSION,'5.3.0','<')) die('require PHP > 5.3.0');
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

define('APP_CRONTAB',1);
if (!$argv || count($argv) < 4){
    die("parmas_is_errpr");
}
$dir = dirname(__FILE__);
define('HTML_PATH',dir.'/');
$_GET['m'] = !isset($_GET['m']) ? $argv[1] : 'admin';
$_GET['c'] = !isset($_GET['c']) ? $argv[2] : 'index';
$_GET['a'] = !isset($_GET['a']) ? $argv[3] : 'index';

// 定义应用目录
define('APP_PATH','./Application/');

// 引入ThinkPHP入口文件
require 'ThinkPHP/ThinkPHP.php';
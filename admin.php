<?php
/**
 * Created by PhpStorm.
 * User: Raven
 * Date: 2016/5/9
 * Time: 14:58
 */
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

//简化URL地址
$_GET['m'] = (!isset($_GET['m']) || !$_GET['m'])? 'admin': $_GET['m'];
$_GET['c'] = (!isset($_GET['c']) || !$_GET['c'])? 'index': $_GET['c'];
$_GET['a'] = (!isset($_GET['a']) || !$_GET['a'])? 'index': $_GET['a'];

// 定义应用目录
define('APP_PATH','./Application/');

// 引入ThinkPHP入口文件
require 'ThinkPHP/ThinkPHP.php';
<?php

/**
 *公用的方法
 */

function show ($status,$message,$data=array()){
    $result = array(
        'status' => $status,
        'message' => $message,
        'data' => $data,
    );

    exit(json_encode($result));
}

function getMd5Password($password){
    return md5($password.C('MD5_PRE'));
}

function getMenuType ($type){
    return $type == 1?"后端菜单":"前端导航";
}

function getMenuStatus ($status){
    if($status == 0){
        $str = '关闭';
    }elseif ($status == 1) {
        $str = '正常';
    }elseif($status == -1){
        $str = '删除';
    }
    return $str;
}

//后台左侧菜单连接方法
function getAdminMenuUrl($nav){
    $url = '/admin.php?c='.$nav['c'].'&a='.$nav['a'];
    if($nav['f'] == 'index') {
        $url = '/admin.php?c='.$nav['c'];
    }
    return $url;
}

//后台左侧菜单高亮处理
function getActive ($navc){
    $c = strtolower(CONTROLLER_NAME);
    if(strtolower($navc) == $c){
        return 'class="active"';
    }
    return '';
}

//处理后台文章管理工具图片上传功能
function showKind($status,$data){
    header('Content-type:application/json;charset=UTF-8');
    if($status == 0){
        exit(json_encode(array('error' =>0,'url' =>$data)));
    }else {
        exit(json_encode(array('error' =>1,'message' => '上传失败')));
    }
}

//获取登陆用户信息

function getLoginUsername(){
    return $_SESSION['adminUser']['username']?$_SESSION['adminUser']['username']:'';
}

function getCatName($navs,$id){
    foreach ($navs as $nav){
        $navList[$nav['menu_id']] = $nav['name'];
    }

    return isset($navList[$id] )? $navList[$id] : '';
}

function getCopyFromById ($id){
    $copyfrom = C("COPY_FROM");
    return $copyfrom[$id] ? $copyfrom[$id] : '';
}

function isThumb($thumb){
    if ($thumb){
        return '<span style="color:red">有</span>';
    }
    return '无';
}
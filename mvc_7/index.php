<?php
header('content-type:text/html;charset=utf-8');

session_start();                //开启session

//定义项目根目录常量
define('ROOT_DIR', dirname(__FILE__));

include ROOT_DIR.'/lib/controller.php';

$mvc = new controller();


$mvc->init();

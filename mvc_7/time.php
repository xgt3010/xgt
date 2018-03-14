<?php
/**
 * @Author: 李厚龙
 * @Date:   2017-10-13 20:41:46
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-10-14 08:58:51
 */
header('content-type:text/html;charset=utf8');

/*要求密钥验证*/

$hide="demo";

/*用户的唯一标识*/
$appkey=$_GET['appkey'];

/*验证用户是否合法*/
$sign=md5($appkey.$hide.$_GET['times']);
if($sign !=$_GET['sign']) die('非法访问!');

/*判断用户浏览时间*/
if(time()>$_GET['times']+10) die('链接失效!');

//返回当前时间 显示在首页
$date=date('Y-m-d H:i:s',time());

echo $_GET['back'].'("'.$date.'")';

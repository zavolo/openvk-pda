<?php
session_start();
$dir = '.'.$_SESSION['ava'];
unlink($dir);
if(isset($_SESSION['uava']))
{
$dir1 = '.'.$_SESSION['uava'];
unlink($dir1);
}
$_SESSION = array();
session_destroy();
header("Location: /");
die();
?>
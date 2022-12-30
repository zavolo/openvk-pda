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
header("Location: index.php");
exit;
session_destroy();
?>
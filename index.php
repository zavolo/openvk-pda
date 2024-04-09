<?php
//test
session_start();
$dir = $_SERVER["DOCUMENT_ROOT"]."/avatars";
if(!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
if(isset($_SESSION['access_token'])){
 header('Location: /profile.php');
 die();
}
if(isset($_POST['token'])) {
 $instance = $_POST['instance'];
 if(empty($instance)){
	 $instance = "openvk.su";
 }
 $login = $_POST['login'];
 $code = $_POST['code'];
 $password = $_POST['password'];
 $service_url = "https://$instance/token?username=$login&password=$password&code=$code&grant_type=password";
 $curl = curl_init($service_url);
 curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
 curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
 $curl_response = curl_exec($curl);
 curl_close($curl);
 $curl_json = json_decode($curl_response, true);
 if(empty($curl_json['access_token'])){
   die("Введите правильные данные авторизации!");
 } else {
  $_SESSION['access_token'] = $curl_json['access_token'];
  $_SESSION['instance'] = $instance;
  $access_token = $_SESSION['access_token'];
  $service_url = "https://$instance/method/Account.getProfileInfo?&access_token=$access_token";
  $curl = curl_init($service_url);
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $curl_response = curl_exec($curl);
  curl_close($curl);
  $curl_json = json_decode($curl_response, true);
  $_SESSION['id'] = $curl_json['response']['id'];
  header('Location: /profile.php');
  die();
 }
}
?>
<title>OpenVK PDA</title>
<meta charset="utf-8">
<table width="100%" border="0" cellspacing="0" cellpadding="4" bgcolor="#808080">
<tbody>
<tr>
<td nowrap="" width="40%">
<b>
<font color="#ffffff">OpenVK PDA</font>
</b>
</td>
</tr>
</tbody>
</table>
<center>
<p style="color: green;">Привет! Это неофициальная версия социальной сети OpenVK для старых устройств. Исходники можно скачать <a href="https://github.com/zavsc/openvk-pda">тут</a>.</p>
<table border="0" cellspacing="0" cellpadding="5">
<form action="index.php" method="post">
<tbody>
<tr>
<td><font color="#000" size="-1"><b>Ваш инстанс, оставьте поле пустым если хотите использовать openvk.su:</b></font></td>
<td><input type="text" name="instance" size="10"></td>
</tr>
<tr>
<td><font color="#000" size="-1"><b>Ваш логин:</b></font></td>
<td><input type="text" name="login" size="10"></td>
</tr>
<tr>
<td><font color="#000" size="-1"><b>Ваш код 2FA если есть:</b></font></td>
<td><input type="text" name="code" size="10"></td>
</tr>
<tr>
<td><font color="#00" size="-1"><b>Ваш пароль:</b></font></td>
<td><input size="10" type="password" name="password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="token" value="Войти"></td>
</tr>
</tbody>
</table>
</form>

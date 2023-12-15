<?php
ini_set('display_errors', 0);
date_default_timezone_set('Europe/Moscow');
session_start();
if(empty($_SESSION['access_token'])){
 header('Location: /');
 die();
}
$access_token = $_SESSION['access_token'];
$instance = $_SESSION['instance'];
?>
<title>OpenVK PDA</title>
<meta charset="utf-8">
<style>
.td {
  padding: 10px;
  padding-left: 20px;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="4" bgcolor="#808080">
<tbody>
<tr>
<td nowrap="" width="40%">
<b>
<font color="#ffffff">OpenVK PDA</font>
<font color="#ffffff"> | <a href="/profile.php">Профиль</a> <a href="/user.php">(чужой)</a> | <a href="/post.php">Запостить</a> | <a href="/logout.php">Выйти</a></font>
<font color="#ffffff" style="display: none;"><?php echo $access_token; ?></font> <!-- Токен пользователя -->
</b>
</td>
</tr>
</tbody>
</table>
<br>
<?php
if(isset($_POST['token'])) {
$owner_id = $_POST['owner_id'];
$message = $_POST['message'];
$service_url1 = "https://$instance/method/Wall.post?&access_token=$access_token&owner_id=$owner_id&message=$message";
$curl1 = curl_init($service_url1);
curl_setopt($curl1, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, 0);
$curl_response1 = curl_exec($curl1);
curl_close($curl1);
$curl_json1 = json_decode($curl_response1, true);
echo '
  <table border="1">
   <tr>
    <th>Ссылка</th>
    <th>Запись</th>
   </tr>
   <tr>
   <td><a href="http://'.$instance.'/wall'.$owner_id.'_'.$curl_json1['response']['post_id'].'">http://'.$instance.'/wall'.$owner_id.'_'.$curl_json1['response']['post_id'].'</a></td>
   <td>'.$message.'</td>
   </tr>
  </table>
';
}
?>
<form action="post.php" method="post">
ID... <input type="text" name="owner_id"><br>
Сообщение... <input type="text" name="message"><br>
<button type="submit" name="token">запостить</button>
</form>
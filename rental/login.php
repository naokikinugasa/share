<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

$error['login'] = 0;
if(!empty($_POST)){
	if($_POST['email'] && $_POST['password']){
		$result = $exhibit->login();
		if($result){
			$_SESSION['id'] = $result['id'];
			header('Location: mypage.php');
		}
	}
}	
require_once(__DIR__.'/head.php');
?>
<body>
<div class="container" style="background: #EEEEEE; border: solid white;">
	<div class="loginbox" style="margin-bottom: 100px;">
	<form  method="post" action="register.php">
		<input class="loginButton" type="submit" value="新規会員登録">
	</form>
	<form  method="post" action="">

		<input class="loginform" type="text" name="email" placeholder="メールアドレス" ><br>
		<input class="loginform" type="text" name="password" placeholder="パスワード" >
		<input id="save" type="checkbox" name="save" value="on" style="margin-left: 15%;
    margin-top: 3%;"><label for="save">保存する</label>
		<input class="loginButton" type="submit" value="login">
	</form>
	</div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
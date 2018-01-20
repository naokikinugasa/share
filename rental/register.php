<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit= new \MyAPP\Exhibit();

if(!empty($_POST)){
	if ($_POST['name'] == '') {
		$error['name'] = 'blank';
	}
	if ($_POST['nickname'] == '') {
		$error['nickname'] = 'blank';
	}
	if ($_POST['email'] == '') {
		$error['email'] = 'blank';
	}
	if ($_POST['password'] == '') {
		$error['password'] = 'blank';
	}
	if (empty($error)) {
		$exhibit->register();
		$result = $exhibit->login();
		$_SESSION['id'] = $result['id'];
		header('Location: /share/rental/template/thanksregister.php');
	}
}

require_once(__DIR__.'/head.php');
?>
<!--TODO:空欄メッセージ赤字に。空欄の時、すでに入力していたのを残す。確認画面作成-->
<div class="container" style="background: #EEEEEE;  border: solid white;">
	<div class="loginbox" style="margin-bottom: 100px;">
	<form  method="post" action="">
		<p style="padding-top: 20px;">名前</p>
		<input class="loginform" type="text" name="name" placeholder="非公開" >
		<?php if (isset($error['name'])) { if($error['name'] == 'blank'){?>
			<p>名前を入力してください</p><?php
		}}?><br>
		<p style="padding-top: 20px;">ニックネーム</p>
		<input class="loginform" type="text" name="nickname" placeholder="公開" ><?php if (isset($error['nickname'])) { if($error['nickname'] == 'blank'){?>
			<p>ニックネームを入力してください</p><?php
		}}?><br>
		<p>メールアドレス</p>
		<input class="loginform" type="text" name="email" placeholder="非公開" ><?php if (isset($error['email'])) { if($error['email'] == 'blank'){?>
			<p>メールアドレスを入力してください</p><?php
		}}?><br>
		<p>パスワード</p>
		<input class="loginform" type="text" name="password" placeholder="非公開　6文字以上" ><?php if (isset($error['password'])) { if($error['password'] == 'blank'){?>
			<p>パスワードを入力してください</p><?php
		}}?>
		<input class="loginButton" type="submit" value="登録">
	</form>
	
	</div>


</div>
<?php
require_once(__DIR__.'/footer.php');
?>
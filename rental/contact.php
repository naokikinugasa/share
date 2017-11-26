<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();
require_once(__DIR__.'/head.php');
?>

<div class="container" style="background: #EEEEEE; border: solid white;">
	<div class="contact" style="margin-bottom: 100px;">
	<h2>お問い合わせ</h2>
	<form role="form" action="mail.php" method="post" style="margin:10px;">
	<div class="form-group">
	<label for="exampleInputName1">お名前</label>
	<input type="text" class="form-control" id="exampleInputName1" name="name" required>
	<label for="exampleInputEmail1">メールアドレス</label>
	<input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
	<label for="exampleInputText1">お問い合わせ内容</label>
	<textarea class="form-control" rows="5" name="message" required></textarea>
	</div>
	<button style="width: 30%;height: 30px;"type="submit" value="SEND MESSAGE" class="btn btn-default">送信</button>
	</form>


	</div>
	<div style="clear: both;"></div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<?php


$user_id = $_SESSION['id'];
$userhead = $exhibit->getusrinfo2($user_id);
$readflag = 0;

//メッセージ判定
$msgs = $exhibit->getmsgTo($user_id);
foreach ($msgs as $msg) : 
    if (!($msg->checked == 1)) {
    	$readflag = 1;
    }
endforeach;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset = "utf-8">
  <meta name="viewport" content="width=device-width,initial=1.0">
  <title>web</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
</head>
<body>
	<div id="header">
		<div id="headerTop">
			<h1><a href="index.php"><img src="images/logo7.png" alt="" width="160px" height="60px"/></a></h1>

<!-- 検索機能
<form name="searchform4" id="searchform4" method="get" action="#">  
<input name="keywords4" id="keywords4" placeholder="検索" type="text" style="margin-left: 5%; margin-top: 1%; border: none;" />  
<input type="image" src="image/btn4.gif" alt="検索" name="searchBtn4" id="searchBtn4" />  
</form>
-->

<!--
<form method="POST" action="search.php">
<input type="text" id="usersearch" name="usersearch" placeholder="キーワードから探す" />
</form>
-->
			<div id="logregi">
				<?php if ($user_id  > 0) : ?>
					<a href="mypage.php" class="myButtonlogMypage">
					<img src="images/<?php if ($userhead['gazou'])  {
				    	echo $userhead['gazou'];
				    }else{
				    	echo "default.png";
				    }?>" style="border-radius: 30px;
				  height: 35px;
				  width: 35px;" />
					<p id="headmypagep">マイページ</p></a>
				<?php else : ?>
					<a href="login.php" class="myButtonlog">ログイン</a>
				<?php endif; ?>

				<?php if ($user_id  > 0) : ?>
					<a href="msg.php" class="myButtonlogMypage2">
					<?php if ($readflag == 1) : ?>
						<img src="images/mailnew.png" style="
					  height: 35px;
					  width: 35px;" />
					<?php else : ?>
						<img src="images/mail.png" style="
					  height: 35px;
					  width: 35px;" />
					<?php endif ; ?>
					<p id="headmypagep">メッセージ</p></a>
				<?php else : ?>
					<a href="register.php" class="myButtonr">新規会員登録</a>
				<?php endif; ?>
			</div>
		</div>
		<div id="headerNav">
			<ul>
				<li><a href="caElectronics.php">家電</a></li>
				<li><a href="caDaily.php">生活用品</a></li>
				<li><a href="caSports.php">スポーツ</a></li>
				<li><a href="caGadgets.php">ガジェット</a></li>
				<li><a href="caInstrument.php">楽器</a></li>
				<li><a href="caFashion.php">ファッション</a></li>
				<li><a href="caTool.php">工具</a></li>
				<li><a href="caOther.php">その他</a></li>
			</ul>
		</div>
	</div>
<?php
session_start();

ini_set('display_errors', 1);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/images');
define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');
require_once(__DIR__.'/ImgUpload.php');

$exhibit = new \MyAPP\Exhibit();
$imgUpload = new \MyApp\ImgUpload();

$categorys = array('家電','生活用品','スポーツ','ガジェット','楽器','ファッション','趣味','その他');


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
$image='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $image = $imgUpload->upload();
}


//IsLogin?
if (isset($_SESSION['id'])) {
	
}else {
	header('Location: login.php');
	exit();
}

require_once(__DIR__.'/head.php');
?>
<body>

<div class="container" style="background: #EEEEEE; border: solid white; padding-bottom: 50px;">
	<div class="loginbox">
	<p style="padding-top: 30px;">写真</p>
	<?php if($image !== ''){?>
		<img src="<?= $image;?>" width="100%"><?php
	}?>
		<form action="exhit.php" method="POST" enctype="multipart/form-data" class="file">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php h(MAX_FILE_SIZE); ?>">
		<input type="file" name="image">
		<input type="submit" value="upload">←ファイルを選択後このボタンを押してください
		</form>
	<form method="post" action="products.php">
		<p>商品名</p>
		<input class="loginform" type="text" name="title" placeholder="例) プロジェクター" ><br>
		<p>商品説明</p>
		<textarea style="height: initial;" class="loginform" rows="5" name="honbun" placeholder="例)　1万円で購入したプロジェクターです。映画鑑賞やプロジェクションマッピングにおすすめです。詳細はこちらをご覧ください。https://www.amazon.co.jp(Amazonページ)"></textarea>
		<p>カテゴリー</p>
		<select name="category" class="loginform">
		<?php foreach ($categorys as $category) :?>
		<option value="<?= $category;?>"><?= $category;?></option>
		<?php endforeach; ?>
		</select>
		<p>受け渡し場所</p>
		<input class="loginform" type="text" name="place" placeholder="例) 天３のセブン" >
		<p>レンタル日数</p>
		<input class="loginform" type="text" name="days" placeholder="例) １日～3日" >
		<p>価格</p>
		<textarea style="height: initial;" class="loginform" rows="3" name="price" placeholder="例)　300円/日　
　　500円/3日　
　　1000円/週"></textarea>
		<?php $image2 = mb_substr($image,7); ?>
		<input type="hidden" name="gazou" value="<?= $image2;?>">
		</select>
		
		<?php if(isset($error['login']) && $error['login'] == 'blank'){?>
			<p>入力してください</p><?php
		}?>
		<?php if(isset($error['login']) && $error['login'] == 'failed'){?>
			<p>失敗</p><?php
		}?>
		<input class="myButtonlog2" type="submit" name="write" value="出品" style="height: 40px;">
	</form>
	<p>*出品上の注意</p>
<!--        TODO:お問い合わせリンクに下線つける-->
        <p>ゲーム・漫画・DVD等は著作権に違反するため出品できません。これは出品しても大丈夫なのだろうかと疑問に思うものがあれば、<a href="contact.php">お問い合わせページ</a>よりお気軽にご質問ください。</p><br>
	</div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
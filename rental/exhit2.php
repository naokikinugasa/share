<?php
session_start();

ini_set('display_errors', 1);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/images');
define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit= new \MyAPP\Exhibit();

$categorys = array('家電','工具','服');


if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
$image='';
$_FILES['image']['tmp_name'] = $_FILES['image']['tmp_name'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $image = $exhibit->upload();
  echo "string";
}

require_once(__DIR__.'/head.php');
?>
<body>

<div class="container" style="background: #EEEEEE; height: 1000px; border: solid white;">
	<div class="loginbox">
	<p>写真</p>
	<?php if($image !== ''){?>
		<img src="<?= $image;?>" width="100%"><?php
	}?>
		<form action="exhit.php" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php h(MAX_FILE_SIZE); ?>">
		<input type="file" name="image">
		<input type="submit" value="upload">
		</form>
	<form method="post" action="products.php">
		<p>商品名：<?=$_POST['title']; ?></p>
		<input class="loginform" type="text" name="title" placeholder="例) ルンバ" ><br>
		<p>商品説明</p>
		<input class="loginform" type="text" name="honbun" placeholder="6文字以上">
		<p>カテゴリー</p>
		<select name="category" class="loginform">
		<?php foreach ($categorys as $category) :?>
		<option value="<?= $category;?>"><?= $category;?></option>
		<?php endforeach; ?>
		</select>
		<p>受け渡し場所</p>
		<input class="loginform" type="text" name="honbun" placeholder="例) 天３のセブン" >
		<p>レンタル日数</p>
		<input class="loginform" type="text" name="honbun" placeholder="例) １日～3日" >
		<p>価格</p>
		<input class="loginform" type="text" name="honbun" placeholder="例) 300円" >
		<?php $image2 = mb_substr($image,7); ?>
		<input type="hidden" name="gazou" value="<?= $image2;?>">
		</select>
		
		<?php if($error['login'] == 'blank'){?>
			<p>入力してください</p><?php
		}?>
		<?php if($error['login'] == 'failed'){?>
			<p>失敗</p><?php
		}?>
		<input class="myButtonlog2" type="submit" name="write" value="出品">
	</form>
	</div>
</div>
</body>
</html>
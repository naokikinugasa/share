<?php
session_start();

ini_set('display_errors', 1);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); // 1MB
define('THUMBNAIL_WIDTH', 400);
define('IMAGES_DIR', __DIR__ . '/images');
define('THUMBNAIL_DIR', __DIR__ . '/thumbs');

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

if (!function_exists('imagecreatetruecolor')) {
  echo 'GD not installed';
  exit;
}

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

require_once(__DIR__.'/head.php');
?>
<body>

<div class="container" style="background: #EEEEEE; height: 1000px; border: solid white;">
	<div class="loginbox">
	<p>写真</p>
		<img src="/share/rental/images/<?= $_POST['gazou'];?>" width="100%">
	<form method="post" action="products.php">
		<p>商品名：<?= $_POST['title']; ?></p>
		<input class="loginform" type="hidden" name="title" value="<?=$_POST['title']; ?>" ><br>
		<p>商品説明：<?= $_POST['honbun']; ?></p>
		<input type="hidden" name="honbun" value="<?= $_POST['honbun']; ?>">
		<p>カテゴリー：<?= $_POST['category']; ?></p>
        <input type="hidden" name="category" value="<?= $_POST['category']; ?>">
		<p>受け渡し場所：<?= $_POST['place']; ?></p>
		<input type="hidden" name="place" value="<?= $_POST['place']; ?>" >
		<p>レンタル日数：<?= $_POST['days']; ?></p>
		<input type="hidden" name="days" value="<?= $_POST['days']; ?>" >
		<p>価格：<?= $_POST['price']; ?></p>
		<input type="hidden" name="price" value="<?= $_POST['price']; ?>" >
		<input type="hidden" name="gazou" value="<?= $image2;?>">
		<input class="myButtonlog2" type="submit" name="write" value="出品">
	</form>
	</div>
</div>
</body>
</html>
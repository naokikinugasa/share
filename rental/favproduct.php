<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

$id = $_SESSION['id'];
$usrs = $exhibit->getusrinfo($id);

//page
$page = $_REQUEST['page'];
if($page == ''){
	$page = 1;
}
$page = max($page,1);
$start = ($page - 1) * 16;

$products = $exhibit->getAllex($id);
$favs = $exhibit->getAllfav($id);

$msgs = $exhibit->getmsgselfalllimit($id);

require_once(__DIR__.'/head.php');
?>
<div id="container">
<div id="mypage">
<!-- いいね一覧　-->
<div class="mypage3">
<h3>いいねしている商品</h3>
	<ul>
	<?php foreach ($favs as $fav) : ?>
		<div class="topNaviColumn2">
        <div class="topNaviPhoto2"><img src="runba2.jpg" alt="" /></div>
        <p class="topNaviDetail2"><a href="template.php?id=<?= ($product->id); ?>"><?= ($fav->number); ?></a></p>
		</div><!-- /.topNaviColumn -->
		<!--
		<li>
		<a href="<?= $product->title ?>.php">
		<?= ($product->title); ?>
		</a>
		</li>
		-->
	<?php endforeach; ?>
	</ul>
<ul class="paging">
<?php
if($page > 1){?>
<li><a href="products.php?page=<?php print($page - 1); ?>">前のページ</a></li><?php
}else{

	}?>
<li><a href="products.php?page=<?php print($page + 1); ?>">次のページ</a></li>
</ul>
</div>


</div>

</div>
</body>
</html>
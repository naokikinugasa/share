<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

$id = $_SESSION['id'];
$usr = $exhibit->getusrinfo($id);

$products = $exhibit->getAllex($id);

require_once(__DIR__.'/head.php');
?>

<div class="container" style="background: #EEEEEE; border: solid white;">
	<div id="mypage" style="margin-bottom: 100px;">
	<h3 style="padding:3%;text-align: center;">マイページ</h3>
	<ul>
	    <div style="width:100px;height:100px;margin-left: auto;
	  margin-right: auto;">
	    <img src="images/<?php if ($usr['gazou'])  {
	    	echo ($usr['gazou']);
	    }else{
	    	echo "default.png";
	    }?>" style="border-radius: 50px;
	  height: 100px;
	  width: 100%;" />
	  	</div>
	    <li>名前:<?= ($usr['name'])?></li>
	    <li>メールアドレス:<?= ($usr['email'])?></li>
        <a href="logout.php">ログアウト</a>
	<h3>出品している商品</h3>
	  <?php foreach ($products as $product) : ?>
	  	<a href="template.php?id=<?= ($product->id); ?>">
	    <div class="topNaviColumn2">
	        <div class="topNaviPhoto2"><img src="images/<?= ($product->gazou); ?>" alt="" /></div>
	        <p style="padding:0 5%;"class="topNaviDetail2">
	        <?= ($product->title); ?>
	        </p><br><p style="padding:0 5%;"><?= ($product->price); ?></p>
	    </div>
	    </a>
	  <?php endforeach; ?>
	</ul>
	<a class="myButtonlog2" href="exhit.php">出品する</a>


	</div>
	<div style="clear: both;"></div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
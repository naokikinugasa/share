<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();


if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

//page
if (isset($_GET['page'])) {
    if (preg_match('/^[1-9][0-9]*$/', $_GET['page']) ) {
        $page = (int)$_GET['page'];
    } else {
        $page = 1;
    }
} else {
    $page = 1;
}

$PRODUCTS_PER_PAGE = 24;
$offset = $PRODUCTS_PER_PAGE * ($page - 1);
$products = $exhibit->getAllPageCategory($offset,$PRODUCTS_PER_PAGE,$category);
$total = $exhibit->_db->query("select count(*) from products WHERE category = '$category'")->fetchColumn();
$totalPages = ceil($total / $PRODUCTS_PER_PAGE);

var_dump($total);
require_once(__DIR__.'/head.php');
?>

<div id="container">

<div id="product">
<!--    TODO-->
<h2><?= $category ?></h2>
	<ul>
	<?php foreach ($products as $product) : ?>
		<a href="template.php?id=<?= ($product->id); ?>">
		<div class="topNaviColumn2">
        <div class="topNaviPhoto2"><img src="images/<?= ($product->gazou); ?>" alt="" /></div>
        <p style="padding:0 5%;"class="topNaviDetail2">
        <?= ($product->title); ?>
        </p><br><p class="topNaviDetailPrice"><?= ($product->price); ?></p>
		</div><!-- /.topNaviColumn -->
		</a>
	<?php endforeach; ?>
	</ul>

<div class="pager">
	<ul>
        <?php if ($page > 1) : ?>
            <li><a href="?category=<?= $category ?>&page=<?php echo $page-1; ?>"><</a></li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <?php if ($page == $i) : ?>
                <li><strong><a href="?category=<?= $category ?>&page=<?php echo $i; ?>" style="background: red; color:white;"><?php echo $i; ?></a></strong></li>
            <?php else: ?>
                <li><a href="?category=<?= $category ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $totalPages) : ?>
            <li><a href="?category=<?= $category ?>&page=<?php echo $page+1; ?>">></a></li>
        <?php endif; ?>
	</ul>
</div>
</div>

</div>
<?php
require_once(__DIR__.'/footer.php');
?>
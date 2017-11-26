<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

require_once(__DIR__.'/head.php');
?>

<div id="container">

<div id="cha" style="padding-top: 40px;">
<div style="
width: 80%;
margin-left: auto;
margin-right: auto;
font-size: 20px;
font-weight: bold;
padding: 10px;
text-align: center;">
<p>会員登録が完了しました。</p><br>
<a style="width:40%;margin:10px 30%;"class="myButtonlog3" href="howto.php">使い方</a>
<a style="width:40%;margin:10px 30%;"class="myButtonlog3" href="products.php">商品を見る</a>
<a style="width:40%;margin:10px 30%;"class="myButtonlog3" href="exhit.php">出品する</a>
</div>
</div>
</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>
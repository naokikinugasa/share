<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit= new \MyAPP\Exhibit();

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
<p>現在サービステスト中で、つくば市限定でサービスを展開しています。</p><br>
<p>そのため、今だけ出品料・登録料すべて無料です。</p><br>
<p>機能に関しましては今後随時追加していきます。</p>
</div>
</div>
</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>
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
<p>お問い合わせありがとうございます。</p><br>
<p>内容を確認後、入力いただいたメールアドレスに返信させていただきます。</p>
</div>
</div>
</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>
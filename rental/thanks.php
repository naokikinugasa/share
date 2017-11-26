<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

//予約
  if($_POST['confirm2']){
  	$rnum = $_POST['rnum'];
  	$title = $_POST['title'];
    //配列作成
    $two = decbin($rnum);
    $two = sprintf('%030s',$two);
    $days = array();
    for ($j=0; $j <30 ; $j++) { 
      $get = substr($two, $j,1);
      array_push($days, $get);
    }
    /*
    $days = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,);*/
    $day = $_POST["day"];
    for ($i=0; $i < count($day); $i++) { 
      $days2 = array_splice($days,$day[$i]-1,1,1);
    }
    $two = 0;
    for ($i=0; $i < 30; $i++) {
      $get = array_shift($days);
      $two.= $get;
    }
    $ten = bindec($two);
    $rnum = $ten;
    $exhibit->insertrnum($ten,$title);
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
<p>レンタルが確定しました。</p><br>
<p>レンタル予定日に受け渡し場所へ行き、商品を受け取りましょう。</p>
</div>
</div>
</div><!-- /container -->

<?php
require_once(__DIR__.'/footer.php');
?>
<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['id'])) {
    header("Location: register.php");
    exit();
}

 $id = $_GET['id'];
 $pro = $exhibit->getproduct($id);
 $fav = 0;

  //出品者のリンクを取るためだけ
  $exhn = $pro['exhn'];
  $userinfo = $exhibit->getusrinfo($exhn);


if (isset($_POST['confirm2'])) {
    foreach ($_POST['day'] as $reservedDay) :
    $exhibit->reserve($id,$reservedDay);
    endforeach;
    header("Location: /share/rental/template/thanks.php");
    exit();
}

require_once(__DIR__.'/head.php');
 ?>

<?php if(isset($_POST['confirm'])){?>
<div id="container">
<div id="product">
<div class="topNaviColumn3">
        <div class="topNaviPhoto3"><img src="images/<?= $pro['gazou'] ?>" alt="" /></div>
        <h3 class="name"><?= $pro['title'] ?></h3>
        <h3 class="name"><?php echo $pro['price'];?></h3>
        <div class="syouhinsetumei">商品説明</div>
        <p style="padding: 20px; word-wrap:break-word;"><?php echo $pro['honbun'];?></p>
</div><!-- /.topNaviColumn -->
<div class="syouhinsetumei">詳細</div>
<table class="sample_03">
    <tbody>
        <tr>
            <th>カテゴリー</th>
            <td><?php echo $pro['category'];?></td>
        </tr>
        <tr>
            <th>受け渡し場所</th>
            <td><?php echo $pro['place'];?></td>
        </tr>
        <tr>
            <th>レンタル日数</th>
            <td><?php echo $pro['days'];?></td>
        </tr>
        <tr>
            <th>価格</th>
            <td><?php echo $pro['price'];?></td>
        </tr>
        <tr>
            <th>出品者</th>
            <td><a href="mypage2.php?id=<?= ($userinfo['id']); ?>"><?= ($userinfo['nickname']); ?></a></td>
        </tr>
    </tbody>
</table>

    <table class="calConfirm">
        <form action='' method='POST'>
        <p>予約日は<?php
            foreach ($_POST['day'] as $reservedDay):
            echo $reservedDay;?>
                <input type="hidden" name="day[]" value="<?= $reservedDay; ?>">
                <?php
            endforeach;
            ?></p>
    <input type='submit' name='confirm2' value='確定する' class="myButtonConfirm" >
   
  </form>
  </table>
  <div id="yohaku">yohaku</div>
    <?php

  }?>


</div>





</div>
 
 
<?php
require_once(__DIR__.'/footer.php');
?>
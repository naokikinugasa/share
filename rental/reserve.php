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

if (isset($_POST['confirm2'])) {
    foreach ($_POST['day'] as $reservedDay) :
    $exhibit->reserve($_GET['id'], $reservedDay, $_SESSION['id']);
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
        <div class="topNaviPhoto3"><img src="images/<?= $_POST['gazou'] ?>" alt="" /></div>
        <h3 class="name"><?= $_POST['title'] ?></h3>
        <h3 class="name"><?php echo $_POST['price'];?></h3>
        <div class="syouhinsetumei">商品説明</div>
        <p style="padding: 20px; word-wrap:break-word;"><?php echo $_POST['honbun'];?></p>
</div><!-- /.topNaviColumn -->
<div class="syouhinsetumei">詳細</div>
<table class="sample_03">
    <tbody>
        <tr>
            <th>カテゴリー</th>
            <td><?php echo $_POST['category'];?></td>
        </tr>
        <tr>
            <th>受け渡し場所</th>
            <td><?php echo $_POST['place'];?></td>
        </tr>
        <tr>
            <th>レンタル日数</th>
            <td><?php echo $_POST['days'];?></td>
        </tr>
        <tr>
            <th>価格</th>
            <td><?php echo $_POST['price'];?></td>
        </tr>
        <tr>
            <th>出品者</th>
            <td><a href="mypage2.php?id=<?= ($_POST['userID']); ?>"><?= ($_POST['name']); ?></a></td>
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
<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

 $id = $_GET['id'];
 $pro = $exhibit->getproduct($id);
 $title = $pro['title'];
 $img = $pro['gazou'];
 $fav = 0;

 //DB++
 if (isset($_POST['good'])) {
  $goods = $_POST['good'];
 }
 if (isset($_POST['remove'])) {
  $remove = $_POST['remove'];
 }
 if (isset($pro['fav'])) {
  $fav = $pro['fav'];
 }
 if (isset($_SESSION['id'])) {
  $favn = $_SESSION['id'];
 }
 if(isset($goods)&& $goods== 'good') {
    $exhibit->plusfav($fav,$title);
    $pro = $exhibit->getproduct($id);
    $fav = $pro['fav'];
    $exhibit->insertfav($id,$favn);
 }
 if(isset($remove)&&$remove == 'remove'){
    $exhibit->minusfav($fav,$title);
    $pro = $exhibit->getproduct($id);
    $fav = $pro['fav'];
    $exhibit->deletefav($id,$favn);
 }
  //user
  $exhn = $pro['exhn'];
  $rnum = $pro['rnum'];
  $userinfo = $exhibit->getusrinfo($exhn);
  //message
  if (isset($_SESSION['id'])) {
    $fromn=$_SESSION['id'];
  }

  $day = array();
  $days = array();
  $two = 0;
  $ten = 0;


  //予約
/**
 * @param $rnum
 * @param $exhibit
 * @param $title
 * @return float|int
 */

if (isset($_POST['confirm2'])) {
    var_dump($_POST['day']);
    var_dump($id);
    $reservedDays = $_POST['day'];
    foreach ($reservedDays as $reservedDay) :
    $exhibit->reserve($id,$reservedDay);
    endforeach;
}

//message
  if(isset($_POST['res2'])){
    $exhibit->insertmsg($exhn,$id);
  }
  //返信
  if(isset($_POST['res'])){
    if (isset($_POST['fromn'])) {
      $fromn = $_POST['fromn'];
    }
    $exhibit->insertmsg($fromn,$id);
  }
  if (isset($fromn)) {
    $msgs = $exhibit->getmsg($exhn,$fromn,$id);
  }
  /*$msgspro = $exhibit->getmsgpro($exhn,$fromn,$id);*/

require_once(__DIR__.'/head.php');
 ?>


<div id="container">
<div id="product">
<div class="topNaviColumn3">
        <div class="topNaviPhoto3"><img src="images/<?= $img ?>" alt="" /></div>
        <h3 class="name"><?= $title ?></h3>
        <h3 class="name"><?php echo $pro['price'];?></h3>
        <!--いいね-->
        <form action="" method="post">
         <?php
           $favexist = $exhibit->getfavexist($id,$favn);
           if(!$favexist){?>
              <input type="hidden" name="good" value="good">
              <input class="favButton" type="submit" value="♡いいね <?php echo $fav; ?>"><?php
           }else{?>
              <input type="hidden" name="remove" value="remove">
              <input class="favButton" type="submit" value="♡いいね <?php echo $fav; ?>"><?php
           }?>
        </form>
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

      <div class="syouhinsetumei">レンタル可能日</div>
      <table class="cal">
    <thead>
      <tr>
        <th><a href="template.php?id=<?php echo $id ?>&t=<?php echo h($exhibit->prev); ?>">&laquo;</a></th>
        <th colspan="5"><?php echo h($exhibit->yearMonth); ?></th>
        <th><a href="template.php?id=<?php echo $id ?>&t=<?php echo h($exhibit->next); ?>">&raquo;</a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Sun</td>
        <td>Mon</td>
        <td>Tue</td>
        <td>Wed</td>
        <td>Thu</td>
        <td>Fri</td>
        <td>Sat</td>
      </tr>
      <form action='reserve.php?id=<?php echo $id ?>' method="POST">
          <?php $exhibit->show($id); ?>
          <input type="hidden" name="confirm" value="confirm">
          <input class="myButton" type="submit" value="レンタルする">
      </form>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="7" style="color: white">Today</th>
      </tr>
    </tfoot>
  </table>
<!--メッセージ-->


<?php
if($exhn==$_SESSION['id']){
  $msgs = $exhibit->getmsgself($exhn,$id);

  if(isset($_POST['fromn'])){
    $fromn=$_POST['fromn'];
    $msgs = $exhibit->getmsg($exhn,$fromn,$id);
    ?>
    <div class="syouhinsetumei">メッセージ</div>
    <div class="chat-box">
  <?php 
     foreach ($msgs as $msg) : ?>
     
      <div class="chat-area">
          <!-- チャット画像取得-->
          <?php 
          $user = $exhibit->getusrinfo($msg->fromn);
          ?>
          <img src="images/<?php if ($user['gazou'])  {
              echo $user['gazou'];
            }else{
              echo "default.png";
            }?>" style="border-radius: 20px;
  height: 40px;
  width: 40px;
  margin-left: 5%;" />
          <div class="chat-hukidashi">
            <p>
            <?= ($msg->content); ?>
            </p>
          </div>
      </div>
      <?php if(($msg->ton)==$_SESSION['id']){
        $exhibit->msgCheck($msg->id); 
       }?>
    <?php endforeach; 
  ?>
  </div>  
  <div class="me">
    <p>メッセージを送る</p>
    <form action="" method="post">
     <input type="hidden" name="res" value="res">
     <input type="hidden" name="fromn" value="<?= $fromn; ?>">
     <textarea class="text" name="content" cols="50" rows="4" placeholder="出品者へメッセージを送る"></textarea><br>
     <input class="bu" type="submit" value="送信">
    </form>
    </div>
  <?php
  }
}else{
?>
  <div class="syouhinsetumei">メッセージ</div>
  <div class="chat-box">
  <?php $msgs = $exhibit->getmsg($exhn,$fromn,$id);
    if($msgs){
     foreach ($msgs as $msg) : ?>
    <div class="chat-area">
        <!-- チャット画像取得-->
        <?php 
        $user = $exhibit->getusrinfo($msg->fromn);
        ?>
        <img src="images/<?php if ($user['gazou'])  {
              echo $user['gazou'];
            }else{
              echo "default.png";
            }?>" style="border-radius: 20px;
  height: 40px;
  width: 40px;
  margin-left: 5%;" />
        <div class="chat-hukidashi">
          <p>
          <?= ($msg->content); ?>
          </p>
        </div>
    </div>
    <?php if(($msg->ton)==$_SESSION['id']){
        $exhibit->msgCheck($msg->id); 
       }?>
    <?php endforeach; 
  }?>
  </div>
  <div class="me">
    <p>出品者へメッセージを送る</p>
    <form action="" method="post">
     <input type="hidden" name="res2" value="res2">
     <textarea class="text" name="content" cols="50" rows="5"></textarea><br>
     <input class="bu" type="submit" value="送信">
    </form>
  </div>
<?php
}?>


</div>





</div>
 
 
<?php
require_once(__DIR__.'/footer.php');
?>
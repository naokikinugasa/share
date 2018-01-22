<?php
session_start();

require_once(__DIR__ . '/config.php');
require_once(__DIR__.'/Exhibit.php');

$exhibit = new \MyAPP\Exhibit();

$error['login'] = 0;
if(!empty($_POST)){
	if($_POST['name'] && $_POST['password']){
		$result = $exhibit->login();
		if($result){
			$_SESSION['id'] = $result['id'];
			echo $_SESSION['id'];
			header('Location: mypage.php');
			exit();
		}
	}
}	
require_once(__DIR__.'/head.php');
?>

<div class="container" style="background: #EEEEEE; border: solid white;">
	<div class="msglistbox" style="margin-bottom: 100px;">
	<p style="text-align: center;font-size: 25px;font-weight: bold;padding:5%;">メッセージ</p>
	<?php 
		$msgs = $exhibit->getmsgTo3($user_id);
		foreach ($msgs as $msg) : 
			$user = $exhibit->getusrinfo($msg->fromn);
			$product = $exhibit->getproduct($msg->number); ?>
			<form action='template.php?id=<?= ($msg->number); ?>' method='POST'>
			<div class="<?php if(($msg->checked) == 1) : ?>
				msglist2
	        <?php else : ?>
	        	msglist
	        <?php endif ; ?>"style="border-top: solid #eee 1px;height: 70px;width: 100%;position: relative;cursor: pointer;">
	        <p style="margin: 0;padding:5% 20% 5% 7%;height: 45%;"><?= $product['title']; ?>について<?= $user['name']; ?>さんからメッセージがあります<?= ($msg->id); ?></p>
	        
	        <img class="msglist" src="images/migiyazirusi.png" style="width: 5%;height: 20%;position: absolute;right: 5%;top: 40%;">
	        
	        <input type="hidden" name="toNumber" value="<?= $user['id']; ?>">
	        <input class="msglist" style="border: solid;width: 100%;height: 100%;position: absolute;top: 0;opacity: 0;" type="submit" value="メッセージを見る">
	    
	        
	        </div>
	        
	        </form>
	        <?php
	    endforeach;?>
	      
	
	</div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
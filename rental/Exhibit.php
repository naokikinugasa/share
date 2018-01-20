<?php
namespace MyApp;




class Exhibit{
  public $_db;
  private $_imageFileName;

	public function __construct(){
		try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }



    /*
          商品を取得
                  */

  	//商品情報を取得
  	public function getproduct($id){
      $stmt = $this->_db->query("select * from products WHERE id='$id'");
      $pro = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $pro;
    }
    //商品一覧を取得(ページ)
    public function getAllPage($offset,$PRODUCTS_PER_PAGE){
      $stmt = $this->_db->query("select *from products order by id desc limit $offset,$PRODUCTS_PER_PAGE");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //商品一覧をカテゴリー別に取得
    public function getAllca($category){
      $stmt = $this->_db->query("select *from products where category='$category' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //出品一覧を取得
    public function getAllex($id){
      $stmt = $this->_db->query("select *from products where exhn='$id' order by id desc ");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //いいねした商品を取得
    public function getAllfav($id){
      $stmt = $this->_db->query("select *from fav where favn='$id' order by id desc ");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }






    /*
        いいね
                */
    public function plusfav($fav,$title){
      $fav++;
      $this->_db->exec("update products set fav=$fav WHERE title='$title' ");
    }
    public function minusfav($fav,$title){
      $fav--;
      $this->_db->exec("update products set fav=$fav WHERE title='$title' ");
    }
    public function insertfav($number,$favn){
    $number = $number;
    $favn = $favn;
    $this->_db->exec("insert into fav (number,favn) values ('$number','$favn')");
    }
    public function deletefav($number,$favn){
    $number = $number;
    $favn = $favn;
    $this->_db->exec("delete from fav where number='$number' AND favn='$favn'");
    }
    
    public function getfavexist($number,$favn){
    $number = $number;
    $favn = $favn;
    $stmt = $this->_db->query("select *from fav WHERE number='$number' AND favn='$favn' ");
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

	//出品商品をDBに追加
	public function insertdb(){
		$title = $_POST['title'];
    $honbun = $_POST['honbun'];
		$exhn = $_SESSION['id'];
    $gazou = $_POST['gazou'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $place = $_POST['place'];
    $days = $_POST['days'];
		$this->_db->exec("insert into products (title,honbun,exhn,gazou,category,price,place,days) values ('$title','$honbun','$exhn','$gazou','$category','$price','$place','$days')");
	}

  public function register(){
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $this->_db->exec("insert into members (name,nickname,email,password) values ('$name','$nickname','$email','$password')");
    }

  public function login(){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $this->_db->query("select *from members WHERE email='$email' AND password='$password' ");
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

  public function insertmsg($exhn,$id){
    $content = $_POST['content'];
    $fromn = $_SESSION['id'];
    $exhn = $exhn;
    $number=$id;
    $this->_db->exec("insert into msg (content,fromn,ton,number) values ('$content','$fromn','$exhn','$number')");
  }
  
  
  public function getmsg($ton,$fromn,$number){
      $ton=$ton;
      $fromn=$fromn;
      $number=$number;
      $stmt = $this->_db->query("select * from msg WHERE (ton='$ton' OR ton='$fromn') and (fromn='$fromn' OR fromn='$ton') and number='$number' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgself($ton,$number){
      $ton=$ton;
      $number=$number;
      $stmt = $this->_db->query("select * from msg WHERE ton='$ton' and number='$number' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgTo($user_id){
      $ton=$user_id;
      $stmt = $this->_db->query("select * from msg as a WHERE ton='$ton' and id=(select MAX(id) from msg as b WHERE a.fromn=b.fromn and a.number=b.number) order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgTo3($user_id){
      $ton=$user_id;
      $stmt = $this->_db->query("select * from msg  WHERE ton='$ton' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgselfalllimit($id){
      $ton=$id;
      $stmt = $this->_db->query("select max(id),fromn,number,content from msg WHERE ton='$ton' GROUP BY number,fromn order by id desc LIMIT 5");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgpro($ton,$fromn,$number){
      $ton=$ton;
      $fromn=$fromn;
      $number=$number;
      $stmt = $this->_db->query("select * from msg,members WHERE (msg.ton='$ton' OR msg.ton='$fromn') and (msg.fromn='$fromn' OR msg.fromn='$ton') and msg.number='$number' and (msg.ton=members.id OR msg.fromn=members.id) order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }


  public function getusrinfo($id){
      $id = $id;
      $stmt = $this->_db->query("select * from members WHERE id='$id'");
      $pro = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $pro;
    }
  //既読チェック
  public function msgCheck($id){
      $id=$id;
      $this->_db->exec("update msg set checked=1 WHERE id='$id' ");
    }













  public function reserve($id, $reservedDay) {
      $this->_db->exec("insert into reservations (productID,date) VALUES ('$id','$reservedDay')");
  }
  public function getReservations($id){
      $stmt = $this->_db->query("select date from reservations WHERE productid='$id'");
      return $stmt->fetchALL(\PDO::FETCH_COLUMN);
  }









  //検索
  public function search($search){
      $search=$search;
      $stmt = $this->_db->query("select *from products where title LIKE '%$search%'");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }








  //画像アップ
    public function upload() {
    try {
      // error check
      $this->_validateUpload();

      // type check
      $ext = $this->_validateImageType();
      // var_dump($ext);
      // exit;

      // save
      $savePath = $this->_save($ext);
      return $savePath;


    } catch (\Exception $e) {
      echo $e->getMessage();
      exit;
    }
    // redirect
  }


  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    $savePath =  'images/' . $this->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('Could not upload!');
    }
    return $savePath;
  }

  private function _validateImageType() {
    $imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($imageType) {
      case IMAGETYPE_GIF:
        return 'gif';
      case IMAGETYPE_JPEG:
        return 'jpg';
      case IMAGETYPE_PNG:
        return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF only!');
    }
  }

  private function _validateUpload() {
    // var_dump($_FILES);
    // exit;

    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('Upload Error!');
    }

    switch($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('File too large!');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }

  }


}
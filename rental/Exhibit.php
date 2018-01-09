<?php
namespace MyApp;




class Exhibit{
  public $_db;

  //calendar
  public $prev;
  public $next;
  public $yearMonth;
  private $_thisMonth;

  private $_imageFileName;


	public function __construct(){
		try {
      $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
      $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
    //calendarコンストラクト
    try {
      if (!isset($_GET['t']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['t'])) {
        throw new \Exception();
      }
      $this->_thisMonth = new \DateTime($_GET['t']);
    } catch (\Exception $e) {
      $this->_thisMonth = new \DateTime('first day of this month');
    }
    $this->prev = $this->_createPrevLink();
    $this->next = $this->_createNextLink();
    $this->yearMonth = $this->_thisMonth->format('F Y');
  }

  	//商品情報を取得
  	public function getproduct($id){
      $stmt = $this->_db->query("select * from products WHERE id='$id'");
      $pro = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $pro;
    }
  	//商品一覧を取得
    public function getAll(){
    	$stmt = $this->_db->query('select *from products order by id desc');
    	return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //商品一覧を取得(ページ)
    public function getAllPage($offset,$PRODUCTS_PER_PAGE){
      $offset = $offset;
      $PRODUCTS_PER_PAGE = $PRODUCTS_PER_PAGE;
      $stmt = $this->_db->query("select *from products order by id desc limit $offset,$PRODUCTS_PER_PAGE");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //商品一覧をカテゴリー別に取得
    public function getAllca($category){
      $category=$category;
      $stmt = $this->_db->query("select *from products where category='$category' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //出品一覧を取得
    public function getAllex($id){
      $id=$id;
      $stmt = $this->_db->query("select *from products where exhn='$id' order by id desc ");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
    //いいねした商品を取得
    public function getAllfav($id){
      $id=$id;
      $stmt = $this->_db->query("select *from fav where favn='$id' order by id desc ");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }

    public function plusfav($fav,$title){
      $title=$title;
      $fav++;
      $this->_db->exec("update products set fav=$fav WHERE title='$title' ");
    }
    public function minusfav($fav,$title){
      $title=$title;
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

    public function insertrnum($ten,$title){
    $rnum = $ten;
    $title = $title;
    $this->_db->exec("update products set rnum=$rnum where title='$title' ");
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
  public function getAllmsg(){
      $id=$_SESSION['id'];
      $stmt = $this->_db->query("select *from msg where ton=$id order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
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
  public function getmsgTo2($user_id,$fromn){
      $ton=$user_id;
      $fromn = $fromn;
      $stmt = $this->_db->query("select * from msg as c WHERE ton='$ton' and id=(select MAX(id) from msg as d WHERE c.number=d.number and fromn='$fromn') order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgTo3($user_id){
      $ton=$user_id;
      $stmt = $this->_db->query("select * from msg  WHERE ton='$ton' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgselfall($id){
      $ton=$id;
      $stmt = $this->_db->query("select max(id),fromn,number,content from msg WHERE ton='$ton' GROUP BY number,fromn order by id desc");
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

  public function getusr($id){
      $id = $id;
      $stmt = $this->_db->query("select * from fav where id='$id' ");
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
















  //calendar

  private function _createPrevLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('-1 month')->format('Y-m');
  }

  private function _createNextLink() {
    $dt = clone $this->_thisMonth;
    return $dt->modify('+1 month')->format('Y-m');
  }

  public function show($rnum) {
    $rnum = $rnum;
    $tail = $this->_getTail();
    $body = $this->_getBody($rnum);
    $head = $this->_getHead();
    $html = '<tr>' . $tail . $body . $head . '</tr>';
    echo $html;
  }

  private function _getTail() {
    $tail = '';
    $lastDayOfPrevMonth = new \DateTime('last day of ' . $this->yearMonth . ' -1 month');
    while ($lastDayOfPrevMonth->format('w') < 6) {
      $tail = sprintf('<td class="gray">%d</td>', $lastDayOfPrevMonth->format('d')) . $tail;
      $lastDayOfPrevMonth->sub(new \DateInterval('P1D'));
    }
    return $tail;
  }

  private function _getBody($rnum) {
    $rnum = $rnum;
    $body = '';
    $period = new \DatePeriod(
      new \DateTime('first day of ' . $this->yearMonth),
      new \DateInterval('P1D'),
      new \DateTime('first day of ' . $this->yearMonth . ' +1 month')
    );
    $today = new \DateTime('today');

    //配列作成
    $two = decbin($rnum);
    $two = sprintf('%030s',$two);
    $days = array();
    for ($j=0; $j <30 ; $j++) { 
      $get = substr($two, $j,1);
      array_push($days, $get);
    }
    
    $i = 0;
    foreach ($period as $day) {
      if ($day->format('w') === '0') { $body .= '</tr><tr>'; }
      $todayClass = ($day->format('Y-m-d') === $today->format('Y-m-d')) ? 'today' : '';
        if($days[$i] == 1){
          $color = 'red';
          $check = 'hidden';
        }else{
          $color = 'gray';
          $check = 'checkbox';
        }
        $i++;
      $body .= sprintf("<td class='$color'><input type='$check'  name='day[]' value='%d' >%d</td>", $day->format('d'), $day->format('d'));

      
    }
    return $body;
  }

  private function _getHead() {
    $head = '';
    $firstDayOfNextMonth = new \DateTime('first day of ' . $this->yearMonth . ' +1 month');
    while ($firstDayOfNextMonth->format('w') > 0) {
      $head .= sprintf('<td class="gray">%d</td>', $firstDayOfNextMonth->format('d'));
      $firstDayOfNextMonth->add(new \DateInterval('P1D'));
    }
    return $head;
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
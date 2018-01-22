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
    $this->_db->exec("insert into fav (number,favn) values ('$number','$favn')");
    }
    public function deletefav($number,$favn){
    $this->_db->exec("delete from fav where number='$number' AND favn='$favn'");
    }
    
    public function getfavexist($number,$favn){
    $stmt = $this->_db->query("select *from fav WHERE number='$number' AND favn='$favn' ");
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

	//出品商品をDBに追加
	public function insertdb($title, $honbun, $exhn, $gazou, $category, $price, $place, $days){
		$this->_db->exec("insert into products (title,honbun,exhn,gazou,category,price,place,days) values ('$title','$honbun','$exhn','$gazou','$category','$price','$place','$days')");
	}

  public function register($name, $email, $password){
    $this->_db->exec("insert into members (name,email,password) values ('$name','$email','$password')");
    }

  public function login($email, $password){
    $stmt = $this->_db->query("select *from members WHERE email='$email' AND password='$password' ");
    return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /*
        メッセージ
                */
  public function insertmsg($content, $fromn, $exhn, $id){
    $this->_db->exec("insert into msg (content,fromn,ton,number) values ('$content','$fromn','$exhn','$id')");
  }
  
  public function getmsg($ton,$fromn,$number){
      $stmt = $this->_db->query("select * from msg WHERE (ton='$ton' OR ton='$fromn') and (fromn='$fromn' OR fromn='$ton') and number='$number' order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }
  public function getmsgself($ton,$number){
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
      $stmt = $this->_db->query("select * from msg,members WHERE (msg.ton='$ton' OR msg.ton='$fromn') and (msg.fromn='$fromn' OR msg.fromn='$ton') and msg.number='$number' and (msg.ton=members.id OR msg.fromn=members.id) order by id desc");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }


  public function getusrinfo($id){
      $stmt = $this->_db->query("select * from members WHERE id='$id'");
      $pro = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $pro;
    }
  //既読チェック
  public function msgCheck($id){
      $this->_db->exec("update msg set checked=1 WHERE id='$id' ");
    }

    /*
            予約
                    */

  public function reserve($id, $reservedDay, $subscriberNumber) {
      $this->_db->exec("insert into reservations (productID, date, subscriberNumber) VALUES ('$id', '$reservedDay', '$subscriberNumber')");
  }
  public function getReservations($id){
      $stmt = $this->_db->query("select date from reservations WHERE productid='$id'");
      return $stmt->fetchALL(\PDO::FETCH_COLUMN);
  }



  //検索
  public function search($search){
      $stmt = $this->_db->query("select *from products where title LIKE '%$search%'");
      return $stmt->fetchALL(\PDO::FETCH_OBJ);
    }


}
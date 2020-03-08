<!DOCTYPE html> 
<html lang="ja"> 
  <head> 
    <meta charset="UTF-8"> 
    <title>mission_5-1</title> 
    <style> 
      form { 
        margin-bottom: 20px; 
      } 
    </style> 
  </head> 
  <body> 
 
 
 
<?php 
 
// 接続データベース情報 
 $dsn = 'データベース名'; 
 $user = 'ユーザー名'; 
 $password = 'パスワード'; 
 $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 
 
//データベース内にテーブルを作成する。 
 $sql = "CREATE TABLE IF NOT EXISTS tb" 
 ." (" 
 . "id INT AUTO_INCREMENT PRIMARY KEY," 
 . "name char(32)," 
 . "comment TEXT,"
 . "created time"
 .");"; 
 $stmt = $pdo->query($sql); 

//テーブル一覧を表示するコマンドを使って作成が出来たか確認する。 
  /*  	$sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";*/

 
 
      //投稿機能 
 
  //フォーム内が空でない場合に以下を実行する 
if(!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['password'])){ 
 
    //入力データの受け取りを変数に代入 
    $name = $_POST['name']; 
    $comment = $_POST['comment']; 

 
   $password = $_POST['password']; 
   if(!empty($_POST['editNo'])) { }else{
    // editNoがないときは新規投稿、ある場合は編集 ***ここで判断 
 
      // 以下、新規投稿機能 
//INSERT INTO テーブル名(カラム名1, カラム名2, カラム名3, ……) VALUES(データ1, データ2, データ3, ……); 
 $sql = $pdo ->  prepare("INSERT INTO tb (name, comment,created) VALUES (:name,:comment,:time)"); 
 $sql -> bindParam(':name', $name, PDO::PARAM_STR); 
 $sql -> bindParam(':comment', $comment, PDO::PARAM_STR); 
 $sql -> bindParam(':time' , $time, PDO::PARAM_STR);
 $time = date("Y-m-d H:i:s"); 
	$sql -> execute();
}
}



     //削除フォームの送信の有無で処理を分岐
if (!empty($_POST['dnum']) && !empty($_POST['password2'])) {

          //入力データの受け取りを変数に代入
          $delete = $_POST['dnum'];
          
          $password2 = $_POST['password2'];
        $id=$_POST['dnum'];
	$sql = 'delete from tb where id=:id';
// 削除するレコードのIDは空のまま、SQL実行の準備をする
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$res = $stmt->execute();

}




 if(!empty($_POST['editNo'])&& !empty($_POST['password'])) {

          //入力データの受け取りを変数に代入
        $editNo = $_POST['editNo'];
        $password = $_POST['password'];    
/*if(!empty($_POST['password3'])){*/
$id = $_POST['editNo'];
$name = $_POST["name"];
$comment = $_POST["comment"];
/*$pass=$_POST["pass"];*/
	$sql = 'update tb set name=:name,comment=:comment where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}





 

$sql = 'SELECT * FROM tb';  //テーブルデータ取得 
if(!empty($_POST['edit'])&& !empty($_POST['password3'])){
 $edit = $_POST['edit'];
$password3 =$_POST["password3"];
 $stmt = $pdo->query($sql); 
 $results = $stmt->fetchAll(); 
 foreach ($results as $row){ 
if($row['id']==$edit){
$editnumber = $row['id'];
$editname = $row['name'];
$editcomment = $row['comment'];
$time=$row['created'];
}
}
}
?>
 
     <form action="mission_5-1.php" method="post"> 
     【　投稿フォーム　】   パスワード：新規投稿でご自由に決めてください<br> 
      <input type="text" name="name" placeholder="名前" value="<?php if(isset($editname)) {echo $editname;} ?>"><br> 
      <input type="text" name="comment" placeholder="コメント" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"><br> 
      <input type = "hidden" name="editNo"   value="<?php if(isset($editnumber)) {echo $editnumber;} ?>"> 
      <input type="text" name="password"placeholder="パスワード"><br> 
      <input type="submit" name="submit" value="送信"> 
    </form> 
 
    <form action="mission_5-1.php" method="post"> 
     【　削除フォーム　】<br> 
      <input type="text" name="dnum" placeholder="削除対象番号"><br> 
      <input type="text" name="password2"placeholder="パスワード"><br> 
      <input type="submit" name="delete" value="削除"> 
    </form> 
 
    <form action="mission_5-1.php" method="post"> 
      【　編集フォーム　】<br> 
      <input type="text" name="edit" placeholder="編集対象番号"><br> 
       <input type="text" name="password3"placeholder="パスワード"><br> 
      <input type="submit" value="編集"> 
    </form> 

<?php
 $sql = 'SELECT * FROM tb';  //テーブルデータ取得 
 $stmt = $pdo->query($sql); 
 $results = $stmt->fetchAll(); 
 foreach ($results as $row){ 
 
  echo $row['id']; 
  echo $row['name']; 
  echo $row['comment']; 
  echo $row['created'].'<br>';

}
?>
 
  </body> 
</html>
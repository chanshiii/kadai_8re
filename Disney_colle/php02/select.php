<?php
// データベース接続、表示

//1.  DB接続します
include ("funcs.php");
$pdo= db_conn();

//２．データ登録SQL作成
$sql ="SELECT * FROM disney_colle;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

//全データ取得 データベースにアクセスしてSELECTを持ってくる？
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>データ登録表示画面</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/range.css">
<link rel="stylesheet" href="./css/style.css">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
<table>  
  <!-- $valuesに入れてあるものを1レコードずつ取ってきて、ある分表示する $vは任意で決めたもの -->
  <!-- valuesがデーターベース全てを指していて、ここで言うvが１つの配列を示し、データ分ループ処理をしている -->
<?php foreach($values as $v){ ?>
        <tr>
          <td><?=h($v["id"])?></td>
          <td><?=$v["year"]?></td> <!-- idには数字しか入ってこないのでhはいらない -->
          <td><?=$v["place"]?></td>
          <td><?=$v["category"]?></td> 
          <!-- insert.phpで受けっとってアップロードした画像を表示するにはここで、画像を保存したパスを指定する必要がある -->
          <td><p class="img_style"><img src="./img/<?=$v["img"]?>" alt=""></p></td>
          <td><?=$v["naiyou"]?></td>
          <td class=h_btn><a href="detail.php?id=<?=$v["id"]?>">編集</a></td>
          <td class=d_btn><a href="delete.php?id=<?=$v["id"]?>">削除</a></td>
        </tr>
<?php } ?>
</table>
    </div>
</div>
<!-- Main[End] -->


<script>
  //JSON受け取り
  const json = JSON.parse('<?=$json?>');
  console.log(json);


</script>
</body>
</html>

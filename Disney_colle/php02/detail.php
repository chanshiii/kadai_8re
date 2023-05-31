<?php

//1. GET送信したIDを取得
$id =$_GET["id"];
// echo $id; select.phpでGET送信したidを取得しているかの確認
// exit;

//2 funcs.phpを読み込む
include("funcs.php");
$pdo = db_conn();

//3．データ登録SQL作成
$sql ="SELECT * FROM disney_colle WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt ->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//4．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
// $values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);
$v = $stmt ->fetch(); //一人分の取り出し

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <script src="./js/jquery-2.1.3.min.js"></script>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php" enctype="multipart/form-data">
  <div class="jumbotron" style=padding:20px>
   <fieldset>
    <legend>非売品情報</legend>
     <label for="year">年代：</label>
     <select name="year" id="year">
      <option selected>選択してください。</option>
      <?php
      for($num=1980; $num<=2100; $num++){
        // もし$numが指定された年($v["year"])と一致する場合、$selectedに'selected'を代入する。一致しない場合は空文字列。
        $selected = ($num == $v["year"]) ? 'selected' : '';
        // オプション要素を生成し、値に$numを設定。$selectedを属性として追加する。
        // オプションのテキストには、$numと'年'を表示する。
        echo '<option value="' . $num . '" ' . $selected . '>' . $num . '年</option>';
      }
      ?>
     </select>
     <label for="place">入手場所：</label>
     <select name="place" id="place">
      <option selected>選択してください。</option>
      <?php
      $place = ['ランド','シー','イクスピアリ','リゾートライン','アンバサダーホテル','ミラコスタ','ランドホテル','トイストーリホテル','その他'];
      for($num=0; $num<count($place); $num++){
        $selected =($place[$num] == $v["place"]) ? 'selected' : ''; 
        //三項演算子:? と : $place[$num] の値が $v["place"] の値と等しい場合、$selected に 'selected' を代入し、選択されたオプションを示す。そうでない場合、$selected は空のままであり、選択されていないオプションを表します。
        echo '<option value="' . $place[$num] . '" ' .$selected . '>' .$place[$num] . '</option>';
        // echo '<option value=>'.$place[$num] . '</option>'; この書き方だと入力した値が空白になる
      }
      ?>
     </select>
     <!-- <p>パーク：</p>
     <label><input type="radio" name="park" id="land" value=1>ランド</label>
     <label><input type="radio" name="park" id="sea"  value=2>シー</label><br> -->
     <label for="category">カテゴリ：</label>
     <select name="category" id="category">
      <option selected>選択してください。</option>
      <?php
      $cate = ['チャーム','メダル','ピン','その他'];
      for($num=0; $num<count($cate); $num++){
        $selected = ($cate[$num] == $v["category"]) ? 'selected' : '';
        echo '<option value="' . $cate[$num] .'" ' . $selected . '>' .$cate[$num] . '</option>';
      }
      // 上記コードは内容を変更をする時に、現在入力されている情報を保持するためにコードを変更した。
      ?>
      </select><br>

     <label>画像：<input type="file" name="img" accept=".png, .jpg, .jpeg, .pdf, .doc"><p class="img_style"><img src="./img/<?=$v["img"]?>" alt="" width=200px></label><br>
     <label>メモ：<textArea name="naiyou" rows="4" cols="40"><?=$v["naiyou"]?></textArea></label><br>
     <input type="hidden" name="id" value="<?=$v["id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
<script>

$('input[type=file]').change(function(){
  var file = $(this).prop('files')[0];
  if(!file.type.match('image. *')){
    $(this).val('');
    $('.img_style > img').html('');
    return;
  }

var reader = new FileReader();
reader.onload = function(){
  $('.img_style > img').attr('src', reader.result);
}
reader.readAsDataURL(file);
});

</script>

</body>
</html>
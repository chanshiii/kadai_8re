<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Disney_not-for-sale data registration</title>
  <script src="./js/jquery-2.1.3.min.js"></script>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">Disney_not-for-sale data registration</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php" enctype="multipart/form-data">
  <div class="jumbotron" style=padding:20px>
   <fieldset>
    <legend>非売品情報</legend>
     <label for="year">年代：</label>
     <select name="year" id="year">
      <option selected>選択してください。</option>
      <?php
      for($num=1980; $num<=2100; $num++){
        echo '<option value="' . $num . '">' . $num . '年</option>';
      }
      ?>
     </select>
     <label for="place">入手場所：</label>
     <select name="place" id="place">
      <option selected>選択してください。</option>
      <?php
      $place = ['ランド','シー','イクスピアリ','リゾートライン','アンバサダーホテル','ミラコスタ','ランドホテル','トイストーリホテル','その他'];
      for($num=0; $num<count($place); $num++){
        echo '<option value="' . $place[$num] . '">' . $place[$num] . '</option>';
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
        echo '<option value="' . $cate[$num] .'">' .$cate[$num] . '</option>';
        // echo '<option value=>'.$cate[$num] . '</option>';
      }
      ?>
     </select><br>
     <!-- <label>画像：<input class=img_update type="file" name="img" accept=".png, .jpg, .jpeg, .pdf, .doc"></label><br> -->
     <label>画像：<input type="file" name="img" accept=".png, .jpg, .jpeg, .pdf, .doc"><p class="img_style"><img src="./img/<?=$v["img"]?>" alt="" width=200px></label><br>

     <label>メモ：<textArea name="naiyou" rows="4" cols="40"></textArea></label><br>
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

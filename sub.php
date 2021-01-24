<?php
function syousai(){  //記事とタイトルを取得
    $news_csv = "news.csv";
    $id = $_GET['id'];
    $fp = fopen($news_csv, 'r+b');
    while ($news = fgetcsv($fp)) {
      if($news[0] === $id) {
        $newses = array($news);
      }
    }
  fclose($fp);
  foreach($newses as $news_top){
      echo"<hr>"."<p>"."タイトル:". $news_top[1]."</p>"."\n";
      echo "<p>"."記事:".$news_top[2]."</p>";
  }
}
function comment(){ //comment.csvファイルに書き込む
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $comment = $_POST["comment"];
        $comment_number = mb_strlen($comment);
        $comment_csv = "comment.csv";
        $id = $_GET['id'];
        if(empty($comment)){
            echo "コメント入力は必須です";
        }
        if($comment_number>10){
            echo "50文字以下にしてください";
        }
        if($comment_number!=0&$comment_number<50){
            $comment =  array($id,$comment);
            $fp = fopen($comment_csv,"ab");
            fputcsv($fp, $comment);
            fclose($fp);
            header('Location: http://localhost/news/sub.php?id='.$id);
            exit;
        }
    }
}
function message(){
        $id = $_GET['id'];
        $comment_csv = "comment.csv";
        $comment_csv = fopen($comment_csv, 'r+b');
        while ($comment_file = fgetcsv($comment_csv)) {
          if($comment_file[0] === $id){
            $comment_final[] = $comment_file;
          }
        }
       fclose($comment_csv);
       if(isset($comment_final)){
           foreach($comment_final as $comments){
              echo "<p>". $comments[1]."</p>"."\n";
           }
       }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="news.css">
    <title>詳細ページ</title>
</head>
<body>
<header>
<a href="http://localhost/news/news.php">laravel news</a>
</header>
<?php
syousai();
?>
<hr>
<form action="#" method="POST">
<textarea name="comment" cols="30" rows="10" class="toukou"></textarea>
<input type="submit" value="コメントを書く">
</form>
<?php
comment();
message();
?>
</body>
</html>
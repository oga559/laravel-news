<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function newNews(){ //テキストファイルに書き込む
    if($_SERVER["REQUEST_METHOD"] === "POST"){
            $title = $_POST["title"]; //titleを受け取る
            $kiji =  $_POST["kiji"]; //kijiを受け取る
            $title_number = mb_strlen($title);//文字列の長さを取得する
            $kiji_number = mb_strlen($kiji);//文字列の長さを取得する
            if(empty($title)){ //タイトル未記入でエラー文表示
               echo "※タイトルを入力してください"."<br>";
            }
            if(empty($kiji)){  //記事が未入力でエラー文表示
                echo "※記事を入力してください"."<br>";
            }
            if($title_number>30){ //タイトルの文字数30以上でエラー文表示
                echo "※30文字以下で入力してください"."<br>";
            }
            if(!empty($title_number) && $title_number<=30 && !empty($kiji_number)){//タイトルと記事が入力済み、記事30文字以下で実行
                $news_csv = "news.csv"; //ファイルを変数化
                $id = count(file($news_csv));
                $fopen = array($id,$title,$kiji);
                $fp = fopen($news_csv,"ab");  //news.csvを開く
                fputcsv($fp,$fopen);
                fclose($fp);//ファイルを閉じる
                header('Location: http://localhost/news/news.php');//手動でURLを指定すると送信されないことを利用しリロードによる二重投稿対策
                exit;//プログラムを終了
            }
            }
    }
    function newsDate(){ //画面に表示する
        $news_csv = "news.csv"; //ファイルの指定
        if(file_exists($news_csv)){ //既にファイルがあるとき実行
            $hozon = file($news_csv); //ファイルの中身を配列として読み込む
            $hozon = array_reverse($hozon); //逆に表示していく関数 これで新着順にできる
            foreach($hozon as $output){ //ここでnews.csvの中身を繰り返し処理する
                $output_number = mb_strlen($output);
                if($output_number>=30){
                    $output = mb_strimwidth(($output),0,70,"...");//超過したら...に変換
                }
                $output = explode(',',$output);
                echo "<hr>"."<p>"."タイトル:".$output[1]."</p>";
                echo "<p>"."記事:".$output[2]."</p>";
                echo  "<a href=sub.php?id=".$output[0].">"."記事全体を表示"."</a>";
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
<title>laravel news</title>
</head>
<body>
<header>
<a href="http://localhost/news/news.php">laravel news</a>
</header>
<form action="news.php" method="POST">
<label for="title">タイトル</label>   
<input type="text" name="title" placeholder="タイトル" class="toukou">
<label for="kiji">記事</label>
<textarea name="kiji" cols="30" rows="10" placeholder="記事" class="toukou"></textarea>
<input type="submit" name="toukou" value="投稿" class="toukou" onclick="return confirm('投稿しますか?')">
</form>
<?php
newNews();//テキストファイルに書き込む
newsDate();//画面に表示
?>
<hr>
</form>
</body>
</html>
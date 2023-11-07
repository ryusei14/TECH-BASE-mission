　<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-24</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="str" placeholder="コメント">
        <input type="text" name="name" placeholder="名前を入力">
        <input type="submit" name="submit">
    </form>
<?php
    $date=date("Y年m月d日 H時i分s秒");
    $str=$_POST["str"];
    $str=$_POST["name"];
    $filename="mission_2-4.txt";
    if($str !=""){
    $fp = fopen($filename,"a" );
    fwrite($fp, $str.PHP_EOL);
    fclose($fp);}
    if(file_exists($filename)){
    $lines = file($filename,FILE_IGNORE_NEW_LINES);
    foreach($lines as $line){
        echo "投稿番号"."<>".$line."<>"."comment"."<>". $date . "<br>";
        echo"----------------------------------------------------------"."<br>";
    }
    }
?>
</body>
</html>

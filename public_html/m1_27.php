<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-27</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" name="num"placeholder="数字を入力してください">
        <input type="submit" name="submit">
    </form>
<?php
$num = $_POST["num"];
if ($num !=""){
$fp = fopen("mission_1-1.txt", "a");
fwrite($fp, $num.PHP_EOL);
fclose($fp);}
echo"書き込み成功!<br>";

$lines = file("mission_1-1.txt");

foreach ($lines as $line) {
    $num = intval($line);
     
    if ($num % 3 == 0 && $num % 5 == 0) {
        echo "FizzBuzz";
    } elseif ($num % 3 == 0) {
        echo "Fizz";
    } elseif ($num % 5 == 0) {
        echo "Buzz";
    } else {
        echo $num;
    }{
        echo " ";
    }
}
?>
</body>
</html>
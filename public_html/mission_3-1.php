<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-1</title>
</head>
<body>
         <form action = "mission_3-1.php" method="post">
              <input type="text" name="name" placeholder="名前">
             
              <input type="text" name="comment"placeholder="コメント">
              
              <input type="submit" value="送信" >
        </form>

 <?php
  $filename = 'mission_3-1.txt';
  if(!empty($_POST["name"])) {

  $fp = fopen($filename,'a');
  $dataFile = explode(" ",$filename) ; 
  fwrite($fp,count(file($dataFile)+1)."<>".$_POST["name"]."<>".$_POST["comment"]."<>".date( "Y年m月d日  H時:i分:s秒" ));
  fwrite($fp,"\n");
  fclose($fp);
  }
 ?>

  <?php
   $fp = fopen('mission_3-1.txt', "r");
while ($line = fgets($fp)) {
  $line2 = explode("<>",$line);
  print_r("<br>");
  print_r($line2[0]."<>".$line2[1]."<>".$line2[2]."<>".$line2[3]);
}
fclose($fp);
?>

</table>
</body>
</html>


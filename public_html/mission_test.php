1: <!DOCTYPE html>
2: <html lang="ja">
3:     <head>
4:         <meta charset="UTF-8">
5:         <title>mission_2-2</title>
6:     </head>
7:     <body>
8:         <form action="" method="post">
9:             <input type="text"name="str" placeholder="コメント">
10:             <input type="submit"name="submit">
11:         </form>
12:         <?php
13:             $str = $_POST["str"];
14:             
15:             if ( !empty($str)==true ) {
16:                 echo "「" .$str. "を受け付けました。」";
17:                 
18:             if ($str = "完成！") {
19:                 echo "おめでとう！";
20:             } else {
21:                 echo $str;
22:             }
23:                 
24:                 $filename = "m_2-2.txt"; 
25:                 $fp = fopen($filename,"a");
26:                 fwrite($fp,$str.PHP_EOL);
27:                 fclose ($fp);
28:                 
29:             } elseif (!empty($str)==false) {
30:                 
31:             } else {
32:                 
33:             }
34:             
35:             if ($str = "完成！") {
36:                 echo "おめでとう！";
37:             }
38:         ?>
39:     </body>
40: </html>
    <?php
    $dsn = 'mysql:dbname=tb250449db;host=localhost';
    $user = 'tb-250449';
    $password = 'sDumkayuWV';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     $sql ='SHOW CREATE TABLE tbtest';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
    }
    echo "<hr>";
    ?>
    <?php
    $dsn = 'mysql:dbname=tb250449db;host=localhost';
    $user = 'tb-250449';
    $password = 'sDumkayuWV';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name CHAR(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
    ?>
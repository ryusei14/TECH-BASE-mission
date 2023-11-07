    <?php
    $dsn = 'mysql:dbname=tb250449db;host=localhost';
    $user = 'tb-250449';
    $password = 'sDumkayuWV';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     // 【！この SQLは tbtest テーブルを削除します！】
        $sql = 'DROP TABLE tbtest';
        $stmt = $pdo->query($sql);
    ?>
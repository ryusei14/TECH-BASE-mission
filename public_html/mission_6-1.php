<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>mission_6-1</title>
</head>
<body>
<?php
$dsn = 'mysql:dbname=tb250449db;host=localhost';
$user = 'tb-250449';
$password = 'sDumkayuWV';

try {
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    // ここでPDOを使用したデータベース関連の処理を追加できます

} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// register.php - ユーザー登録
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // パスワードのハッシュ化
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // データベースにユーザー情報を挿入
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        echo "Registration successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// login.php - ユーザーログイン
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        // データベースからユーザー情報を取得
        $sql = "SELECT * FROM users WHERE username=:username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row["password"])) {
                echo "Login successful!";
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// データベース接続を閉じる
$pdo = null;
?>
</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>mission_5-1</title>
</head>
<body>
<?php
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザ名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$tableName = 'posts';

// テーブルの作成
try {
    $createTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        comment TEXT NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($createTableQuery);
} catch (PDOException $e) {
    echo "テーブルの作成に失敗しました: " . $e->getMessage();
}

$edit_mode = false;

if (!empty($_POST["edit_post_number"])) {
    $edit_number = $_POST["edit_post_number"];
    $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE id = ?");
    $stmt->execute([$edit_number]);
    $edit_post = $stmt->fetch();
    if ($edit_post) {
        $edit_mode = true;
    }
}

if (!$edit_mode) {
    echo '<h3>新規投稿</h3>';
} else {
    echo '<h3>編集モード</h3>';
}
?>

<form action="mission_5-1.php" method="post">
    <?php if ($edit_mode): ?>
    <input type="hidden" name="edit_post_number" value="<?php echo $edit_post['id']; ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="名前" value="<?php echo ($edit_mode) ? htmlspecialchars($edit_post['name']) : ''; ?>">
    <input type="text" name="comment" placeholder="コメント" value="<?php echo ($edit_mode) ? htmlspecialchars($edit_post['comment']) : ''; ?>">
    <input type="password" name="password" placeholder="パスワード">
    <input type="submit" value="<?php echo ($edit_mode) ? '編集' : '送信'; ?>">
</form>

<form action="mission_5-1.php" method="post">
    <label for="delete_post_number">削除対象番号:</label>
    <input type="text" id="delete_post_number" name="delete_post_number">
    <input type="password" name="delete_password" placeholder="パスワード">
    <input type="submit" value="削除">
</form>

<form action="mission_5-1.php" method="post">
    <label for="edit_post_number">編集対象番号:</label>
    <input type="text" id="edit_post_number" name="edit_post_number">
    <input type="password" name="edit_password" placeholder="パスワード">
    <input type="submit" value="編集">
</form>

<?php
if (!empty($_POST["delete_post_number"])) {
    $delete_number = $_POST["delete_post_number"];
    $delete_password = $_POST["delete_password"];
    $stmt = $pdo->prepare("DELETE FROM $tableName WHERE id = ? AND password = ?");
    $stmt->execute([$delete_number, $delete_password]);
}

if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) {
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    
    if ($edit_mode) {
        $edit_post_number = $_POST["edit_post_number"];
        $stmt = $pdo->prepare("UPDATE $tableName SET name = ?, comment = ? WHERE id = ?");
        $stmt->execute([$name, $comment, $edit_post_number]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO $tableName (name, comment, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $comment, $password]);
    }
}

// 投稿一覧の表示
$stmt = $pdo->query("SELECT * FROM $tableName");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>投稿一覧</h2>';
echo '<ul>';
foreach ($posts as $post) {
    echo '<li>' . $post['id'] . ': ' . htmlspecialchars($post['name']) . ': ' . htmlspecialchars($post['comment']);
    echo ' <form action="mission_5-1.php" method="post" style="display:inline;">';
    echo '<input type="hidden" name="edit_post_number" value="' . $post['id'] . '">';
    echo '<input type="submit" value="編集">';
    echo '</form>';
    echo ' <form action="mission_5-1.php" method="post" style="display:inline;">';
    echo '<input type="hidden" name="delete_post_number" value="' . $post['id'] . '">';
    echo '<input type="password" name="delete_password" placeholder="パスワード">';
    echo '<input type="submit" value="削除">';
    echo '</form>';
    echo '</li>';
}
echo '</ul>';
?>
</body>
</html>

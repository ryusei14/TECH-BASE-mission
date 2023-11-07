<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>mission_3-5</title>
</head>
<body>
<?php
$filename = 'mission_3-5_password.txt';
$edit_mode = false;

if (!empty($_POST["edit_post_number"])) {
    $edit_number = $_POST["edit_post_number"];
    $lines = file($filename);

    foreach ($lines as $line) {
        $line_parts = explode("<>", $line);
        if ($line_parts[0] == $edit_number) {
            $edit_mode = true;
            $edit_post = $line_parts;
            break;
        }
    }
}

if (!$edit_mode) {
    echo '<h3>新規投稿</h3>';
} else {
    echo '<h3>編集モード</h3>';
}
?>

<form action="mission_3-5.php" method="post">
    <?php if ($edit_mode): ?>
    <input type="hidden" name="edit_post_number" value="<?php echo $edit_post[0]; ?>">
    <?php endif; ?>
    <input type="text" name="name" placeholder="名前" value="<?php if ($edit_mode) echo htmlspecialchars($edit_post[1]); ?>">
    <input type="text" name="comment" placeholder="コメント" value="<?php if ($edit_mode) echo htmlspecialchars($edit_post[2]); ?>">
    <input type="password" name="password" placeholder="パスワード">
    <input type="submit" value="<?php echo ($edit_mode) ? '編集' : '送信'; ?>">
</form>

<form action="mission_3-5.php" method="post">
    <label for="delete_post_number">削除対象番号:</label>
    <input type="text" id="delete_post_number" name="delete_post_number">
    <input type="password" name="delete_password" placeholder="パスワード">
    <input type="submit" value="削除">
</form>

<form action="mission_3-5.php" method="post">
    <label for="edit_post_number">編集対象番号:</label>
    <input type="text" id="edit_post_number" name="edit_post_number">
    <input type="password" name="edit_password" placeholder="パスワード">
    <input type="submit" value="編集">
</form>

<?php
if (!empty($_POST["delete_post_number"])) {
    $delete_number = $_POST["delete_post_number"];
    $delete_password = $_POST["delete_password"];
    $lines = file($filename);
    $new_lines = array();

    foreach ($lines as $line) {
        $line_parts = explode("<>", $line);
        if ($line_parts[0] == $delete_number && $line_parts[4] == $delete_password) {
            continue; // 削除対象行はスキップ
        }
        $new_lines[] = $line;
    }

    file_put_contents($filename, implode("", $new_lines));
}

if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"])) {
    $fp = fopen($filename, 'a');
    if ($edit_mode) {
        $new_post = $edit_post[0] . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y年m月d日 H時:i分:s秒") . "<>" . $_POST["password"];
        $new_lines = array();
        foreach ($lines as $line) {
            $line_parts = explode("<>", $line);
            if ($line_parts[0] == $edit_post[0]) {
                $new_lines[] = $new_post;
            } else {
                $new_lines[] = $line;
            }
        }
        file_put_contents($filename, implode("", $new_lines));
    } else {
        fwrite($fp, (count(file($filename)) + 1) . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y年m月d日 H時:i分:s秒") . "<>" . $_POST["password"]);
        fwrite($fp, "\n");
    }
    fclose($fp);
}

$lines = file($filename);
echo '<h2>投稿一覧</h2>';
echo '<ul>';
foreach ($lines as $line) {
    $line_parts = explode("<>", $line);
    if (count($line_parts) >= 5) {
        $post_number = $line_parts[0];
        $name = $line_parts[1];
        $comment = $line_parts[2];
        $timestamp = $line_parts[3];
        echo '<li>' . $post_number . ': ' . htmlspecialchars($name) . ': ' . htmlspecialchars($comment) . ' (' . $timestamp . ')';
        echo ' <form action="mission_3-5.php" method="post" style="display:inline;">';
        echo '<input type="hidden" name="edit_post_number" value="' . $post_number . '">';
        echo '<input type="submit" value="編集">';
        echo '</form>';
        echo '</li>';
    }
}
?>
</body>
</html>
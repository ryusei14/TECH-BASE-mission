<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
    <title>mission_3-5</title>
</head>
<body>
<?php
$filename = 'mission_3-5.txt';
$edit_mode = false;
$edit_post = null;

// 編集対象番号が送信された場合、該当の投稿を編集モードに切り替える
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

// 新規投稿または編集モードを切り替えるフォーム
if (!$edit_mode) {
    echo '<h3>新規投稿</h3>';
} else {
    echo '<h3>編集モード</h3>';
}
?>

<form action="mission_3-5.php" method="post">
    <?php if ($edit_mode): ?>
    <input type="hidden" name="edit_post_number" value="<?php echo $edit_post[0]; ?>">
    <input type="text" name="name" placeholder="名前" value="<?php echo $edit_post[1]; ?>">
    <input type="text" name="comment" placeholder="コメント" value="<?php echo $edit_post[2]; ?>">
    <input type="password" name="password" placeholder="現在のパスワード" value="<?php echo $edit_post[4]; ?>">
    <input type="submit" name="edit" value="編集">
    <?php else: ?>
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="password" name="password" placeholder="パスワード">
    <input type="submit" name="submit" value="送信">
    <?php endif; ?>
</form>

<!-- 削除フォーム -->
<form action="mission_3-5.php" method="post">
    <label for="delete_post_number">削除対象番号:</label>
    <input type="text" id="delete_post_number" name="delete_post_number">
    <input type="password" name="delete_password" placeholder="パスワード">
    <input type="submit" name="delete" value="削除">
</form>

<?php
if (!empty($_POST["delete_post_number"])) {
    $delete_number = $_POST["delete_post_number"];
    $delete_password = $_POST["delete_password"];
    $lines = file($filename);
    $new_lines = array();

    foreach ($lines as $line) {
        $line_parts = explode("<>", $line);

        if ($line_parts[0] != $delete_number || $line_parts[4] != $delete_password) {
            $new_lines[] = $line;
        }
    }

    file_put_contents($filename, implode("", $new_lines));
}

if (!empty($_POST["name"])) {
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
        $edit_mode = false;
    } else {
        $password = $_POST["password"];
        fwrite($fp, (count(file($filename)) + 1) . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y年m月d日 H時:i分:s秒") . "<>" . $password);
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
        echo '<li>' . $post_number . ': ' . $name . ': ' . $comment . ' (' . $timestamp . ')';
        // 編集ボタン
        echo ' <form style="display:inline;" action="mission_3-5.php" method="post">
                    <input type="hidden" name="edit_post_number" value="' . $line_parts[0] . '">
                    <input type="submit" name="edit_post" value="編集">
                </form>';
        echo '</li>';
    }
}
?>
</body>
</html>

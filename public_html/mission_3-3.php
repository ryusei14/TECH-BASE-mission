<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
    <title>mission_3-3</title>
</head>
<body>
<form action="mission_3-3.php" method="post">
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="submit" value="送信">
</form>

<!-- 削除フォーム -->
<form action="mission_3-3.php" method="post">
    <label for="delete_post_number">削除対象番号:</label>
    <input type="text" id="delete_post_number" name="delete_post_number">
    <input type="submit" value="削除">
</form>

<?php
$filename = 'mission_3-3.txt';

// 削除対象番号が送信された場合
if (!empty($_POST["delete_post_number"])) {
    $delete_number = $_POST["delete_post_number"];
    $lines = file($filename);
    $new_lines = array();

    foreach ($lines as $line) {
        $line_parts = explode("<>", $line);
        if ($line_parts[0] != $delete_number) {
            $new_lines[] = $line;
        }
    }

    // ファイルに新しいデータを書き込み
    file_put_contents($filename, implode("", $new_lines));
}

// 新規投稿が送信された場合
if (!empty($_POST["name"])) {
    $fp = fopen($filename, 'a');
    fwrite($fp, (count(file($filename)) + 1) . "<>" . $_POST["name"] . "<>" . $_POST["comment"] . "<>" . date("Y年m月d日 H時:i分:s秒"));
    fwrite($fp, "\n");
    fclose($fp);
}

// 投稿を表示
$lines = file($filename);
echo '<h2>投稿一覧</h2>';
echo '<ul>';
foreach ($lines as $line) {
    $line_parts = explode("<>", $line);
    if (count($line_parts) >= 4) {
        $post_number = $line_parts[0];
        $name = $line_parts[1];
        $comment = $line_parts[2];
        $timestamp = $line_parts[3];
        echo '<li>' . $post_number . ': ' . $name . ': ' . $comment . ' (' . $timestamp . ')</li>';
    } else {
        // 配列の要素数が4未満の場合、エラーを回避するために何らかのエラーメッセージを表示できます
        echo '<li>エラー: 投稿のフォーマットが不正です</li>';
    }
}
//この修正により、$line_parts 配列の要素数が4未満の場合にエラーメッセージを表示し、エラーを回避できます。また、正常に4つの要素を含む投稿の場合は表示されます。






?>
</body>
</html>

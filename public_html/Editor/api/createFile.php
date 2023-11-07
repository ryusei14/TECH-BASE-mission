<?php
// $_POST["path"]に名前が$_POST["name"]のファイルを作成
if (isset($_POST["path"]) && $_POST["path"] !== "") {
    if (isset($_POST["name"]) && $_POST["name"] !== "") {
        $path = (string) $_POST["path"];
        $name = (string) $_POST["name"];
        $new_file = $path . $name;
        if (file_exists($new_file)) {
            http_response_code(406);
            echo "<p>$name is Exist.</p>";
        } else {
            if (touch($new_file)) {
                http_response_code(200);
            } else {
                http_response_code(500);
                echo "<p>Failed to Create $name.</p>";
            }
        }
    } else {
        http_response_code(400);
        echo '<p>Require Param "name"</p>';
    }
} else {
    http_response_code(400);
    echo '<p>Require Param "path"</p>';
}

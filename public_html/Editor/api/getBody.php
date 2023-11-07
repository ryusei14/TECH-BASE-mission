<?php
if (isset($_GET["path"]) && $_GET["path"] != "") {
    $path = $_GET["path"];
    if (file_exists($path)) {
        http_response_code(200);
        header("Content-type: text/plain");
        echo file_get_contents($path);
    } else {
        http_response_code(500);
        echo "<p>Not Found " . pathinfo($path, PATHINFO_BASENAME) . "</p>";
    }
} else {
    http_response_code(400);
    echo '<p>Require Query "path"</p>';
}

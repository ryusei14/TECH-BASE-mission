<?php
if(isset($_POST["old_path"])&&$_POST["old_path"]){
    if(isset($_POST["new_path"])&&$_POST["new_path"]){
        $old_path=$_POST["old_path"];
        $new_path=$_POST["new_path"];
        if(file_exists($new_path)){
            http_response_code(406);
            echo '<p>'.basename($new_path).' is Exist.</p>';
        }else{
            if(rename($old_path, $new_path)){
                http_response_code(200);
            }else{
                http_response_code(500);
                echo '<hr><p>Fail to Move.</p><hr>';
            }
        }
    }else{
        http_response_code(400);
        echo '<p>Require Params "new_path"</p>';
    }
}else{
    http_response_code(400);
    echo '<p>Require Params "old_path"</p>';
}
?>
<?php
if(isset($_POST["old_path"])&&$_POST["old_path"]){
    if(isset($_POST["new_name"])&&$_POST["new_name"]){
        $old_path=$_POST["old_path"];
        $new_name=$_POST["new_name"];
        $new_path=dirname($old_path).'/'.$new_name;
        if(file_exists($new_path)){
            http_response_code(406);
            echo '<p>'.$new_name.' is Exist.</p>';
        }else{
            if(rename($old_path, $new_path)){
                http_response_code(200);
            }else{
                http_response_code(500);
                echo '<hr><p>Fail to Rename.</p><hr>';
            }
        }
    }else{
        http_response_code(400);
        echo '<p>Require Params "new_name"</p>';
    }
}else{
    http_response_code(400);
    echo '<p>Require Params "old_path"</p>';
}
?>
<?php
if(isset($_POST["path"])&&$_POST["path"]!=""){
    if(is_uploaded_file($_FILES["file"]["tmp_name"])){
        $path=$_POST["path"];
        $filename=$path."/".$_FILES["file"]["name"];
        if(file_exists($filename)){
            http_response_code(406);
            echo '<p>'.$_FILES['file']['name'].' is Exist.</p>';
        }else{
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $filename )) {
                http_response_code(200);
            }else{
                http_response_code(500);
                echo "<p>Cannot Upload ".$_FILES['file']['name']."</p>";
            }
        }
    }else{
        http_response_code(400);
        echo '<p>Require File</p>';
    }
}else{
    http_response_code(400);
    echo '<p>Require Params "path"</p>';
}
?>
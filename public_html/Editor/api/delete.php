<?php
function remove_dir($path){
    $list = scandir($path); $length = count($list);
    for($i=0; $i<$length; $i++){
        if($list[$i] != '.' && $list[$i] != '..'){
            if(is_dir($path.'/'.$list[$i])){
                remove_dir($path.'/'.$list[$i]);
            }else{
                unlink($path.'/'.$list[$i]);
            }
        }
    }
    rmdir($path);
}


if(isset($_POST["path"])&&$_POST["path"]){
    if(isset($_POST["is_file"])&&$_POST["is_file"]){
        $path=$_POST["path"];
        $is_file=$_POST["is_file"];
        if(!file_exists($path)){
            http_response_code(406);
            echo '<p>'+basename($path).' is Exist.</p>';
        }else{
            if($is_file=='true'){
                if(unlink($path)){
                    http_response_code(200);
                }else{
                    http_response_code(500);
                    echo '<p>Fail to Delete '.basename($path).'</p>';
                }
            }else{
                remove_dir($path);
                http_response_code(200);
            }
        }
    }else{
        http_response_code(400);
        echo '<p>Require Param "is_file"</p>';
    }
}else{
    http_response_code(400);
    echo '<p>Require Param "path"</p>';
}
?>
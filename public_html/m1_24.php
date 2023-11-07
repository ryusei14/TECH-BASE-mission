<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-24</title>
</head>
<body>
   <a href="">リセット</a><br>
    <form action="" method="post">
        <input type="text" name="str" placeholder="何か入力">
        <input type="submit" name="submit">
    </form>
＊＊＊<br>
１、ノーチェック：<br>
    <?php
            $str = $_POST["str"];//ここでエラーが出ることがあります
            echo "【".$str."】";
    ?>
＊＊＊<br>
２、isset()チェック：<br>
    <?php
        if( isset( $_POST["str"] ) ){
            $str = $_POST["str"];
            echo "【".$str."】";
        } else {
            echo "- post送信 なし -";
        }
    ?>
＊＊＊<br>
３、empty()チェック（実際は !empty() でチェック ）：<br>
    <?php
        if( !empty( $_POST["str"] ) ){
            $str = $_POST["str"];
            echo "【".$str."】";
        } else {
            echo "- str 中身なし -";
        }
    ?>
＊＊＊<br>
    
    
</body>
</html>
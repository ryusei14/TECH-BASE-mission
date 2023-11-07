<?php
include_once('config.php');

/**
 * 与えられた$pathのディレクトリリストを取得
 */
function getPath(string $path)
{
    /**
     * @var array $list ディレクトリの中にあるファイルとディレクトリの名前一覧
     */
    $list = scandir($path);
    $dirs = array();

    // 与えられた$pathのディレクトリツリーの中身を検査
    /**
     * @var string $leef ディレクトリの要素名(ファイルまたはディレクトリ名)
     */
    foreach ($list as $leef) {
        // 取り出した要素が.または..ならば飛ばす
        if ($leef == '.' || $leef == '..') {
            continue;
        }
        // 取り出した要素がエディタディレクトリなら飛ばす
        if ($leef == editor_directory_name) {
            continue;
        }
        // 取り出した要素がdebug.logなら飛ばす
        if ($leef == 'debug.log') {
            continue;
        }

        if (is_dir($path . '/' . $leef)) {
            // $leefがディレクトリなら
            // $leefの中身をgetPathを再帰的に呼んで取得
            if (null != ($childtree = getPath($path . '/' . $leef))) {
                // 子を持つフォルダとして追加
                array_push($dirs, array(
                    "name" => $leef,
                    "path" => "$path/$leef",
                    "type" => "folder",
                    "children" => $childtree
                ));
            } else {
                // 子を持たないフォルダ
                array_push($dirs, array(
                    "name" => $leef,
                    "type" => "folder",
                    "path" => "$path/$leef"
                ));
            }
        } else {
            // $leefがファイルなら
            array_push($dirs, array(
                "name" => $leef,
                "type" => pathinfo($leef, PATHINFO_EXTENSION),
                "path" => $path . '/' . $leef
            ));
        }
    }
    return $dirs;
}
// $id = $request->input('data')['id'];
$mydir = getPath("../..");
http_response_code(200);
echo json_encode($mydir, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

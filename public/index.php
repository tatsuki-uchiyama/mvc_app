<?php
require_once('Smarty.class.php');
require_once('../lib/route.php');
define('ROOT_PATH', str_replace('public', '', $_SERVER['DOCUMENT_ROOT']));

if (empty($_SERVER['REQUEST_URI'])) {
    exit;
}

$parse = parse_url($_SERVER['REQUEST_URI']);
$method = strtolower($_SERVER['REQUEST_METHOD']);

if (mb_substr($parse['path'], -1) === '/') {
    // URLがlocalhostのみの場合は HostControllerのindexメソッドを動かすように設定している。
    // トップページを変更したい場合は下のpathを変更すれば変更できる。
    $path = 'home/index';
}else{
    $path = mb_substr($parse['path'], 1);
}

// .htaccess経由で様々なURLでこのページが読まれるためURLに書かれている文字列を
// route()関数に値を渡している。
route($path, $method);

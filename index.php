<?php
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/parse.php?page=likes');
exit;
require_once 'config.php';


if (!empty($_COOKIE['token'])) {
// 	if(filesize('token.txt') !== 0) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/parse.php');
// 		}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Location: https://oauth.vk.com/authorize?client_id=' . $appId . '&scope=market,photos,groups,offline&redirect_uri=http://' . $_SERVER['HTTP_HOST'] . '/&display=page&response_type=code');
}
if (isset($_GET['code'])) {
    $vkCode = $_GET['code'];
    $tokenSrc = 'https://oauth.vk.com/access_token?client_id=' . $appId . '&client_secret=' . $protectKey . '&redirect_uri=http://' . $_SERVER['HTTP_HOST'] . '/&code=' . $_GET['code'];


    $token = json_decode(file_get_contents($tokenSrc));

    if (setcookie('token', $token->access_token))
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/parse.php');
//         $fp = fopen('token.txt', 'w+');
//         fputs($fp, $token->access_token);
//         fclose($fp);
}


require_once 'inc/input.php';


?>


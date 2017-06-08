<?php

$randomName = $_GET['item'];
$filename = 'files/' . $randomName . '.txt';
if (file_exists($filename)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . 'vk_id_likes__' . $randomName . '.txt');
    readfile($filename);
    unlink($filename);
    exit;
}
$filenameExcel = 'files/' . $randomName . '.xls';
header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$randomName.xls");
readfile($filenameExcel);
unlink($filenameExcel);
exit;
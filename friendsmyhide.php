<?php
require_once 'inc/form-friend.php';

if ($_POST['userId']) {
    $friendId = $_POST['userId'];
    $friendList = getFriends($friendId)->response;
    $countFriends = count($friendList);
    $friendsArr = [];
    $overFriends = [];

    if (!$friendList) {
        die('Неккоректно введен id');
    }
    foreach ($friendList as $value) {

        $friends = getFriends($value)->response;
        if (empty($friends)) {
            continue;
        }

        if (!in_array($friendId, $friends)) {
            $overFriends[] = $value;
        }

    }

    $general = &$friendsArr;





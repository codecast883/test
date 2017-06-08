<?php

// function allPost($groupId,$vkToken){
// 	$sRequest ='https://api.vk.com/method/wall.get?owner_id=-' . $groupId . '&count=1&offset=320&access_token=' . $vkToken;
// 	$oResponce = json_decode(file_get_contents($sRequest));
// 	return $oResponce;
// }

function userUrlValidationForm($userUrl){
	$explode = explode('/', $userUrl);
	$id = substr($explode[3], 2);
	if (!preg_match("/^[0-9]+$/", $id)) {
		$ids = getUserName($explode[3])->response[0]->uid;
		return $ids;
	}else{
		return substr($explode[3], 2);
	}
		
}

function getUserName($userName){
	
	$sRequest ='https://api.vk.com/method/users.get?user_ids=' . $userName;
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}



function curl($url, $headers=false) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, $headers);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1');
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}

function allLikeUser($groupId,$itemId){
	// global $vkToken;
	$sRequest ='https://api.vk.com/method/likes.getList?type=post&owner_id=-' . $groupId . '&count=1000&item_id='.$itemId.'&access_token=' . $vkToken;
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}

function getGroupName($groupId){
	global $vkToken;
	$sRequest ='https://api.vk.com/method/groups.getById?group_id=' . $groupId . '&access_token=' . $vkToken;
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}

function getTimeStamp($date){
	if(!empty($date)){
	$massDate = date_parse($date);
	$timestamp = mktime(0,0,0,$massDate['month'],$massDate['day'],$massDate['year']);
	return $timestamp;
}else{
	return false;
	}

}


function getFriends($userId){
	// global $vkToken;
	$sRequest ='https://api.vk.com/method/friends.get?user_id=' . $userId;
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}


function getUserId($UserName){
	global $vkToken;
	$sRequest ='https://api.vk.com/method/users.get?user_id=' . $UserName;
	$oResponce = json_decode(curl($sRequest));
	return $oResponce;
}

function getPhoto($userId,$album){
	// global $vkToken;
	$sRequest ='https://api.vk.com/method/photos.get?owner_id=' . $userId . '&album_id='.$album.'&count=500';
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}

function allLikePhoto($userId,$itemId){
	// global $vkToken;
	$sRequest ='https://api.vk.com/method/likes.getList?type=photo&owner_id=' . $userId . '&count=400&item_id='.$itemId;
	$oResponce = json_decode(file_get_contents($sRequest));
	return $oResponce;
}


?>
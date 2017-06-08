
<?php
echo '<div class="jumbotron">Поиск по активности на странице</div>';
require_once 'inc/form-friend.php';

// function friends($friendId)

if($_POST['userId']){
	if (strpos($_POST['userId'], 'http', 0) === false) {
		die('Введён некорректный url');
	}
	$userId = userUrlValidationForm($_POST['userId']);

	$friendList = getFriends($userId)->response;
	$photoAllId = [];
	$allWallPhoto = getPhoto($userId,'profile')->response;
	$allProfilePhoto = getPhoto($userId,'wall')->response;
 	foreach ($allWallPhoto as $key => $value) {
		if ($key > 400) {
			break;
		}
		$photoAllId[] = $value->pid;
	}
	if ($key < 400) {
		foreach ($allProfilePhoto as $key => $value) {
			if ($key > 400) {
				break;
			}
		$photoAllId[] = $value->pid;
		}
	}

	$likeId = [];
	$overLike = [];
	foreach ($photoAllId as $key => $value) {

		$massLike = allLikePhoto($userId,$value)->response->users;
		if (count($massLike) > 400) {
			continue;
		}
		foreach ($massLike as $key => $id) {
			
			$likeId[] = $id;
		}
		
	}
	$generalArray = array_values(array_unique($likeId));

$myFriends = array_intersect($generalArray, $friendList);
	if (!empty($myFriends)) {

			foreach ($myFriends as $key => $value) {

			unset($generalArray[$key]);
		}
	}


$hideFriend = [];
	foreach ($generalArray as $value) {
		if ($value == $userId) {
				continue;
			}
		$oneMass = getFriends($value)->response;
		if (empty($oneMass)) {
				continue;
			}
		$key = array_keys($oneMass,$userId);
		if (!empty($key)) {
			foreach ($key as $values) {
				$hideFriend[] = $value;
			}
			
		}
		unset($oneMass);
	}
// // $hideFriend = array_keys($generalArray,$friendId);
	if (!empty($hideFriend)) {
		echo "Список скрытых друзей<br>";
		foreach ($hideFriend as $value) {
			echo "<a href='https://vk.com/id$value'>https://vk.com/id$value</a><br><br>";
		}
	}else{
		echo "Скрытых друзей не обнаружено<br><br><br>";
	}
	// $photoWallCount = count($allWallPhoto);
	// echo $allWallPhoto;
	// echo $photoWallCount;

echo "<pre>";
  // print_r(getPhoto($userId,'wall'));
  // print_r(allLikePhoto($userId,365964823));
  // print_r($generalArray);
  
echo "</pre>";
}

?>
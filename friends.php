<?php
echo '<div class="jumbotron">Поиск по друзьям друзей</div>';
require_once 'inc/form-friend.php';

// function friends($friendId)

if($_POST['userId']){
$friendId = userUrlValidationForm($_POST['userId']);
$friendList = getFriends($friendId)->response;
$countFriends = count($friendList);
$friendsArr = [];
$overFriends = [];
// for ($i=0; $i <= $countFriends; $i++) { 
	// $id = getFriends($friendId) -> response[$i];
	// $friends = getFriends($id) -> response;
if (!$friendList) {
	die('Неккоректно введен id');
}	
	foreach ($friendList as $value) {
			// fwrite($h, "$friends[1] \r\n");
			$friends = getFriends($value)->response;
			if (empty($friends)) {
				continue;
			}
			if (count($friends) > 300) {
				$overFriends[] = $value;
				continue;
			}
			foreach ($friends as $value) {

				$friendsArr[] = $value;
			}
		}

$general = &$friendsArr;
$generalArray = array_values(array_unique($general));

	$myFriends = array_intersect($generalArray, $friendList);
	if (!empty($myFriends)) {

			foreach ($myFriends as $key => $value) {

			unset($generalArray[$key]);
		}
	}

$hideFriend = [];
	foreach ($generalArray as $value) {
		if ($value == $friendId) {
				continue;
			}
		$oneMass = getFriends($value)->response;
		if (empty($oneMass)) {
				continue;
			}
		$key = array_keys($oneMass,$friendId);
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
			echo "<a href='https://vk.com/id$value'>$value</a><br><br>";
		}
	}else{
		echo "Скрытых друзей не обнаружено<br><br><br>";
	}

	if (!empty($overFriends)) {
		echo "Друзья у которых больше 300 человек в друзьях<br>";
		foreach ($overFriends as $value) {
			echo "<a href='https://vk.com/id$value'>$value</a><br>";
		}
	}
}

	
	// register_shutdown_function('friends');
	


// $h = fopen('s.txt', 'w+');


// echo "<pre>";
	// print_r($myFriends);
	// print_r($generalArray);
	// print_r($general);
	// echo "</pre>";

	// [2927] => 352962467
 //    [3117] => 341842466
?>
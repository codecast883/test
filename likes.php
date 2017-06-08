<div class="wrapper row">
		 

			
		
		<div class="starter-template">
			<form class="form-inline" role="form" method="post" action="">
			  
			  От <input type="text" name="dateFrom" class="tcal form-control " value="" required pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d" >
			  До <input type="text" name="dateTo" class="tcal form-control" value="" required pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d"><br><br>
			  <input type="text" class="form-control" placeholder='id или имя группы' name="groupId"  value="<?= $_POST['groupId']?>" required><br><br>


			  
			  <input type="submit" name="submit" class="btn btn-success" value="Получить">

			</form>

		</div>
		</div>





<?php

// $vkToken = $_COOKIE['token'];



require_once('PHPExcel.php');
 require_once('PHPExcel/Writer/Excel5.php');


if($_POST['dateFrom']){
	
	if (!empty($_POST['groupId'])) {
		$groupId = strip_tags($_POST['groupId']);
		$groupNameId = getGroupName($groupId)->response[0]->gid;
	}else{
		echo "<b>Вы не ввели название группы</b>";
		die;
	}

	if (!empty($_POST['dateFrom'])) {
		$dateFrom = strip_tags($_POST['dateFrom']);
	}else{
		echo "<b>Вы не ввели начальную дату</b>";
		die;
	}

	if (!empty($_POST['dateTo'])) {
		$dateTo = strip_tags($_POST['dateTo']);
	}else{
		echo "<b>Вы не ввели конечную дату</b>";
		die;
	}
	
	

	$dateTimeStamp1 = getTimeStamp($dateFrom);
	$dateTimeStamp2 = getTimeStamp($dateTo);
	
	$offset = -100;
	$i = -1;
	$arrPost = [];
 	while ($i <= 30 ) {
 		$i++;
 		$offset += 100;

 		if(!empty($_POST['groupId'])){
 			$sRequest ='https://api.vk.com/method/wall.get?owner_id=-'. $groupNameId .'&count=100&offset='.$offset.'&access_token=' . $vkToken;
 		}
 
		 	$oResponce = json_decode(file_get_contents($sRequest));
		 	// echo "<pre>";
		 	//   print_r($oResponce);
		 	//   echo "</pre>";
		 		$arrPost[] = $oResponce;
		 		$arrPostCount = $arrPost[0] -> response[0];

 		for ($a=0; $a <= 100 ; $a++) { 
 				$fullArr[] = $arrPost[$i]->response[$a];
 				if(count($fullArr) > $arrPostCount)
 					break;
 			}
 	}

 	if ($oResponce->error->error_code == 100) {
 		die('<div class="alert alert-danger">Ошибка, неизвестная группа</div>');
 	}
 	 $arrUsersLike = [];
 	foreach ($fullArr as $value) {
 		
 		$date = getdate($value -> date);
 		$dateString = $date['mon'] . '/' . $date['mday'] . '/' .$date['year'];
 		$dateStringTimeStamp = getTimeStamp($dateString);
 		
 		 // if($dateStringTimeStamp <= $dateTimeStamp2 and $dateStringTimeStamp >= $dateTimeStamp1){
 			if($dateStringTimeStamp < $dateTimeStamp1){
 				continue;
 			}
 		 	 $arrUsersLike[] = allLikeUser($groupNameId,$value->id)->response->users;

 		 	 if ($dateStringTimeStamp > $dateTimeStamp2) {
 		 	 	break;
 		 	 }

 		 	  // $arrTextPost[] = $value -> text;
 		 // }
 	}	

 		
	    echo '<br><div class="well"><h3>Список лайкнувших с ' . $_POST['dateFrom'] . ' по '. $_POST['dateTo'] . '</h2><br><h2> Группа: ' . $_POST['groupId'] . '</h3></div>';
	    require 'inc/form.php';
	    echo '<br>';
	    // $countLike = count($arrUsersLike);
	    echo '<div class="col-md-5">';
	    echo '<table class="table table-striped">';
	    echo '<thead>';
	    echo '<th>ID пользователя</th>';
	    echo '<th>Число лайков оставленных пользователем</th>';
	    echo '</thead>';
	    $idList = [];
	    foreach ($arrUsersLike as $value) {
	    	foreach ($value as $id) {
	    		$idList[] = $id;
	    	}
	    }
	    $idListCount = array_count_values($idList);
	    arsort($idListCount);

	    $_SESSION['result_like'] = $idListCount;

	    
	    foreach ($idListCount as $key => $value) {
	    		echo "<tr>";

	    		echo "<td>";
	    		echo "<a href='https://vk.com/id$key'>$key</a>";
	    		echo "</td>";

	    		echo "<td>";
	    		echo "$value</b>";
	    		echo "</td>";

	    		
	    		echo "</tr>";
	    }
	    echo "</table>";
	    echo '</div>';
}


if ($_POST['submitSelectTxt'] or $_POST['submitSelectExcel']) {
	if (empty($_SESSION['result_like'])) {
		die('Ошибка чтения cookie');
	}
		$resultLike = $_SESSION['result_like'];
		$countLikeFrom = strip_tags($_POST['likeFrom']);
		$countLikeTo = strip_tags($_POST['likeTo']);

		if (empty($countLikeFrom)) {
			
			$countLikeFrom = 1;
		}
		
		if (empty($countLikeTo) or $countLikeTo == 'До бесконечности') {
			$maxLikeValue = max($resultLike);
			$countLikeTo = $maxLikeValue;
		}
		$randomName = substr(md5(uniqid()), 0, 14);
		if ($_POST['submitSelectTxt']) {
			$dir = 'files/'.$randomName .'.txt';
			if(!$temp = fopen($dir , 'w+')){
				die('Ошибка создания файла');
			}
		}elseif ($_POST['submitSelectExcel']) {
			// Создаем объект класса PHPExcel
			$xls = new PHPExcel();
			// Устанавливаем индекс активного листа
			$xls->setActiveSheetIndex(0);
			// Получаем активный лист
			$sheet = $xls->getActiveSheet();
			// Подписываем лист
			$sheet->setTitle('Таблица лайкнувших');


			$sheet->setCellValue("A1", 'id пользователя');
			$sheet->setCellValue("B1", 'Кол-во лайков');
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);

			$i = 1;
		}
		

		
		foreach ($resultLike as $key => $value) {

			$i++;
			if($value >= $countLikeFrom and $value <= $countLikeTo){
				// $stringId = $key .'=>'. $value;
				if ($_POST['submitSelectTxt']){
					fwrite($temp , "https://vk.com/id$key\r\n");
				}elseif ($_POST['submitSelectExcel']) {
					
					$sheet->setCellValue('A'. $i , 'https://vk.com/id' . $key);
					$sheet->setCellValue('B'. $i, $value);

				}


			}
		
		}

		 
		if ($_POST['submitSelectExcel']) { 
			$objWriter = new PHPExcel_Writer_Excel5($xls);
		 	$objWriter->save('files/' . $randomName . '.xls');
		}
		 
		fclose($temp);
		header('Location: http://'. $_SERVER['HTTP_HOST'] . '/download.php?item='.strip_tags($randomName));
	

	
     
}
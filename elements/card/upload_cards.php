<?php

if($_GET['type']=='upload_cards'){
		//начинаем проверку загрузку файла
	$allowedExts = array("CSV","csv"); 
	//$extension = end(explode(".", $_FILES["attachment"]["name"]));
	$tmp_files = explode(".", $_FILES["attachment"]["name"]);
	$extension = end($tmp_files);
	$allowedType = array("csv/plain","application/vnd.ms-excel","text/csv");
	// загружаем файло application/vnd.ms-excel
	if ( in_array($_FILES["attachment"]["type"], $allowedType) && ($_FILES["attachment"]["size"] < 1800000) && in_array($extension, $allowedExts)) {
		if ($_FILES["attachment"]["error"] > 0) { 
			echo "Return Code: " . $_FILES["attachment"]["error"] . "<br>"; 
		} 
		else{
			if (get_user_class() > UC_ADMINISTRATOR) {
				echo "Upload: " . $_FILES["attachment"]["name"] . "<br>";
				echo "Type: " . $_FILES["attachment"]["type"] . "<br>";
				echo "Size: " . ($_FILES["attachment"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["attachment"]["tmp_name"] . "<br>";
			}
		   $time = time();
				move_uploaded_file($_FILES["attachment"]["tmp_name"], "upload/upload_cards_" . $time.".csv");
				//echo "Файл загружен: " . "upload/r_" . $time.".txt <br />"; 
			} 
	}
	//если не прошло по типу/размеру 
	else {
		if (get_user_class() > UC_ADMINISTRATOR) {
		//print_r ($_FILES["attachment"]);
	print '<div class="alert alert-bordered-dotted margin-bottom-30"></span>
		<h4><strong>Информация по загрузке</strong></h4>
	<p>Upload: '.$_FILES["attachment"]["name"].'<br>
	Type: '.$_FILES["attachment"]["type"].'<br>
	Size: '.($_FILES["attachment"]["size"] / 1024).' kB<br>
	</p></div>';
			}
		
		stderr("Ошибка","Не подходящий файл","no");	
		
	} 

	// загружаем файло в переменную
	$mass = file("upload/upload_cards_" . $time.".csv");

    //загружаем список карт
    $res_cobrand = sql_query("SELECT id,name FROM card_cobrand WHERE `disable` = 0");
    while($row_cobrand = mysql_fetch_array($res_cobrand)){
        $data_cobrand[$row_cobrand['id']]=str_replace(" ","",$row_cobrand['name']);
    }

	// первую строчку пропускаем, т.к. там просто инфа

	for ($i = 1; $i < count($mass); $i++) {
		$num_err['all']++;
		$error  = 0;

		$mass[$i] = mb_convert_encoding($mass[$i], 'utf-8', "cp1251");

		$data = explode(";", $mass[$i]);
		/*	$data['X'] 0 - Имя; 1 - Сотовый; 2 - EQUID; 3- карта; 4 - Комментарий; 5 - учетка пользователя; 6 - признак VIP-карты	*/
		// сразу задаем к какому чел-ку и отделению прикрепляем
		$manager = $CURUSER['id'];
		$department = $CURUSER['department'];

			// проверяем имя
		$name = mb_convert_case(trim($data["0"]),MB_CASE_TITLE);

		if (iconv_strlen($name,'utf-8') < 5){
			$num_err['name']++;
			//$text_err .=  "<b>".$data['0']."</b> не добавлен, т.к. <br />";
			$text_err[$i]['name'] = "Короче 5 символов";

			$error = 1;

		}
			// проверяем сотовый
		$mobile = check_mobile($data['1'],false);

		if(strlen($mobile) == 11){
				$mobile = $mobile;
		}
		else{
			$num_err['mobile']++;
			$text_err[$i]['mobile'] = "Некорректная длина";

			//$mobile='NULL';
			$error = 1;
		}

		$equid = sqlesc($data['2']);

        //проверяем карты
        $name_cobrand = str_replace(" ","",$data['3']);
       
        $cobrand_id = array_search($name_cobrand,$data_cobrand);
        if(!$cobrand_id){
            $num_err['cobrand_id']++;
            $text_err[$i]['cobrand_id'] = "Такая карта не найдена";

            //$mobile='NULL';
            $error = 1;
        }



			// переводим дату контакта
		//$next_call = birthday_time($data['4']);
		$comment = sqlesc($data['4']);

			//проверяем логин на существование
		if($data['5']){
            $login = trim($data['5']);
			if(get_user_class() <= UC_HEAD){
				$res=sql_query("SELECT `id`,`department` FROM `users` WHERE `login`='".$login."' AND department = '".$CURUSER['department']."'");

			}
			elseif(get_user_class() == UC_POWER_HEAD){
				$res=sql_query("SELECT users.id,users.department FROM `users`LEFT JOIN department ON department.id = users.department WHERE `login`='".$login."' AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')");

			}
			elseif(get_user_class() == UC_ADMINISTRATOR){
				$res=sql_query("SELECT `id`,`department` FROM `users` WHERE `login`='".$login."';");

			}
			else{
				die('error');
			}

			if(mysql_num_rows($res) == 0) {
				$num_err['login']++;
				$text_err[$i]['manager'] = "Такой менеджер не найден";
			}
			else {
				$row = mysql_fetch_array ($res);
				if ($row['id']) {
					$manager = $row['id'];
					$department = $row['department'];
				}
			}
		}

		


		$data_vip = trim($data["6"]);
		if($data_vip){
			$vip = '1';
		}
		else{
			$vip = '0';
		}
		//print $error;
if ($error == 0) {

	if($i!=1){
		$task_to_add .= ",";
	}
	$task_to_add .= "('".$name."','".$department."','".$manager."',".$mobile.",'".$cobrand_id."','".time()."','".$CURUSER['id']."',".$comment.",".$equid.",'".$vip."')";
	if($text_err[$i]) {
		$text_err[$i]['fio'] = $name;
		$text_err[$i]['result'] = 'Добавлен';
	}
}
		else{
			$text_err[$i]['fio'] = $name;
			$text_err[$i]['result'] = 'Не добавлен';
		}


//	$data['X'] 0 - Имя; 1 - Сотовый; 2 - EQUID; 3- карта; 4 - Комментарий; 5 - учетка пользователя; 6 - признак VIP-карты	*/

		}
	 if ($task_to_add){
	sql_query ("
INSERT INTO `card_client` (`name`, `department`,`manager`,`mobile`,`id_cobrand`,`added`,`who_added`,`comment`,`equid`,`vip`)
VALUES ".$task_to_add.";") or sqlerr (__FILE__, __LINE__);
	}


}

$REL_TPL->assignByRef('num_err',$num_err);
	$REL_TPL->assignByRef('text_err',$text_err);
$REL_TPL->output("upload_cards","card");
	

?>

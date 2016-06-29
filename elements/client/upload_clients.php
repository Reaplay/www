<?php

if(!$CURUSER['add_client'])
	stderr("Ошибка","У вас нет доступа к данной странице","no");


if($_GET['type']=='upload_client'){
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
				move_uploaded_file($_FILES["attachment"]["tmp_name"], "upload/upload_clients_" . $time.".csv");
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
	$mass = file("upload/upload_clients_" . $time.".csv");
	// первую строчку пропускаем, т.к. там просто инфа
	$id_promo = (int)$_POST['promo'];

	for ($i = 1; $i < count($mass); $i++) {
		$num_err['all']++;
		$error  = 0;

		$mass[$i] = mb_convert_encoding($mass[$i], 'utf-8', "cp1251");

		$data = explode(";", $mass[$i]);
		/*	$data['X'] 0 - Имя 1 - Сотовый 2 - ДР 3 - EQUID 4 - email 5 - Комментарий 6 - учетка пользователя 7 - статус, клиент или нет	*/
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
		

		//проверяем, что номер не повторяется
		if ($mobile AND !check_unic($mobile,"client","mobile")){
			$num_err['mobile']++;
			$text_err[$i]['mobile'] = "Такой номер уже есть в базе";

			$error = 1;
		}

			// переводим ДР
		$birthday = birthday_time($data['2']);


			// проверяем email
		$email = trim($data["4"]);
		if ($email AND !validemail($email)){
			$num_err['email']++;
			$text_err[$i]['email'] = "Error";

			$email='';
		}
			//проверяем логин на существование
		if($data['6']){
			if(get_user_class() <= UC_HEAD){
				$res=sql_query("SELECT `id`,`department` FROM `users` WHERE `login`='".trim($data['6'])."' AND department = '".$CURUSER['department']."'");

			}
			elseif(get_user_class() == UC_POWER_HEAD){
				$res=sql_query("SELECT users.id,users.department FROM `users`LEFT JOIN department ON department.id = users.department WHERE `login`='".trim($data['6'])."' AND (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')");

			}
			elseif(get_user_class() == UC_ADMINISTRATOR){
				$res=sql_query("SELECT `id`,`department` FROM `users` WHERE `login`='".trim($data['6'])."';");

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

		
		$equid = sqlesc($data['3']);
		$comment = sqlesc($data['5']);

		if($data['7'] == 1){
			$status = '1';
		}
		elseif($data['7'] == 2){
			$status = '2';
		}
		else{
			$status = '0';
		}
		//print $error;
if ($error == 0) {

/*	sql_query ("
INSERT INTO `client` (`name`, `department`,`manager`,`mobile`,`email`,`added`,`who_added`,`comment`,`equid`,`status`,`birthday`)
VALUES ('" . $name . "','" . $department . "','" . $manager . "'," . $mobile . ",'" . $email . "','" . time () . "','" . $CURUSER['id'] . "'," . $comment . "," . $equid . ",'" . $status . "','" . $birthday . "');
") or sqlerr (__FILE__, __LINE__);*/
	if($task_to_add){
		$task_to_add .= ",";
	}
	$task_to_add .= "('".$name."', '".$department."', '".$manager."', ".$mobile.", '".$email."', '".time()."', '".$CURUSER['id']."', ".$comment.", ".$equid.", '".$status."', '".$birthday."', '".$id_promo."')";
	if($text_err[$i]) {
		$text_err[$i]['fio'] = $name;
		$text_err[$i]['result'] = 'Добавлен';
	}
}
		else{
			$text_err[$i]['fio'] = $name;
			$text_err[$i]['result'] = 'Не добавлен';
		}




		}
	 if ($task_to_add){
	sql_query ("
INSERT INTO `client` (`name`, `department`,`manager`,`mobile`,`email`,`added`,`who_added`,`comment`,`equid`,`status`,`birthday`,`id_promo_actio`)
VALUES ".$task_to_add.";") or sqlerr (__FILE__, __LINE__);
	}

	/*
	 * INSERT INTO `crm`.`client` (
`id` ,

)
VALUES (NULL , '2', '', '', NULL , '', '', '', '', '0', '', NULL , '0', '', '0', '0'),
	(NULL , '2', '', '', NULL , '', '', '', '', '0', '', NULL , '0', '', '0', '0');
	 *
	 * */
//print $text_err;
	//write_log("Была загрузка отчета. Файл  upload/upload_clients_" . $time.".csv.","upload_people");	
/*	print "Выгрузка доступна вот тут: <a href=\"summ_test.php?report_id=".$report_id."\">Выгрузить</a></br>";
	print "<hr>В файле строк: <b>". count($mass) ."</b><br/>";
	print "Пустых (нулевых) строк (3 штуки в пределах нормы): <b>". $null."</b><br/>";
	print "Отключенных номеров: <b>". $err."</b><br/>";
	print "В базу было добавлено новых номеров: <b>". $num."</b><br/>";
	$all = count($mass) - $null - $err - $num;
	print "Итого из <b>".count($mass)."</b> было добавлено <b>".$all."</b><br/> <hr>";

	print $content;*/
}

$row_promo = sql_query("SELECT id,name FROM promo_actio WHERE status = 0");
	while($res_promo = mysql_fetch_array($row_promo)){
		$data_promo .= '<option value="'.$res_promo['id'].'">'.$res_promo['name'].'</option>';
	}

$REL_TPL->assignByRef('num_err',$num_err);
	$REL_TPL->assignByRef('text_err',$text_err);
	$REL_TPL->assignByRef('data_promo',$data_promo);
$REL_TPL->output("upload_clients","client");
	

?>

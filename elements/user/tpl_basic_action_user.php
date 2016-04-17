<?php

/* 
формируем список дополнительных опций, таких как отделение или права опций.
если мы редактируем, то делаем доп. запросы в базу для проверки корректности запроса
*/
	if ($_GET['a']=="e") {
		// проверям ID на корретность
		if(!is_valid_id($_GET['id'])){
			stderr("Ошибка","Не хорошо так делать","no");		//запись в лог
			write_log("Попытка изменения поступаемого ID","edit_user");
		}
	// если мы редактируем пользователя, то надо получить данные для изменения
		// смотрим, не из ОО Самарский ли чел-к. Если не из него, то запрашиваем только из текущего отделения людей
		/*if($CURUSER['department'] != '1'){
			$department = "`department` = '".$CURUSER['department']."' AND";
		}*/
	if(get_user_class()<UC_POWER_HEAD){
		$department = "`department` = '".$CURUSER['department']."' AND";
	}
	elseif(get_user_class()==UC_POWER_HEAD){
		$department = "(department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."') AND";
	}
		$res=sql_query("SELECT
users.id, users.login, users.name, users.add_client, users.add_user, users.class, users.use_card, users.only_view, department.id as d_id, department.name as d_name, department.parent
FROM `users`
LEFT JOIN department ON department.id = users.department
WHERE ".$department." users.id='".$_GET['id']."';")  or sqlerr(__FILE__, __LINE__);
		if(mysql_num_rows($res) == 0){
			stderr("Ошибка","Пользователь не найден или у вас нет доступа","no");
		}

		$data_user = mysql_fetch_array($res);
	}
	// если выше рукля, то можно выбрать отделение
	if(get_user_class() == UC_POWER_HEAD){
		$res=sql_query("SELECT *  FROM `department` WHERE (id ='".$CURUSER['department']."' OR parent = '".$CURUSER['department']."');")  or sqlerr(__FILE__, __LINE__);
	
		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $data_user['d_id']){
				$select = "selected = \"selected\"";
			}
			$p_department .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
		}

	}
	elseif(get_user_class() == UC_ADMINISTRATOR){
		$res=sql_query("SELECT *  FROM `department`;")  or sqlerr(__FILE__, __LINE__);

		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $data_user['d_id']){
				$select = "selected = \"selected\"";
			}
			$p_department .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
		}
	}


	function select_class($class_user,$compare_class){
		if($class_user == $compare_class){
			return "selected = \"selected\"";
		}
	}

	//формируем уровень какого доступа может ставить
	$p_class .='<option value ="0" '.select_class($data_user['class'],0).'>Пользователь</option>';
	if(get_user_class() >= UC_HEAD){
		$p_class .='<option value ="1" '.select_class($data_user['class'],1).'>Расширенный пользователь</option>';
	}
	if(get_user_class() >= UC_POWER_HEAD){
		$p_class .='<option value ="2" '.select_class($data_user['class'],2).'>Руководитель отделения</option>';
	}
	if(get_user_class() == UC_ADMINISTRATOR){
		$p_class .='<option value ="3" '.select_class($data_user['class'],3).'>Руководитель направления</option>';
		$p_class .='<option value ="5" '.select_class($data_user['class'],5).'>Администратор</option>';
	}

	
	$REL_TPL->assignByRef('p_department',$p_department);
	$REL_TPL->assignByRef('p_class',$p_class);
	$REL_TPL->assignByRef('data_user',$data_user);


$REL_TPL->output("tpl_basic_action_user","user");

?>
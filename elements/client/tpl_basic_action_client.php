<?php

if(!$CURUSER['add_client'])
	stderr("Ошибка","У вас нет доступа к данной странице","no");

if ($_GET['a']=="e") {
	if(!is_valid_id($_GET['id'])){
		stderr("Ошибка","Некорректный ID клиента","no");		//запись в лог
		write_log("Попытка изменения поступаемого ID","edit_client");
	}
	//добавялем условия выборки клиента,что бы не каждый мож редактировать, а только те, кому положено
	
	//если пользователь - только того, кто за ним и в его отделении
	/*if(get_user_class() < UC_HEAD){
		$add_query = "AND client.manager ='".$CURUSER['id']."' AND client.department ='".$CURUSER['department']."'";
		
	}*/
	//если рукль, то те, кто к ним привязан
	if(get_user_class() <= UC_HEAD){
		$add_query = "AND client.department ='".$CURUSER['department']."'";
	}
	//а выше рукля - всех могут
	
	$res=sql_query("SELECT client.*, users.name as u_name, users.id as u_id  FROM `client`  LEFT JOIN users ON users.id = client.manager  WHERE  client.id = '".$_GET['id']."' ".$add_query.";")  or sqlerr(__FILE__, __LINE__);


	if(mysql_num_rows($res) == 0){
		stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
	}

	$data_client = mysql_fetch_array($res);
	$action	="edit";
	if($data_client['birthday'] !=0) {
		$data_client['birthday'] = date ("d-m-Y", $data_client['birthday']);
	}
	else
		$data_client['birthday'] = "";
	//$gender = $data_client['gender'];
	//$REL_TPL->assignByRef('gender',$gender);
	$REL_TPL->assignByRef('action',$action);
	$REL_TPL->assignByRef('id',$_GET['id']);
}
	
	
	// если рукль или выше, то можно сменить менеджера (и соответственно с ним меняется привязка к отделению)
	if(get_user_class() >= UC_HEAD){
		if(get_user_class() == UC_HEAD){
			$dep = "WHERE department = ".$CURUSER['department'];
		}
		elseif(get_user_class() == UC_POWER_HEAD){
			$dep = "WHERE department.parent = ".$CURUSER['department'];
		}
		$res=sql_query("SELECT users.id,users.name, department.name as d_name, department.parent FROM  `users` LEFT JOIN department ON department.id = users.department ".$dep.";")  or sqlerr(__FILE__, __LINE__);

		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $data_client['u_id']){
				$select = "selected = \"selected\"";
			}
			$manager .= " <option ".$select." value = ".$row['id'].">".$row['name']." (".$row['d_name'].")</option>";
		}
	}
	


	
	
	$REL_TPL->assignByRef('manager',$manager);
	$REL_TPL->assignByRef('data_client',$data_client);
	//$REL_TPL->assignByRef('p_class',$p_class);
	$REL_TPL->output("tpl_basic_action_client","client");
	


	


?>

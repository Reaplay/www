<?php

if(!is_valid_id($_GET['id'])){
	stderr("Ошибка","Некоректный ID клиента","no");		//запись в лог
}

//если рукль, то те, кто к ним привязан
	if(get_user_class() <= UC_HEAD){
		$add_query = "AND client.department ='".$CURUSER['department']."'";
	}
	elseif(get_user_class() == UC_POWER_HEAD){
		$add_query = "AND (department.parent ='".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
	}
//а выше рукля - всех могут
	
$res=sql_query("
	SELECT client.*, users.name as u_name, users.id as u_id, department.name as d_name
	FROM `client`  
	LEFT JOIN users ON users.id = client.manager  
	LEFT JOIN department ON department.id = client.department  
	WHERE  client.delete = '0' AND client.id = '".$_GET['id']."' ".$add_query.";")
	or sqlerr(__FILE__, __LINE__);


if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
}
$data_client = mysql_fetch_array($res);

	
$res=sql_query("
SELECT callback.added,callback.next_call, callback.id_product, callback.type_contact, callback.comment, users.name as u_name, result_call.text as rc_name
FROM `callback`
LEFT JOIN users ON users.id = callback.id_user  
LEFT JOIN result_call ON result_call.id = callback.id_result
WHERE id_client = '".$_GET['id']."'
ORDER BY `added` DESC
LIMIT 0,15
;") 
or sqlerr(__FILE__, __LINE__);
$i=0;
while ($row = mysql_fetch_array($res)){
	$data_callback[$i]=$row;
	$data_callback[$i]['added']=date("d-m-Y",$row['added']);
		if ($row['next_call']){
		$data_callback[$i]['next_call']=date("d-m-Y",$row['next_call']);
	}
	else
		$data_callback[$i]['next_call']="N/A";
	
	$product= "";
	if ($data_callback[$i]['id_product']){
		$a_product  = explode(",",$data_callback[$i]['id_product']);
		foreach($a_product as $value){
			$subres = sql_query("SELECT name FROM product WHERE id = '".$value."'") or sqlerr(__FILE__, __LINE__);
			$subrow=mysql_fetch_array($subres);
			$product .= $subrow['name'].", ";
		}
	}
	$data_callback[$i]['product']=$product;
	$i++;
}

/*if($CURUSER['department'] != '1'){
	$department = "`department` = '".$CURUSER['department']."' AND";
}

$res=sql_query("SELECT users.id, users.name as u_name, department.name as d_name FROM `users` LEFT JOIN department ON department.id = users.department  WHERE ".$department." users.banned = '0';")  or sqlerr(__FILE__, __LINE__);

while ($data_mgr = mysql_fetch_array($res)) {
			$select = "";
			if ($data_mgr['id'] == $data_client['u_id']){
				$select = "selected = \"selected\"";
			}
			$mgr .= " <option ".$select." value = ".$data_mgr['id'].">".$data_mgr['u_name']." (".$data_mgr['d_name'].")</option>";
		}
*/
 //$data_callback['0']['added']=mkprettytime($data_callback['0']['added']);

	
	// если рукль или выше, то можно сменить менеджера (и соответственно с ним меняется привязка к отделению)
	if(get_user_class() >= UC_POWER_USER){
		if(get_user_class() <= UC_HEAD){
			$dep = "WHERE department = ".$CURUSER['department'];
		}
		elseif(get_user_class() == UC_POWER_HEAD){
			$dep = "WHERE (department.parent = '".$CURUSER['department']."' OR department.id = '".$CURUSER['department']."')";
		}
		$res=sql_query("SELECT users.id,users.name, department.name as d_name FROM  `users` LEFT JOIN department ON department.id = users.department ".$dep.";")  or sqlerr(__FILE__, __LINE__);
	
		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $data_client['u_id']){
				$select = "selected = \"selected\"";
			}
			$data_manager .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
		}
	}
	
	//$action	="edit";
	if($data_client['birthday'] !=0) {
		$data_client['birthday'] = date ("d-m-Y", $data_client['birthday']);
	}
	$gender = $data_client['gender'];
	
	
	$REL_TPL->assignByRef('data_manager',$data_manager);
	$REL_TPL->assignByRef('gender',$gender);
	
	$REL_TPL->assignByRef('id',$_GET['id']);
	$REL_TPL->assignByRef('data_client',$data_client);
	$REL_TPL->assignByRef('data_callback',$data_callback);
	//$REL_TPL->assignByRef('data_mgr',$mgr);
	
	$view = "view";
	$REL_TPL->assignByRef("t",$view);
	
	$REL_TPL->output("tpl_view_client","client");
	$REL_TPL->output("view_client","client");
	

	
	//это не надо
//	$template = "edit_user_result";
//die();

	


?>

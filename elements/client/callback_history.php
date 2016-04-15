<?php

$page = (int) $_GET["page"];

if ($page < 2){
	$start_page = 0;
	$page = 1;
}
else {
	$start_page = ($page - 1)*$REL_CONFIG['per_page_callback'];
}
$cpp = $REL_CONFIG['per_page_callback'];
$limit = "LIMIT ".$start_page." , ".$cpp;


if(!is_valid_id($_GET['id'])){
	stderr("Ошибка","Некоректный ID клиента","no");		//запись в лог
}
/*if(get_user_class() < UC_HEAD){
	$add_query = "AND client.manager ='".$CURUSER['id']."' AND client.department ='".$CURUSER['department']."'";
}*/
//если рукль, то те, кто к ним привязан
if(get_user_class() <= UC_HEAD){
	$add_query = "AND client.department ='".$CURUSER['department']."'";
}
elseif(get_user_class() > UC_HEAD){
	$add_query = "";
}

//а выше рукля - всех могут
	
$res=sql_query("
	SELECT client.id, department.parent
	FROM `client`  
	LEFT JOIN department ON department.id = client.department 
	WHERE  client.id = '".$_GET['id']."' ".$add_query.";")  
	or sqlerr(__FILE__, __LINE__);

if(mysql_num_rows($res) == 0){
	stderr("Ошибка","Клиент не найден или у вас нет доступа","no");
}
$data_client = mysql_fetch_array($res);

	
$res=sql_query("
SELECT callback.id,callback.added,callback.next_call, callback.id_product, callback.type_contact, callback.comment,users.name as u_name, result_call.text as rc_name
FROM `callback`
LEFT JOIN users ON users.id = callback.id_user  
LEFT JOIN result_call ON result_call.id = callback.id_result
WHERE  id_client = '".$_GET['id']."'
ORDER BY `added` DESC
".$limit."
;") 
or sqlerr(__FILE__, __LINE__);
$i=0;

while ($row = mysql_fetch_array($res)){
	$data_callback[$i]=$row;
	$data_callback[$i]['added']=date("d-m-Y",$row['added']);
	if($row['next_call']){
		$data_callback[$i]['next_call']=date("d-m-Y",$row['next_call']);
	}
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









//необходима оптимизация 
// узнаем сколько клиентов можно отобразить, что бы правильно сформировать переключатель страниц
$res = sql_query("SELECT SUM(1) FROM callback WHERE id_client='".$_GET['id']."';") or sqlerr(__FILE__,__LINE__);
$row = mysql_fetch_array($res);
//всего записей
$count = $row[0];
//всего страниц
$max_page = ceil($count / $cpp);
//print $cpp;



//$REL_TPL->assignByRef('js_add',$js_add);
$REL_TPL->assignByRef('cpp',$cpp);
$REL_TPL->assignByRef('page',$page);
$REL_TPL->assignByRef('add_link',$add_link);
$REL_TPL->assignByRef('max_page',$max_page);

$REL_TPL->assignByRef('id',$_GET['id']);
$REL_TPL->assignByRef('data_client',$data_client);
$REL_TPL->assignByRef('data_callback',$data_callback);

$t = "history";
$REL_TPL->assignByRef("t",$t);

$REL_TPL->output("tpl_view_client","client");
$REL_TPL->output("view_callback_history","client");




?>

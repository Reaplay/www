<?php


require "include/connect.php";

dbconn ();

loggedinorreturn ();

$id =(int)$_GET ["id"];

if(!is_valid_id($id)) 
	$id = $CURUSER['id'];


$r = @sql_query ( "SELECT * FROM users WHERE id=$id" ) or sqlerr ( __FILE__, __LINE__ );
$user = mysql_fetch_array ( $r ) or bark ( "Нет пользователя с таким ID $id." );
if ($user["banned"])
    stderr ("Ошибка","Этот пользователь был заблокирован" );


$REL_TPL->stdhead("Просмотр пользователя");
$REL_TPL->output("userdetails","basic");
$REL_TPL->stdfoot();
?>

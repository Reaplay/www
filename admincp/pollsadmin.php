<?php

/**
 * Polls admin panel

 */


if (!isset($_GET['action']))  {
	$REL_TPL->stdhead("Опросы");


	$pollsrow = sql_query("SELECT * FROM polls ORDER BY id DESC");
	$data_poll = mysql_fetch_array($pollsrow);

$REL_TPL->assignByRef('data_poll',$data_poll);
	$REL_TPL->output("pollsadmin","admincp");

	$REL_TPL->stdfoot();
	// if (!is_valid_id($_GET['pollid'])) stderr($REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id'));

	// $pollid = $_GET["pollid"];

}
elseif ($_GET['action'] == 'add') {

	$REL_TPL->stdhead("Добавление опроса");
	$REL_TPL->output("pollsadmin_add","admincp");
	$REL_TPL->stdfoot();
}
elseif ($_GET['action'] == 'add2') {
	if (get_user_class() < ADMINISTRATOR) stderr($REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('access_denied'));

	if (!isset($_POST['howq'])) stderr($REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id'));
	$howq = intval($_POST['howq']);

	$REL_TPL->stdhead("Добавление опроса Шаг 2");

	print('<table width="100%" border="1"><form name="add2" action="'.$REL_SEO->make_link('pollsadmin','action','saveadd').'" method="post">
   <tr><td>Вопрос:</td><td><input type="text" name="question"></td></tr>
   <tr><td>Продолжительность опроса:</td><td><input type="text" name="exp" size="2"> дней | 0 - бесконечно</td></tr>
   <tr><td><input type="hidden" name="type" value="'.$type.'"></td></tr>
   ');

	print('<tr><td>Публичный?</td><td><input type="checkbox" name="public" value="1"> (пользователи смогут видеть, кто и как голосовал)</td></tr>');


	for ($i=1;$i<=$howq;$i++)
	print('<tr><td>Опция '.$i.':</td><td><input type="text" name="option['.$i.']"></td></tr>');
	print('<tr><td><input type="submit" value="Создать опрос"></td></tr></table>');
	$REL_TPL->stdfoot();
}

elseif (($_GET['action'] == 'saveadd') && ($_SERVER['REQUEST_METHOD'] == 'POST')) {

	if (!is_numeric($_POST['exp'])) stderr($REL_LANG->say_by_key('error'),$REL_LANG->say_by_key('invalid_id'));
	if ($_POST['exp'] != 0)
	$exp = time()+86400*intval($_POST['exp']);
	else $exp = 'NULL';
	if ($_POST['public']) $public = 1; else $public = 0;


	$question = htmlspecialchars(trim($_POST['question']));


	sql_query("INSERT INTO polls (question,start,exp,public) VALUES (".sqlesc($question).",".time().",".$exp.",'".$public."')");
	$pollid = mysql_insert_id();

	if (!$pollid) die('MySQL error');

	foreach($_POST['option'] as $key => $option) {
		$option = htmlspecialchars(trim($option));
		sql_query("INSERT INTO polls_structure (pollid,value) VALUES ($pollid,".sqlesc($option).")");

		$REL_CACHE->clearGroupCache("block-polls");
	}

	safe_redirect($REL_SEO->make_link('polloverview','id',$pollid));
}

elseif ($_GET['action'] == 'delete') {
	if (!is_valid_id($_GET['id'])) stderr($REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id'));
	$id = $_GET['id'];

	sql_query("DELETE FROM polls WHERE id=$id");
	sql_query("DELETE FROM polls_structure WHERE pollid=$id");
	sql_query("DELETE FROM polls_votes WHERE pid=$id");
	sql_query("DELETE FROM comments WHERE toid=$id AND type='poll'") or sqlerr(__FILE__, __LINE__);
	sql_query("DELETE FROM notifs WHERE type='pollcomments' AND checkid=$id") or sqlerr(__FILE__, __LINE__);


	$REL_CACHE->clearGroupCache("block-polls");
	safe_redirect($REL_SEO->make_link('pollsadmin'));
}

elseif ($_GET['action'] == 'edit') {
	if (!is_valid_id($_GET['id'])) stderr($REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id'));
	$id = $_GET['id'];
	$REL_TPL->stdhead("Редактирование опроса");

	$pollrow = sql_query("SELECT id,question,exp,public FROM polls WHERE id=$id");
	$pollres = mysql_fetch_array($pollrow);

	print('<table width="100%" border="1"><form action="'.$REL_SEO->make_link('pollsadmin','action','saveedit','id',$id).'" method="post"><tr><td>Вопрос:</td><td><input type="text" name="question" value="'.$pollres['question'].'"></td><tr><td>Истекает через:</td><td><input type="text" name="exp" value="'.(!is_null($pollres['exp'])?round(($pollres['exp']-time())/86400):"0").'" size="2"> дней 0 - бесконечно</td>');

	print('<tr><td>Публичный?</td><td><input type="checkbox" name="public" value="1" '.(($pollres['public'])?"checked":"")."></td></tr>");
	$srow = sql_query("SELECT id,value FROM polls_structure WHERE pollid=$id");
	$i = 0;
	while ($sres = mysql_fetch_array($srow)) {
		$i++;
		print("<tr><td>Опция $i:</td><td><input type=\"text\" name=\"option[".$sres['id']."]\" value=\"".$sres['value']."\"></td></tr>");
	}
	print('<tr><td><input type="hidden" name="type" value="'.$pollres['type'].'"><input type="submit" value="Отредактировать"</td></tr></form></table>');
	$REL_TPL->stdfoot();
}

elseif (($_GET['action'] == 'saveedit') && ($_SERVER['REQUEST_METHOD'] == 'POST')) {


	if ((!is_numeric($_POST['exp'])) || (!is_valid_id($_GET['id']))) stderr ($REL_LANG->say_by_key('error'),$REL_LANG->say_by_key('invalid_id'));
	$id = $_GET['id'];

	if ($_POST['exp'] != 0)
	$exp = time()+86400*intval($_POST['exp']);
	else $exp = 'NULL';

	if ($_POST['public']) $public = 1; else $public = 0;


	$question = htmlspecialchars(trim($_POST['question']));

	foreach($_POST['option'] as $key => $option) {
		$option = htmlspecialchars(trim($option));
		sql_query("UPDATE polls_structure SET value = ".sqlesc($option)." WHERE id=$key") or die(mysql_error());

	}
	sql_query("UPDATE polls SET question=".sqlesc($question)." , exp=$exp, public='$public' WHERE id=$id") or die(mysql_error());


	$REL_CACHE->clearGroupCache("block-polls");
	safe_redirect($REL_SEO->make_link('polloverview','id',$id));
}

else 
	stderr("Ошибка", "В доступе отказано");
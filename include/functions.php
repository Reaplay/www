<?php

/*
Все это ужасно. Это жуткий быдлокод с велосипедами и прочим ужасом.
Мне заранее тебя жаль. И прими мои извинения, это по-идее никто не должен был увидеть кроме меня. 
Делалось же чисто в качестве теста-эксперимента для Самары...
*/

if (!defined("IN_SITE")) die("Direct access to this page not allowed");
define ("BETA", true);
define ("BETA_NOTICE", " This isn't complete release of source!");
define("RELVERSION","0.2.3.1");

/**
 * Checks that page is loading with ajax and defines boolean constant REL_AJAX
 */
function safe_redirect($url,$timeout = 0) {
	$url = trim($url);
	/*if (REL_AJAX || ob_get_length())*/ print('
    <script type="text/javascript" language="javascript">
    function Redirect() {
      location.href = "'.addslashes($url).'";
      }
      setTimeout(\'Redirect()\','.($timeout*1000).');
    </script>
');
	//else header("Refresh: $timeout; url=$url");
	return;
}
function ajaxcheck() {
	if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') define ("REL_AJAX",true); else define("REL_AJAX",false);
	return;

}

function dbconn($lightmode = false) {
	global $mysql_host, $mysql_user, $mysql_pass, $mysql_db, $mysql_charset, $REL_CONFIG, $REL_CACHE, $CURUSER, $REL_DB, $REL_SEO, $REL_CRON, $REL_TPL;

	/* @var database object */
	require_once(ROOT_PATH . 'classes/database/database.class.php');
	$REL_DB = new REL_DB($mysql_host, $mysql_user, $mysql_pass, $mysql_db, $mysql_charset);

	// configcache init

	/* @var array Array of releaser's configuration */
	$REL_CONFIG=$REL_CACHE->get('system','config');
	//$REL_CONFIG=false;
	if ($REL_CONFIG===false) {

		$REL_CONFIG = array();

		$cacherow = sql_query("SELECT * FROM cache_stats");

		while ($cacheres = mysql_fetch_array($cacherow))
		$REL_CONFIG[$cacheres['cache_name']] = $cacheres['cache_value'];

		$REL_CACHE->set('system','config',$REL_CONFIG);
	}

	//configcache init end
	/*$cronrow = sql_query("SELECT * FROM cron");
	
	while ($cronres = mysql_fetch_array($cronrow))
	$REL_CRON[$cronres['cron_name']] = $cronres['cron_value'];
*/
	/* @var object links parser/adder/changer for seo */
	require_once(ROOT_PATH . 'classes/seo/seo.class.php');
	$REL_SEO = new REL_SEO();
	if (!$lightmode) 
		userlogin();

	require_once(ROOT_PATH . 'classes/template/template.class.php');
	/* @var REL_TPL template class */
	$REL_TPL = new REL_TPL($REL_CONFIG);

	gzip();

	// INCLUDE SECURITY BACK-END
	//require_once(ROOT_PATH . 'include/csite.php');
	/**
	 * Во время написания этого проекта, было выпито более 40 литров пива, 20 литров виски и скурено более 60 кальянов. Не считая съеденной еды.
   
	 */
	//define ("CRM_VERSION", ($REL_CONFIG['yourcopy']?str_replace("{datenow}",date("Y"),$REL_CONFIG['yourcopy']).". ":"")."<br />Powered by IT Samara ".RELVERSION." &copy; 2015-".date("Y").".");
	define ("CRM_VERSION", "&copy; 2015-".date("Y")." Created by IT Samara (v".RELVERSION.") .");
	
	return;
}

function sql_query($query) {
	global $REL_DB;
	return $REL_DB->query($query);
}

function userlogin() {
	global  $REL_CONFIG, $REL_CACHE,  $CURUSER, $REL_CRON;
	unset($GLOBALS["CURUSER"]);
	
	$ip = getip();

	if ($REL_CONFIG['use_ipbans']) {

		$maskres = $REL_CACHE->get('bans', 'query');
		if ($maskres ===false){
			$res = sql_query("SELECT mask FROM bans");
			$maskres = array();

			while (list($mask) = mysql_fetch_array($res))
			$maskres[] = $mask;

			$REL_CACHE->set('bans', 'query', $maskres);
		}

		$BAN = new IPAddressSubnetSniffer($maskres);
		if ($BAN->ip_is_allowed($ip) ) {
			//write_log("$ip attempted to access tracker",'bans');
			die("Sorry, you (or your subnet) are banned by IP and MAC addresses!");

		}

	}

	if (empty($_COOKIE["uid"]) || empty($_COOKIE["pass"])) {
	//	$REL_CONFIG['ss_uri'] = $REL_CONFIG['default_theme'];
		user_session();
		return;
	}

	if (!is_valid_id($_COOKIE["uid"]) || strlen($_COOKIE["pass"]) != 32) {
		die("FATAL ERROR: Cokie ID invalid or cookie pass hash problem.");

	}
	$id = (int) $_COOKIE["uid"];
	$res = sql_query("SELECT users.* FROM users WHERE id = $id");// or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	if (!$row) {
	//	$REL_CONFIG['ss_uri'] = $REL_CONFIG['default_theme'];
		user_session();
		return;
	} elseif (($row['enable'] != 1) && !defined("IN_CONTACT")) {
	//	$REL_CONFIG['ss_uri'] = $row['uri'];
		headers(true);
		die("Аккаунт заблокирован. Причина: ".$row['dis_reason']."<br> Для разблокировки свяжитесь со своим руководителем или ИТ отделом");

	}

	$sec = hash_pad($row["secret"]);
	if ($_COOKIE["pass"] != md5($row["passhash"].COOKIE_SECRET)) {
	//	$REL_CONFIG['ss_uri'] = $row['uri'];
		$pscheck = htmlspecialchars(trim((string)$_COOKIE['pass']));
		//$res = mysql_fetch_assoc(sql_query("SELECT id,class,username FROM users WHERE passhash=".sqlesc($pscheck)));
		//if (!$res) unset($res); else $res = "of <a href=\"userdetails.php?id=\"{$res['id']}\">".get_user_class_color($res['class'],$res['username'])."</a>";
		write_log(getip()." with cookie ID = $id <font color=\"red\">with passhash ".$pscheck." -> PASSHASH CHECKSUM FAILED!</font>",'security');
		user_session();
		return;
	}
//	if (!$REL_CONFIG['ss_uri']) $REL_CONFIG['ss_uri'] = $row['uri'];

	$updateset = array();


	if ($ip != $row['ip'])
	$updateset[] = 'ip = '. sqlesc($ip);
	$updateset[] = 'last_access = ' . time();

	if (count($updateset))
	sql_query("UPDATE LOW_PRIORITY users SET ".implode(", ", $updateset)." WHERE id=" . $row["id"]);// or die(mysql_error());
	$row['ip'] = $ip;

	//таймзона на дефолт
	$row['timezone'] = $REL_CONFIG['site_timezone'];


	if (isset($_COOKIE['override_class'])) {
		$override = (int)$_COOKIE['override_class'];
		if ($row['class'] >= UC_ADMINISTRATOR && $override<$row['class'] && $override>=0)
		$row['class'] = $override;
	}
	/* @var array Not full yet array of variables of current user
	 * @see $REL_TPL->stdhead()
	 */
	$GLOBALS["CURUSER"] = $row;

	user_session();

	// $_SESSION = $CURUSER;

}

function getip() {
	$ip = false;
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		$ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip)
		{
			array_unshift($ips, $ip);
			$ip = false;
		}
		for($i = 0; $i < count($ips); $i++)
		{
			if(!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i]))
			{
				if(version_compare(phpversion(), "5.0.0", ">="))
				{
					if(ip2long($ips[$i]) != false)
					{
						$ip = $ips[$i];
						break;
					}
				}
				else
				{
					if(ip2long($ips[$i]) != - 1)
					{
						$ip = $ips[$i];
						break;
					}
				}
			}
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}
function user_session() {
	global $CURUSER, $REL_CONFIG, $REL_CRON;

	$ip = getip();
	$url = htmlspecialchars($_SERVER['REQUEST_URI']);

	if (!$CURUSER) {
		$uid = -1;
		$username = '';
		$class = -1;
	} else {
		$uid = $CURUSER['id'];
		$username = $CURUSER['name'];
		$class = $CURUSER['class'];
	}

	$past = time() - 300;
	$sid = session_id();
	//	$where = array();
	$updateset = array();
	if ($sid) {
		/*	$where[] = "sid = ".sqlesc($sid);
		 elseif ($uid)
		 $where[] = "uid = $uid";
		 else
		 $where[] = "ip = ".sqlesc($ip);*/
		//sql_query("DELETE FROM sessions WHERE ".implode(" AND ", $where));
		$ctime = time();
		$agent = htmlspecialchars($_SERVER["HTTP_USER_AGENT"]);
		$updateset[] = "sid = ".sqlesc($sid);
		$uid = (int)$uid;
		$updateset[] = "uid = ".$uid;
		$updateset[] = "username = ".sqlesc($username);
		$class = (int)$class;
		$updateset[] = "class = ".$class;
		$updateset[] = "ip = ".sqlesc($ip);
		$updateset[] = "time = ".$ctime;
		$updateset[] = "url = ".sqlesc($url);
		$updateset[] = "useragent = ".sqlesc($agent);
		if (count($updateset))
		//	sql_query("UPDATE sessions SET ".implode(", ", $updateset)." WHERE ".implode(" AND ", $where)) or sqlerr(__FILE__,__LINE__);
		sql_query("INSERT INTO sessions (sid, uid, username, class, ip, time, url, useragent) VALUES (".implode(", ", array_map("sqlesc", array($sid, $uid, $username, $class, $ip, $ctime, $url, $agent))).") ON DUPLICATE KEY UPDATE ".implode(", ", $updateset)) or sqlerr(__FILE__,__LINE__);
	}
	if ($CURUSER) {

		$CURUSER['access'] = get_user_class();

		$allowed_types=array('unread', 'inbox', 'outbox');

		$secs_system = $REL_CONFIG['pm_delete_sys_days']*86400; // Количество дней
		$dt_system = time() - $secs_system; // Сегодня минус количество дней
		//$dt_system = 0;
		$secs_all = $REL_CONFIG['pm_delete_user_days']*86400; // Количество дней
		$dt_all = time() - $secs_all; // Сегодня минус количество дней
		//$dt_all = 0;
		foreach ($allowed_types as $type) {
			if ($type=='unread'){
				$addition = "location=1 AND receiver={$CURUSER['id']} AND unread=1 AND IF(archived_receiver=1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all))";
				$table='messages';
				$noadd=true;
			}
			elseif ($type=='inbox'){
				$addition = "location=1 AND receiver={$CURUSER['id']} AND IF(archived_receiver=1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all))";
				$table='messages';
				$noadd=true;
			}
			elseif ($type=='outbox'){
				$addition = "saved=1 AND sender={$CURUSER['id']} AND IF(archived_receiver<>1, 1=1, IF(sender=0,added>$dt_system,added>$dt_all))";
				$table = 'messages';
				$noadd=true;
			}
			elseif ($type=='reports')
				$noadd=true;


			$noselect = @implode(',',@array_map("intval",$_SESSION['visited_'.$type]));

			$string = ($noselect?$sel_id.'id NOT IN ('.$noselect.') AND ':'').($noadd?'':"{$sel_id}added>".$CURUSER['last_login']).$addition;

			$sql_query[]="(SELECT GROUP_CONCAT({$sel_id}id) FROM ".($table?$table:$type).($string?" WHERE $string":'').') AS '.$type;
			unset($addition);
			unset($sel_id);
			unset($table);
			unset($noadd);
			unset($string);
			unset($noselect);
		}
		//if (get_user_class()==UC_ADMINISTRATOR&&$_GET['debug']) {print '<pre>'; print_r($_SESSION); die();}
		if ($sql_query) {
			$sql_query = "SELECT ".implode(', ', $sql_query);

			//die($sql_query);
			$notifysql = sql_query($sql_query);
			$notifs = mysql_fetch_assoc($notifysql);
			foreach ($notifs as $type => $value) if ($value) $CURUSER[$type] = explode(',', $value);

			//$notifs = array_combine($allowed_types,explode(',',$notifs));
			//foreach ($notifs as $name => $value) $CURUSER[$name] = $value;
		}

	}
	return;
}
function sqlesc($value) {
	// Quote if not a number or a numeric string
	if (!is_numeric($value)) {
		$value = "'" . mysql_real_escape_string((string)$value) . "'";
	}
	return $value;
}

function sqlerr($file = '', $line = '') {
	global $queries, $CURUSER, $REL_SEO;
	$err = mysql_error();

	$res = sql_query("SELECT id FROM users WHERE class=".UC_ADMINISTRATOR);
	while (list($id) = mysql_fetch_array($res))
		write_sys_msg($id,'Ошибка MySQL: '.$err.'<br />Файл: '.$file.'<br />Строка: '.$line.'<br />Ссылка: '.$_SERVER['REQUEST_URI'].'<br />Пользователь: <a href="'.$REL_SEO->make_link('userdetails','id',$CURUSER['id'],'name',$CURUSER['name']).'">'.get_user_class_color($CURUSER['class'],$CURUSER['name'].'</a><br/>GET: '.print_r($_GET,true).'<br />POST:'.print_r($_POST,true)),'MySQL error detected!');
	/*$text = ("<table border=\"0\" bgcolor=\"blue\" align=\"left\" cellspacing=\"0\" cellpadding=\"10\" style=\"background: blue\">" .
	"<tr><td class=\"embedded\"><font color=\"white\"><h1>Ошибка в SQL</h1>\n" .
	"<b>Ответ от сервера MySQL: " . $err . ($file != '' && $line != '' ? "<p>в $file, линия $line</p>" : "") . "<p>Запрос номер $queries.</p></b></font></td></tr></table>");*/
	write_log("<a href=\"".$REL_SEO->make_link('userdetails','id',$CURUSER['id'],'name',$CURUSER['name'])."\">".get_user_class_color($CURUSER['class'],$CURUSER['name'])."</a> SQL ERROR: $text</font>",'sql_errors');
	stderr("Ошибка выполнения."," Во время выполения скрипта произошла ошибка. Администратору отправлено сообщение. Можете на всякий случай его дополнительно оповестить.","no");
	return;
}
/*
function write_log($text, $type = "site") {
	global $CURUSER;
	if (!$CURUSER['id']) $id =0; else $id=$CURUSER['id'];

	//
	$type = sqlesc($type);
	$text = sqlesc($text);
	$added = time();
	sql_query("INSERT INTO sitelog (added, userid, txt, type) VALUES($added, $id, $text, $type)") or sqlerr(__FILE__,__LINE__);
	return;
}
*/
function write_log($text, $module = "site",$action="other") {
	global $CURUSER;
	if (!$CURUSER['id']) 
		$id =0; 
	else 
		$id=$CURUSER['id'];

	//
	$module = sqlesc($module);
	$action = sqlesc($action);
	$text = sqlesc($text);
	$added = time();


	sql_query("INSERT INTO sitelog (added, userid, txt, `module`, `action`) VALUES($added, $id, $text, $module,$action)") or sqlerr(__FILE__,__LINE__);

	return;
}
function write_sys_msg($receiver,$msg,$subject) {
	sql_query("INSERT INTO messages (receiver, added, msg, subject) VALUES($receiver, '" . time() . "', ".sqlesc($msg).", ".sqlesc($subject).")");// or sqlerr(__FILE__, __LINE__);
	return;
}


function gzip() {
	global $REL_CONFIG;
	if (@extension_loaded('zlib') && @ini_get('zlib.output_compression') != '1' && @ini_get('output_handler') != 'ob_gzhandler' && $REL_CONFIG['use_gzip']) {
		@ob_start('ob_gzhandler');
	} else @ob_start();
	return;
}
function get_user_class() {
	global $CURUSER;

	return is_valid_user_class($CURUSER['class'])?$CURUSER['class']:-1;
	
	
}

function headers($ajax=false) {
	global $REL_LANG;
	header("X-Powered-By: crm ".RELVERSION);
	header("Cache-Control: no-cache, must-revalidate, max-age=0");
	//header("Expires:" . gmdate("D, d M Y H:i:s") . " GMT");
	header("Expires: 0");
	header("Pragma: no-cache");
	if ($ajax)   header ("Content-Type: text/html; charset=utf-8");
	return;
}

function generate_post_javascript() {
	if (defined("WYSIWYG_REQUIRED") && !defined("NO_WYSIWYG"))
	print '<script language="javascript" type="text/javascript">
	$(document).ready(
		function(){
			wysiwygjs();
		});
</script>';
}

function close_sessions() {
	// close old sessions
	$secs = 1 * 3600;
	$time = time();
	$dt = $time - $secs;
	$updates = sql_query("SELECT uid, time FROM sessions WHERE uid<>-1 AND time < $dt") or sqlerr(__FILE__,__LINE__);
	while ($upd = mysql_fetch_assoc($updates)) {
		sql_query("UPDATE users SET last_login={$upd['time']} WHERE id={$upd['uid']}") or sqlerr(__FILE__,__LINE__);
	}
	sql_query("DELETE FROM sessions WHERE time < $dt") or sqlerr(__FILE__,__LINE__);
}

function run_cronjobs() {
	global $REL_CRON,$REL_SEO;
	if ($REL_CRON['cron_is_native']) {
		$time = time();
		if (((($time-$REL_CRON['last_cleanup'])>$REL_CRON['autoclean_interval']) && !$REL_CRON['in_cleanup'])) print '<img width="0px" height="0px" alt="" title="" src="'.$REL_SEO->make_link('cleanup').'"/>';
		if (!$REL_CRON['remotecheck_disabled'] && (($time-$REL_CRON['last_remotecheck'])>$REL_CRON['remotecheck_interval'])) print '<img width="0px" height="0px" alt="" title="" src="'.$REL_SEO->make_link('remote_check').'"/>';
	}
}

function debug() {
	global $CURUSER, $REL_CONFIG, $REL_CRON, $REL_SEO,$REL_TPL, $REL_DB, $tstart;

	if (($REL_CONFIG['debug_mode']) && ($CURUSER['class'] >= UC_ADMINISTRATOR)) {
		//var_dump($REL_DB->query);
		$REL_TPL->assignByRef('query',$REL_DB->query);
		$REL_TPL->assignByRef('tstart',$tstart);
		$seconds = (microtime(true) - $tstart);
		$display_debug=true;

		$phptime = 		$seconds - $REL_DB->query[0]['seconds'];
		$query_time = 	$REL_DB->query[0]['seconds'];
		$percentphp = 	number_format(($phptime/$seconds) * 100, 2);
		$percentsql = 	number_format(($query_time/$seconds) * 100, 2);
		$online = mysql_fetch_row(sql_query("SELECT SUM(1) FROM sessions"));
		$REL_TPL->assignByRef('REL_CRON',$REL_CRON);
		$REL_TPL->assign('PAGE_GENERATED',((get_user_class()>=UC_ADMINISTRATOR)?sprintf("Страница сгенерирована за %f секунд. Выполнено %d запросов (%s%% PHP / %s%% MySQL)", $seconds, count($REL_DB->query), $percentphp, $percentsql).". Сейчас на сайте ".$online['0']." человек(-а) ":''));
	} 
	else 
		$display_debug=false;
	$REL_TPL->assign('DEBUG',$display_debug);
	//var_dump($display_debug);
}

function logoutcookie() {
	setcookie("uid", "", 0x7fffffff);
	setcookie("pass", "", 0x7fffffff);
	setcookie("lang", "", 0x7fffffff);
	unset($_SESSION);
	return;
}
function stdmsg($heading = '', $text = '', $div = 'success', $htmlstrip = false) {
	global $REL_TPL;
	$REL_TPL->stdmsg($heading,$text,$div,$htmlstrip);
}

function mkglobal($vars) {
	if (!is_array($vars))
	$vars = explode(":", $vars);
	foreach ($vars as $v) {
		if (isset($_GET[$v]))
		$GLOBALS[$v] = trim($_GET[$v]);
		elseif (isset($_POST[$v]))
		$GLOBALS[$v] = trim($_POST[$v]);
		else
		return false;
	}
	return true;
}
function validusername($username)
{
	if ($username == "")
	return false;

	// The following characters are allowed in user names
	$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_.";

	for ($i = 0; $i < strlen($username); ++$i)
	if (strpos($allowedchars, $username[$i]) === false)
	return false;

	return true;
}/*
function unesc($x) {
	$x = trim($x);

	return $x;
}*/
function stderr($heading = '', $text = '', $head = '', $div ='error', $htmlstrip = false) {
	global $REL_TPL;
	$REL_TPL->stderr($heading,$text,$head,$div,$htmlstrip);
}

function mksecret($length = 20) {
	$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
	$str;
	for($i = 1; $i <= $length; $i++)
	{
		$ch = rand(0, count($set)-1);
		$str .= $set[$ch];
	}
	return $str;
}

	function mksize($bytes) {
		if ($bytes < 1000 * 1024)
			return number_format($bytes / 1024, 2) . " kB";
		elseif ($bytes < 1000 * 1048576)
			return number_format($bytes / 1048576, 2) . " MB";
		elseif ($bytes < 1000 * 1073741824)
			return number_format($bytes / 1073741824, 2) . " GB";
		else
			return number_format($bytes / 1099511627776, 2) . " TB";
	}

function logincookie($id, $passhash, $language, $updatedb = true, $expires = 0x7fffffff) {
	setcookie("uid", $id, $expires);
	setcookie("pass", md5($passhash.COOKIE_SECRET), $expires);
	setcookie("lang", $language, $expires);

	if ($updatedb)
	sql_query("UPDATE users SET last_access = ".time()." WHERE id = $id") or sqlerr(__FILE__,__LINE__);
	return;
}

function is_valid_id($id) {
	return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}
function hash_pad($hash) {
	return str_pad($hash, 20);
}
function mkprettytime($seconds, $time = true) {
	global $CURUSER, $REL_CONFIG;
//	$seconds = $seconds+$REL_CONFIG['site_timezone']*3600;
	$seconds = $seconds-date("Z")+$CURUSER['timezone']*3600;
	$search = array('January','February','March','April','May','June','July','August','September','October','November','December');
	$replace = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	if ($time == true)
		$data = @date("j F Y в H:i:s", $seconds);
	else
		$data = @date("j F Y", $seconds);
	if (!$data) 
		$data = 'N/A'; 
	else
		$data = str_replace($search, $replace, $data);
	return $data;
}

function get_elapsed_time($U,$showseconds=true){
	$N = time();
	if ($N>=$U)
	$diff = $N-$U;
	else
	$diff = $U-$N;
	//year (365 days) = 31536000
	//month (30 days) = 2592000
	//week = 604800
	//day = 86400
	//hour = 3600

	if($diff>=31536000){
		$Iyear = floor($diff/31536000);
		$diff = $diff-($Iyear*31536000);
	}
	if($diff>=2629800){    //2592000 seconds in month with 30 days
		$Imonth = floor($diff/2629800);
		$diff = $diff-($Imonth*2629800);
	}
	if($diff>=604800){
		$Iweek = floor($diff/604800);
		$diff = $diff-($Iweek*604800);
	}
	if($diff>=86400){
		$Iday = floor($diff/86400);
		$diff = $diff-($Iday*86400);
	}
	if($diff>=3600){
		$Ihour = floor($diff/3600);
		$diff = $diff-($Ihour*3600);
	}
	if($diff>=60){
		$Iminute = floor($diff/60);
		$diff = $diff-($Iminute*60);
	}
	if($diff>0){
		$Isecond = floor($diff);
	}

	$j = " ";

	$ret = "";

	if(isset($Iyear)) $ret .= $Iyear." ".rusdate($Iyear,'year').$j;
	if(isset($Imonth)) $ret .= $Imonth ." ".rusdate($Imonth ,'month').$j;
	if(isset($Iweek)) $ret .= $Iweek ." ".rusdate($Iweek ,'week').$j;
	if(isset($Iday)) $ret .= $Iday ." ".rusdate($Iday ,'day').$j;
	if(isset($Ihour)) $ret .= $Ihour ." ".rusdate($Ihour ,'hour').$j;
	if(isset($Iminute)) $ret .= $Iminute ." ".rusdate($Iminute ,'minute').$j;

	//    if($showseconds==false && $Iminute<1)$Iminute=0;
	if($showseconds==false && $Iminute<1 && $Ihour<1 && $Iday<1 && $Iweek<1 && $Imonth<1 && $Iyear<1)return rusdate(0 ,'minute');

	if(($Isecond>0 OR $ret=="") AND $showseconds==true){
		if($ret=="" AND !isset($Isecond))$Isecond=0;
		$ret .= $Isecond ." ".rusdate($Isecond ,'second').$j;
	}
	return $ret;
}

function rusdate($num,$type){
	$rus = array (
        "year"    => array( "лет", "год", "года", "года", "года", "лет", "лет", "лет", "лет", "лет"),
        "month"  => array( "месяцев", "месяц", "месяца", "месяца", "месяца", "месяцев", "месяцев", "месяцев", "месяцев", "месяцев"),
        "week"  => array( "недель", "неделю", "недели", "недели", "недели", "недель", "недель", "недель", "недель", "недель"),
        "day"   => array( "дней", "день", "дня", "дня", "дня", "дней", "дней", "дней", "дней", "дней"),
        "hour"    => array( "часов", "час", "часа", "часа", "часа", "часов", "часов", "часов", "часов", "часов"),
        "minute" => array( "минут", "минуту", "минуты", "минуты", "минуты", "минут", "минут", "минут", "минут", "минут"),
        "second" => array( "секунд", "секунду", "секунды", "секунды", "секунды", "секунд", "секунд", "секунд", "секунд", "секунд"),
	);

	$num = intval($num);
	if ( 10 < $num && $num < 20) return $rus[$type][0];
	return $rus[$type][$num % 10];
}

function validemail($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL)?true:false;
}

function valid_date($date) {
	if(!$date)
	stderr("Ошибка","Вы не ввели дату","no");

	$allowedchars = "1234567890-";

		for ($i = 0; $i < strlen($date); ++$i)
		if (strpos($allowedchars, $date[$i]) === false)
		stderr("Ошибка","В дате обнаруженные запрещенные символы","no");


	$pattern = "#(.*?)-(.*?)-(.*?)#is";
	$replacement = "\\2/\\1/\\3";
	$repl = preg_replace($pattern, $replacement, $date);

	$time = strtotime($repl);
	if (!is_valid_id($time))
		stderr("Ошибка","Похоже вы указали неверную дату","no");

	return $time;
}
//для добавления новостей



function loggedinorreturn() {
	global $CURUSER;
	if (!$CURUSER) {
		header("Location: login.php");
		exit();
	}
	return;
}

// переводим дату рождения
function birthday_time ($date){
	if (!$date)
		return "";
	$a_brt  = preg_split("~\D~",$date);
	$birthday = mktime(0,0,0,$a_brt['1'],$a_brt['0'],$a_brt['2']);

	return $birthday;
}
//проверяем номер телефона
function check_mobile($number,$check=true){
	//сначала убираем все лишние знаки
	$mobile = preg_replace('~\D+~','',$number);
// на всякий случай проверяем длинну номера
	if(strlen($mobile) == 10){
		$mobile = "7".$mobile;
	}
	if (strlen($mobile) != 11){
		if ($check)
			stderr("Ошибка","Слишком короткий номер сотового. <a href=\"javascript:history.go(-1);\">Назад</a>.","no");
		else
			return 'NULL';
	}

	return $mobile;
}

	function check_unic($data,$table,$column,$id=""){
		if(strlen($data) == 10){
			$data_a = "7".$data;
		}
		elseif(strlen($data) == 11){
			$data_a = substr($data,1);
		}
		
		$res = sql_query("SELECT id, `delete` FROM ".$table." WHERE ".$column." = '".$data."' OR  ".$column." = '".$data_a."'");

		if(mysql_num_rows($res) != 0) {
			if($id){
				$row = mysql_fetch_array($res);
				if($row['id'] == $id) {
					return true;
				}
				elseif($row['delete'] == '1'){
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		else
			return true;
	}

	//функция вывода менеджреов отделения
	function get_manager($class,$department){
		if($class == UC_HEAD){
			$add = "WHERE department = '".$department."'";
		}
		elseif($class == UC_POWER_HEAD){
			$add = "WHERE (department.parent = '".$department."' OR department.id = '".$department."')";
		}
		// where вынесено на тот случай, если список получает администратор
		$res = sql_query("SELECT users.id,users.name, department.name as d_name, department.parent FROM  `users` LEFT JOIN department ON department.id = users.department  ".$add.";")  or sqlerr(__FILE__, __LINE__);
		return $res;
	}

function get_department($class,$department,$id_select=""){
	if($class == UC_POWER_HEAD){
		$res=sql_query("SELECT *  FROM `department` WHERE (id ='".$department."' OR parent = '".$department."');")  or sqlerr(__FILE__, __LINE__);

	}
	elseif($class == UC_ADMINISTRATOR) {
		$res = sql_query ("SELECT *  FROM `department`;") or sqlerr (__FILE__, __LINE__);
	}
	else
		return;
		//формируем к какому отделению можно прикрепить пользователя
		while ($row = mysql_fetch_array($res)) {
			$select = "";
			if ($row['id'] == $id_select){
				$select = "selected = \"selected\"";

			}
			$list_department .= " <option ".$select." value = ".$row['id'].">".$row['name']."</option>";
		}

	return $list_department;
}

	//фильтр для карт и клиентов
	function filter_index($data,$page){
		global $CURUSER;


		// прописываем фильтры
		// фильтр по самому себе
		if($data['only_my'] AND is_valid_id($data['only_my'])){
			$add_where .= "AND ".$page.".manager = '".$CURUSER['id']."'";
			$add_link .= "&only_my=1";
		}
		//фильтр по отделеию
		// если фильтр в клиентах, то по отделению доступен только для повер_хеадов
		if((($page =="client" AND  get_user_class() >=UC_POWER_HEAD) OR $page == "card_client") AND $data['department'] AND is_valid_id($data['department'])){

			$add_where .= "AND ".$page.".department = '".$data['department']."'";
			$add_link .= "&department=".$data['department'];
		}
		//фильтр по менеджерам
		if($data['manager'] AND is_valid_id($data['manager'])){
			$add_where .= "AND ".$page.".manager = '".$data['manager']."'";
			$add_link .= "&manager=".$data['manager'];
		}

		// по дате след. звонка/выдаче
		if($data['status_action']){
			$now_date = strtotime(date("d.m.Y"));
			$add_link .= "&status_action=".$data['status_action'];


			if($data['status_action']=='miss'){
				$add_where .="AND ".$page.".next_call < '".$now_date."' ";
				$add_where .= "AND ".$page.".next_call != '0' ";
			}
			elseif($data['status_action']=='next'){
				$add_where .="AND ".$page.".next_call > '".$now_date."' ";
			}
			elseif($data['status_action']=='today'){
				$add_where .="AND ".$page.".next_call = '".$now_date."' ";
			}
			if($page=="client") {
				$add_where .= "AND callback.status = '0' ";
			}
		}

		/*ФИЛЬТР ТОЛЬКО ДЛЯ КЛИЕНТОВ*/
		if($page == "client"){
			// по статусу клиента
			if($data['status_client']) {
				$status = (int)($data['status_client'] - 1);
				$add_where = " AND client.status='" . $status . "'";
				$add_link .= "&status_client=" . $data['status_client'];
			}

			// по типу контакта
			if($data['type']){
				if($data['type']=='1'){
					$add_where .="AND callback.type_contact = 1 ";
				}
				elseif($data['type']=='2'){
					$add_where .="AND callback.type_contact = 2 ";
				}
				$add_link .= "&type=".$data['type'];
			}


		}


		/*ФИЛЬТР ТОЛЬКО ДЛЯ КАРТ*/
		if($page == "card_client"){
			// фильтруем по типу карты
			if($data['type_card'] AND is_valid_id($data['type_card'])){
				$add_where = "AND ".$page.".id_cobrand = '".$data['type_card']."'";
				$add_link .= "&type_card=".$data['type_card'];
			}


		}
		$return['add_link'] = $add_link;
		$return['add_where'] = $add_where;
		return $return;


	}

	// сортировка карт и клиентов
	function sort_index($data,$page){

		// карты фильтры по имени, дате поступления/добавления и след. звонку
		// клиенты фильры по имени, дате контакта

		if($data['name']){
			if($data['name']=='asc'){
				$sort['name']='asc';
			}
			elseif($data['name']=='desc'){
				$sort['name']='desc';
			}
			$sort['link'] .= "&name=".$sort['name'];
			$sort['query'] = "ORDER BY $page.name ".$sort['name']."";
		}
		elseif($data['added']){
			if($data['added']=='asc'){
				$sort['added']='asc';
			}
			elseif($data['added']=='desc'){
				$sort['added']='desc';
			}
			$sort['link'] .= "&added=".$sort['added'];
			$sort['query'] = "ORDER BY $page.added ".$sort['added']."";

		}
		elseif($data['next_call']){
			if($data['next_call']=='asc'){
				$sort['next_call']='asc';
			}
			elseif($data['next_call']=='desc'){
				$sort['next_call']='desc';
			}
			$sort['link'] .= "&next_call=".$sort['next_call'];
			$sort['query'] = "ORDER BY $page.next_call ".$sort['next_call']."";

		}
	return $sort;
	}
?>

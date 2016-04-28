<?php
    require "include/connect_mysqli.php";

    function sql_query($query) {
        global $REL_DB_MySQLi;
        return $REL_DB_MySQLi->query($query);
    }

    function dbconn($lightmode = false) {
        global $mysql_host, $mysql_user, $mysql_pass, $mysql_db, $mysql_charset, $REL_CONFIG, $REL_CACHE, $CURUSER, $REL_DB_MySQLi, $REL_SEO, $REL_CRON, $REL_TPL;

        /* @var database object */
        require_once(ROOT_PATH . 'classes/database/database.class.mysqli.php');
        $REL_DB_MySQLi = new REL_DB_MySQLi($mysql_host, $mysql_user, $mysql_pass, $mysql_db, $mysql_charset);

        // configcache init

        /* @var array Array of releaser's configuration */
       // $REL_CONFIG=$REL_CACHE->get('system','config');
        //$REL_CONFIG=false;
        if ($REL_CONFIG===false) {

            $REL_CONFIG = array();

            $cacherow = sql_query("SELECT * FROM cache_stats");

            while ($cacheres = mysqli_fetch_array($cacherow))
                $REL_CONFIG[$cacheres['cache_name']] = $cacheres['cache_value'];

            $REL_CACHE->set('system','config',$REL_CONFIG);
        }

        //configcache init end
        /*$cronrow = sql_query("SELECT * FROM cron");

        while ($cronres = mysql_fetch_array($cronrow))
        $REL_CRON[$cronres['cron_name']] = $cronres['cron_value'];
    */
        /* @var object links parser/adder/changer for seo */
      /*  require_once(ROOT_PATH . 'classes/seo/seo.class.php');
        $REL_SEO = new REL_SEO();
        if (!$lightmode)
            userlogin();*/

        require_once(ROOT_PATH . 'classes/template/template.class.php');
        /* @var REL_TPL template class */
     /*   $REL_TPL = new REL_TPL($REL_CONFIG);

        gzip();
*/
        // INCLUDE SECURITY BACK-END
        //require_once(ROOT_PATH . 'include/csite.php');
        /**
         * Во время написания этого проекта, было выпито более 40 литров пива, 20 литров виски и скурено более 60 кальянов. Не считая съеденной еды.

         */
        //define ("CRM_VERSION", ($REL_CONFIG['yourcopy']?str_replace("{datenow}",date("Y"),$REL_CONFIG['yourcopy']).". ":"")."<br />Powered by IT Samara ".RELVERSION." &copy; 2015-".date("Y").".");
        define ("CRM_VERSION", "&copy; 2015-".date("Y")." Created by IT Samara (v".RELVERSION.") .");

        return;
    }
    function sqlerr($file = '', $line = '') {
        global $queries, $CURUSER, $REL_SEO;
        $err = mysqli_connect_errno();
print $err;
      /*  $res = sql_query("SELECT id FROM users WHERE class=".UC_ADMINISTRATOR);
        while (list($id) = mysql_fetch_array($res))
            write_sys_msg($id,'Ошибка MySQL: '.$err.'<br />Файл: '.$file.'<br />Строка: '.$line.'<br />Ссылка: '.$_SERVER['REQUEST_URI'].'<br />Пользователь: <a href="'.$REL_SEO->make_link('userdetails','id',$CURUSER['id'],'name',$CURUSER['name']).'">'.get_user_class_color($CURUSER['class'],$CURUSER['name'].'</a><br/>GET: '.print_r($_GET,true).'<br />POST:'.print_r($_POST,true)),'MySQL error detected!');
        /*$text = ("<table border=\"0\" bgcolor=\"blue\" align=\"left\" cellspacing=\"0\" cellpadding=\"10\" style=\"background: blue\">" .
        "<tr><td class=\"embedded\"><font color=\"white\"><h1>Ошибка в SQL</h1>\n" .
        "<b>Ответ от сервера MySQL: " . $err . ($file != '' && $line != '' ? "<p>в $file, линия $line</p>" : "") . "<p>Запрос номер $queries.</p></b></font></td></tr></table>");*/
      /*  write_log("<a href=\"".$REL_SEO->make_link('userdetails','id',$CURUSER['id'],'name',$CURUSER['name'])."\">".get_user_class_color($CURUSER['class'],$CURUSER['name'])."</a> SQL ERROR: $text</font>",'sql_errors');
        stderr("Ошибка выполнения."," Во время выполения скрипта произошла ошибка. Администратору отправлено сообщение. Можете на всякий случай его дополнительно оповестить.","no");*/
        return;
    }



    dbconn();
    $row = sql_query("SELECT * FROM `user` WHERE id = '1'")  or mysqli_connect_errno();
   $cacheres = mysqli_fetch_array($row);
        print_r($cacheres);
?>
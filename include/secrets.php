<?php



if(!defined('IN_SITE') ) die("Direct access to this page not allowed");

$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = '';
$mysql_db = 'crm';
$mysql_charset = 'utf8';

define("COOKIE_SECRET",'FEfj34r893jRJ389');

/**
 * Set cache driver, available "native" and "memcached" now
 * @var string
 */
define("REL_CACHEDRIVER",'native');
?>

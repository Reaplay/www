<?php
/**
 * Script that initialises all stuff
 */

/**
 * Constant to deny direct access to inclusion scripts
 * @var boolean
 */
define('IN_SITE', true);

// SET PHP ENVIRONMENT
@error_reporting(E_ALL & ~E_NOTICE);
@ini_set('error_reporting', E_ALL & ~E_NOTICE);
@ini_set('display_errors', '1');
@ini_set('display_startup_errors', '0');
@ini_set('ignore_repeated_errors', '1');
@session_start();
date_default_timezone_set('Europe/Moscow');
date_default_timezone_set(date_default_timezone_get());
/**
 * Full path to releaser sources
 * @var string
 */
define ('ROOT_PATH', str_replace("include","",dirname(__FILE__)));

//require_once(ROOT_PATH . 'include/classes.php');
//require_once(ROOT_PATH . 'include/functions.php');

// Variables for Start Time
/**
 * Script start time for debug
 * @var float
 */
$tstart = microtime(true); // Start time

require_once(ROOT_PATH . 'include/secrets.php');
/* @var object general cache object */
/*require_once(ROOT_PATH . 'classes/cache/cache.class.php');
$REL_CACHE=new Cache();
if (REL_CACHEDRIVER=='native') {
	require_once(ROOT_PATH .  'classes/cache/fileCacheDriver.class.php');
	$REL_CACHE->addDriver(NULL, new FileCacheDriver());
}
elseif (REL_CACHEDRIVER=='memcached') {
	require_once(ROOT_PATH .  'classes/cache/MemCacheDriver.class.php');
	$REL_CACHE->addDriver(NULL, new MemCacheDriver());
}
// TinyMCE security
require_once(ROOT_PATH . 'include/htmLawed.php');
// Ban system
//require_once(ROOT_PATH.'classes/bans/ipcheck.class.php');

require_once(ROOT_PATH . 'include/blocks.php');

// old,compatibility,deprecated functions and function aliases
//require_once(ROOT_PATH . 'include/functions_deprecated.php');

// IN AJAX MODE?

ajaxcheck();*/
?>

<?php

if (!defined("IN_SITE")) die('Direct access to this file not allowed.');
define ("UC_GUEST", -1);
define ("UC_USER", 0); // обычный менеджер
define ("UC_POWER_USER", 1); // расширенные права
define ("UC_HEAD", 2); //руководитель отделения
define ("UC_POWER_HEAD", 3); // руководитель направления

define ("UC_ADMINISTRATOR", 5); // админ


/**
 * Returns username with a color by user class
 * @param int $class id of user class
 * @param string $username username to be colored
 * @return string Colored username
 */
function get_user_class_color($class, $username)
{
	
	switch ($class)
	{
	
		case UC_ADMINISTRATOR:
			return "<span  title=\"Administrator\">" . $username . "</span>";/*style=\"color:green\"*/
			break;
		case UC_POWER_HEAD:
			return "<span style=\"color:#9C2FE0\" title=\"Руководитель направления\">" . $username . "</span>";
			break;
		case UC_HEAD:
			return "<span  title=\"Руководитель\">" . $username . "</span>"; /*style=\"color:#D21E36\"*/
			break;
		case UC_POWER_USER:
			return "<span  title=\"Расширенный пользователь\">" . $username . "</span>"; /*style=\"color:orange\"*/
			break;
		case UC_USER:
			return "<span title=\"Пользователь\">" . $username . "</span>";
			break;
		case UC_GUEST:
			return "<i>Гость</i>";
			break;

	}
	return "$username";
}

/**
 * Returns user class name
 * @param int $class class id
 * @return string class name
 */
function get_user_class_name($class) {
switch ($class) {
		case UC_USER: return "Пользователь";

		case UC_POWER_USER: return "Расширенный пользователь";

		case UC_HEAD: return "Руководитель";

		case UC_POWER_HEAD: return "Руководитель направления";

		case UC_ADMINISTRATOR: return "Администратор";

		case UC_GUEST: return "Гость";
	}
	return "";
}

/**
 * Checks that id of user class is valid
 * @param int $class id of class
 * @return boolean
 */
function is_valid_user_class($class) {
	return (is_numeric($class) && floor($class) == $class && $class >= UC_USER && $class <= UC_ADMINISTRATOR) || $class==-1;
}
?>
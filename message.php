<?php


	require_once ("include/connect.php");

	dbconn ();

	loggedinorreturn ();

// Define constants
	define ( 'PM_DELETED', 0 ); // Message was deleted
	define ( 'PM_INBOX', 1 ); // Message located in Inbox for reciever
	define ( 'PM_SENTBOX', - 1 ); // GET value for sent box


// Determine action
	$action = ( string ) $_GET ['action'];
	if (! $action) {
		$action = ( string ) $_POST ['action'];
		if (! $action) {
			$action = 'viewmailbox';
		}
	}
	//просмотр почтового ящика
	if ($action=="viewmailbox") {
		$REL_TPL->stdhead("Центр сообщений");
		require_once("elements/message/viewmailbox.php");
	}
	//просмотр тела сообщения
	elseif ($action=="viewmessage") {
		$REL_TPL->stdhead("Личное сообщение");
		require_once("elements/message/viewmessage.php");
	}
	//посылка сообщения
	elseif ($action=="sendmessage") {
		$REL_TPL->stdhead("Отправить сообщение");
		require_once("elements/message/sendmessage.php");
	}
	//прием посланного сообщения
	elseif ($action=="takemessage") {
		$REL_TPL->stdhead("");
		require_once("elements/message/takemessage.php");
	}
	//массовая рассылка
	elseif ($action=="mass_pm") {
		$REL_TPL->stdhead("");
		require_once("elements/message/mass_pm.php");
	}
	//прием сообщений из массовой рассылки
	elseif ($action=="takemass_pm") {
		$REL_TPL->stdhead("");
		require_once("elements/message/takemass_pm.php");
	}
	//перемещение, помечание как прочитанного
	elseif ($action=="moveordel") {
		$REL_TPL->stdhead("Изменение статуса сообщения");
		require_once("elements/message/moveordel.php");
	}
	//пересылка
	elseif ($action=="forward") {
		$REL_TPL->stdhead("");
		require_once("elements/message/forward.php");
	}
	//удаление сообщения
	elseif ($action=="deletemessage") {
		$REL_TPL->stdhead("");
		require_once("elements/message/deletemessage.php");
	}
	$REL_TPL->stdfoot();

?>
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
	die();/*
// начало просмотр почтового ящика
	if ($action == "viewmailbox") {

	} // конец просмотр почтового ящика


// начало просмотр тела сообщения
	elseif ($action == "viewmessage") {
		}
// начало просмотр посылка сообщения
	elseif ($action == "sendmessage") {


		$REL_TPL->stdfoot();
	} // конец посылка сообщения


// начало прием посланного сообщения
	elseif ($action == 'takemessage') {


	} // конец прием посланного сообщения


//начало массовая рассылка
	elseif ($action == 'mass_pm') {
		if (get_user_class () < UC_MODERATOR)
			stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('access_denied') );
		if (! is_valid_id ( $_POST ['n_pms'] ))
			stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id') );
		$n_pms = ( int ) $_POST ['n_pms'];
		$pmees = htmlspecialchars ( $_POST ['pmees'] );

		$REL_TPL->stdhead( "Отсылка сообщений", false );
		?>
		<table class=main border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td class=embedded>
					<div align=center>
						<form method=post action=<?=$_SERVER ['PHP_SELF']?> name=message><input
								type=hidden name=action value=takemass_pm> <?
								if ($_SERVER ["HTTP_REFERER"]) {
									?> <input type=hidden name=returnto
											  value="<?=htmlspecialchars ( $_SERVER ["HTTP_REFERER"] );?>"> <?
								}
							?>
							<table border=1 cellspacing=0 cellpadding=5>
								<tr>
									<td class=colhead colspan=2>Массовая рассылка для <?=$n_pms?>
										пользовате<?=($n_pms > 1 ? "лей" : "ля")?></td>
								</tr>
								<TR>
									<TD colspan="2"><B>Тема:&nbsp;&nbsp;</B> <INPUT name="subject"
																					type="text" size="60" maxlength="255"></TD>
								</TR>
								<tr>
									<td colspan="2">
										<div align="center"><?=print textbbcode ( "msg", $body );?></div>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<div align="center"><b>Комментарий:&nbsp;&nbsp;</b> <input
												name="comment" type="text" size="70" /></div>
									</td>
								</tr>
								<tr>
									<td>
										<div align="center"><b>От:&nbsp;&nbsp;</b> <?=$CURUSER ['username']?>
											<input name="sender" type="radio" value="self" checked /> &nbsp;
											Системное <input name="sender" type="radio" value="system" /></div>
									</td>
								</tr>
								<tr>
									<td colspan="2" align=center><input type=submit value="Послать!"
																		class=btn /></td>
								</tr>
							</table>
							<input type=hidden name=pmees value="<?=$pmees?>" /> <input
								type=hidden name=n_pms value=<?=$n_pms?> /></form>
						<br />
						<br />
					</div>
				</td>
			</tr>
		</table>
		<?php
		$REL_TPL->stdfoot();

	} //конец массовая рассылка


//начало прием сообщений из массовой рассылки
	elseif ($action == 'takemass_pm') {
		if (get_user_class () < UC_MODERATOR)
			stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('access_denied') );
		$msg = trim ( $_POST ["msg"] );
		if (! $msg)
			stderr ( $REL_LANG->say_by_key('error'), "Пожалуйста введите сообщение." );
		$sender_id = ($_POST ['sender'] == 'system' ? 0 : $CURUSER ['id']);
		$n_pms = ( int ) $_POST ['n_pms'];
		$comment = ( string ) $_POST ['comment'];
		$from_is = mysql_real_escape_string ( unesc ( $_POST ['pmees'] ) );
		// Change
		$subject = trim ( $_POST ['subject'] );
		$query = "INSERT INTO messages (sender, receiver, added, msg, subject, location, poster) " . "SELECT $sender_id, u.id, " . time () . ", " . sqlesc (  $msg ) . ", " . sqlesc ( $subject ) . ", 1, $sender_id " . $from_is;
		// End of Change
		sql_query ( $query ) or sqlerr ( __FILE__, __LINE__ );
		$n = mysql_affected_rows ();
		// add a custom text or stats snapshot to comments in profile
		if ($comment) {
			$res = sql_query ( "SELECT u.id, u.modcomment " . $from_is ) or sqlerr ( __FILE__, __LINE__ );
			if (mysql_num_rows ( $res ) > 0) {
				$l = 0;
				while ( $user = mysql_fetch_array ( $res ) ) {
					unset ( $new );
					$old = $user ['modcomment'];
					if ($comment)
						$new = $comment;

					$new .= $old ? ("\n" . $old) : $old;
					sql_query ( "UPDATE users SET modcomment = " . sqlesc ( $new ) . " WHERE id = " . $user ['id'] ) or sqlerr ( __FILE__, __LINE__ );
					if (mysql_affected_rows ())
						$l ++;
				}
			}
		}
		safe_redirect($REL_SEO->make_link('message'),3);
		stderr ( $REL_LANG->say_by_key('success'), (($n_pms > 1) ? "$n сообщений из $n_pms было" : "Сообщение было") . " успешно отправлено!" . ($l ? " $l комментарий(ев) в профиле " . (($l > 1) ? "были" : " был") . " обновлен!" : ""), 'success' );
	} //конец прием сообщений из массовой рассылки


//начало перемещение, помечание как прочитанного
	elseif ($action == "moveordel") {
		if (isset ( $_POST ["id"] ) && ! is_valid_id ( $_POST ["id"] ))
			stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id') );
		$pm_id = $_POST ['id'];

		$pm_box = ( int ) $_POST ['box'];
		if (! is_array ( $_POST ['messages'] ))
			stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id') );
		$pm_messages = $_POST ['messages'];
		if ($_POST ['move']) {
			if ($pm_id) {
				// Move a single message
				@sql_query ( "UPDATE messages SET location=" . sqlesc ( $pm_box ) . ", saved = 1 WHERE id=" . sqlesc ( $pm_id ) . " AND receiver=" . $CURUSER ['id'] . " LIMIT 1" );
			} else {
				// Move multiple messages
				@sql_query ( "UPDATE messages SET location=" . sqlesc ( $pm_box ) . ", saved = 1 WHERE id IN (" . implode ( ", ", array_map ( "sqlesc", array_map ( "intval", $pm_messages ) ) ) . ') AND receiver=' . $CURUSER ['id'] );
			}
			// Check if messages were moved
			if (@mysql_affected_rows () == 0) {
				stderr ( $REL_LANG->say_by_key('error'), "Не возможно переместить сообщения!" );
			}
			safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
			exit ();
		} elseif ($_POST ['delete']) {
			if ($pm_id) {
				// Delete a single message
				$res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
				$message = mysql_fetch_assoc ( $res );
				if ($message ['receiver'] == $CURUSER ['id'] && ! $message ['saved']) {
					sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
				} elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] == PM_DELETED) {
					sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
				} elseif ($message ['receiver'] == $CURUSER ['id'] && $message ['saved']) {
					sql_query ( "UPDATE messages SET location=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
				} elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] != PM_DELETED) {
					sql_query ( "UPDATE messages SET saved=0 WHERE id=" . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
				}
			} else {
				// Delete multiple messages
				if (is_array ( $pm_messages ))
					foreach ( $pm_messages as $id ) {
						$res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
						$message = mysql_fetch_assoc ( $res );
						if ($message ['receiver'] == $CURUSER ['id'] && ! $message ['saved']) {
							sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
						} elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] == PM_DELETED) {
							sql_query ( "DELETE FROM messages WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
						} elseif ($message ['receiver'] == $CURUSER ['id'] && $message ['saved']) {
							sql_query ( "UPDATE messages SET location=0 WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
						} elseif ($message ['sender'] == $CURUSER ['id'] && $message ['location'] != PM_DELETED) {
							sql_query ( "UPDATE messages SET saved=0 WHERE id=" . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
						}
					}
			}
			// Check if messages were moved
			if (@mysql_affected_rows () == 0) {
				stderr ( $REL_LANG->say_by_key('error'), "Сообщение не может быть удалено!" );
			} else {
				safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
				exit ();
			}
		} elseif ($_POST ["markread"]) {
			//помечаем одно сообщение
			if ($pm_id) {
				sql_query ( "UPDATE messages SET unread=0 WHERE id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
			} //помечаем множество сообщений
			else {
				if (is_array ( $pm_messages ))
					foreach ( $pm_messages as $id ) {
						$res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
						$message = mysql_fetch_assoc ( $res );
						sql_query ( "UPDATE messages SET unread=0 WHERE id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
					}
			}
			// Проверяем, были ли помечены сообщения

			safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box));
			exit ();

		} elseif ($_POST ["archive"]) {
			//архивируем одно сообщение
			if ($pm_id) {
				sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},1,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,1) WHERE id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
			} //архивируем множество сообщений
			else {
				if (is_array ( $pm_messages ))
					foreach ( $pm_messages as $id ) {
						$res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
						$message = mysql_fetch_assoc ( $res );
						sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},1,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,1) WHERE id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
					}
			}

			safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box),1 );
			stderr($REL_LANG->say_by_key('success'), "Сообщение(я) архивировано(ы)!",'success');

		} elseif ($_POST ["unarchive"]) {
			//архивируем одно сообщение
			if ($pm_id) {
				sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},0,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,0) AND id = " . sqlesc ( $pm_id ) ) or sqlerr ( __FILE__, __LINE__ );
			} //архивируем множество сообщений
			else {
				if (is_array ( $pm_messages ))
					foreach ( $pm_messages as $id ) {
						$res = sql_query ( "SELECT * FROM messages WHERE id=" . sqlesc ( ( int ) $id ) );
						$message = mysql_fetch_assoc ( $res );
						sql_query ( "UPDATE messages SET archived=IF(sender={$CURUSER['id']},0,archived), archived_receiver=IF(sender={$CURUSER['id']},archived_receiver,0) AND id = " . sqlesc ( ( int ) $id ) ) or sqlerr ( __FILE__, __LINE__ );
					}
			}

			safe_redirect($REL_SEO->make_link('message','action','viewmailbox','box',$pm_box),1 );
			stderr($REL_LANG->say_by_key('success'), "Сообщение(я) разархивировано(ы)!",'success');
		}

		stderr ( $REL_LANG->say_by_key('error'), "Нет действия." );
	} //конец перемещение, помечание как прочитанного


//начало пересылка
	elseif ($action == "forward") {
		if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
			// Display form
			if (! is_valid_id ( $_GET ["id"] ))
				stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id') );
			$pm_id = $_GET ['id'];

			// Get the message
			$res = sql_query ( 'SELECT * FROM messages WHERE id=' . sqlesc ( $pm_id ) . ' AND (receiver=' . sqlesc ( $CURUSER ['id'] ) . ' OR sender=' . sqlesc ( $CURUSER ['id'] ) . ') LIMIT 1' ) or sqlerr ( __FILE__, __LINE__ );

			if (! $res) {
				stderr ( $REL_LANG->say_by_key('error'), "У вас нет разрешения пересылать это сообщение." );
			}
			if (mysql_num_rows ( $res ) == 0) {
				stderr ( $REL_LANG->say_by_key('error'), "У вас нет разрешения пересылать это сообщение." );
			}
			$message = mysql_fetch_assoc ( $res );

			// Prepare variables
			if (!preg_match("/^Fwd\(([0-9]+)\)\:/",$message ['subject']))

				$subject = "Fwd(1): ".makesafe($message ['subject']);
			else $subject = preg_replace("/^Fwd\(([0-9]+)\)\:/e","'Fwd('.(\\1+1).'):'",makesafe($message ['subject']));

			$from = $message ['sender'];
			$orig = $message ['receiver'];

			$res = sql_query ( "SELECT username FROM users WHERE id=" . sqlesc ( $orig ) . " OR id=" . sqlesc ( $from ) ) or sqlerr ( __FILE__, __LINE__ );

			$orig2 = mysql_fetch_assoc ( $res );
			$orig_name = "<A href=\"".$REL_SEO->make_link('userdetails','id',$from,'username',translit($orig2['username']))."\">" . $orig2 ['username'] . "</A>";
			if ($from == 0) {
				$from_name = "Системное";
				$from2 ['username'] = "Системное";
			} else {
				$from2 = mysql_fetch_array ( $res );
				$from_name = "<A href=\"".$REL_SEO->make_link('userdetails','id',$from,'username',translit($from2['username']))."\">" . $from2 ['username'] . "</A>";
			}

			$body = "Оригинальное сообщение:<hr /><blockquote>" . format_comment ( $message ['msg'] . "</blockquote><cite>{$from2['username']}</cite><hr /><br /><br />" );

			$REL_TPL->stdhead( $subject );
			?>

			<FORM action="<?=$REL_SEO->make_link('message')?>" method="post"><INPUT
					type="hidden" name="action" value="forward"> <INPUT type="hidden"
																		name="id" value="<?=$pm_id?>">
				<TABLE border="0" cellpadding="4" cellspacing="0">
					<TR>
						<TD class="colhead" colspan="2"><?=$subject?></TD>
					</TR>
					<TR>
						<TD>Кому:</TD>
						<TD><INPUT type="text" name="to" value="Введите имя" size="83"></TD>
					</TR>
					<TR>
						<TD>Оригинальный<br />
							отправитель:</TD>
						<TD><?=$orig_name?></TD>
					</TR>
					<TR>
						<TD>От:</TD>
						<TD><?=$from_name?></TD>
					</TR>
					<TR>
						<TD>Тема:</TD>
						<TD><INPUT type="text" name="subject" value="<?=$subject?>" size="83"></TD>
					</TR>
					<TR>
						<TD>Сообщение:</TD>
						<TD><?=( textbbcode ( "msg" ) );?></TD>
					</TR>
					<TR>
						<TD colspan="2" align="center">Сохранить сообщение <INPUT
								type="checkbox" name="save" value="1"
								<?=$CURUSER ['savepms'] ? " checked" : ""?>>&nbsp;<INPUT
								type="submit" value="Переслать"></TD>
					</TR>
				</TABLE>
			</FORM>
			<?
			$REL_TPL->stdfoot();
		}

		else {

			// Forward the message
			if (! is_valid_id ( $_POST ["id"] ))
				stderr ( $REL_LANG->say_by_key('error'), $REL_LANG->say_by_key('invalid_id') );
			$pm_id = $_POST ['id'];

			// Get the message
			$res = sql_query ( 'SELECT * FROM messages WHERE id=' . sqlesc ( $pm_id ) . ' AND (receiver=' . sqlesc ( $CURUSER ['id'] ) . ' OR sender=' . sqlesc ( $CURUSER ['id'] ) . ') LIMIT 1' ) or sqlerr ( __FILE__, __LINE__ );
			if (! $res) {
				stderr ( $REL_LANG->say_by_key('error'), "У вас нет разрешения пересылать это сообщение." );
			}

			if (mysql_num_rows ( $res ) == 0) {
				stderr ( $REL_LANG->say_by_key('error'), "У вас нет разрешения пересылать это сообщение." );
			}

			$message = mysql_fetch_assoc ( $res );
			$subject = ( string ) $_POST ['subject'];
			$username = strip_tags ( $_POST ['to'] );

			// Try finding a user with specified name


			$res = sql_query ( "SELECT id FROM users WHERE LOWER(username)=LOWER(" . sqlesc ( $username ) . ") LIMIT 1" );
			if (! $res) {
				stderr ( $REL_LANG->say_by_key('error'), "Пользователя, с таким именем не существует." );
			}
			if (mysql_num_rows ( $res ) == 0) {
				stderr ( $REL_LANG->say_by_key('error'), "Пользователя, с таким именем не существует." );
			}

			$to = mysql_fetch_array ( $res );
			$to = $to [0];

			// Get Orignal sender's username
			if ($message ['sender'] == 0) {
				$from = "Системное";
			} else {
				$res = sql_query ( "SELECT * FROM users WHERE id=" . sqlesc ( $message ['sender'] ) ) or sqlerr ( __FILE__, __LINE__ );
				$from = mysql_fetch_assoc ( $res );
				$from = $from ['username'];
			}
			$body = ( string ) $_POST ['msg'];
			$body .= "Оригинальное сообщение:<hr /><blockquote>" . $message ['msg'] . "</blockquote><cite>{$from}</cite><hr /><br /><br />";
			$save = ( int ) $_POST ['save'];
			if ($save) {
				$save = 1;
			} else {
				$save = 0;
			}

			//Make sure recipient wants this message
			if (get_user_class () < UC_MODERATOR) {
				if ($from ["acceptpms"] == "friends") {
					$res2 = sql_query ( "SELECT * FROM friends WHERE userid=$to AND friendid=" . $CURUSER ["id"] ) or sqlerr ( __FILE__, __LINE__ );
					if (mysql_num_rows ( $res2 ) != 1)
						stderr ( "Отклонено", "Этот пользователь принимает сообщение только из списка своих друзей." );
				}

				elseif ($from ["acceptpms"] == "no")
					stderr ( "Отклонено", "Этот пользователь не принимает сообщения." );
			}

			$pms = sql_query ( "SELECT SUM(1) FROM messages WHERE (receiver = " . ($receiver ? $receiver : $to) . " AND location=1) OR (sender = " . ($receiver ? $receiver : $to) . " AND saved = 1) GROUP BY messages.id" );
			$pms = mysql_result ( $pms, 0 );
			if ($pms >= $REL_CONFIG ['pm_max'])
				stderr ( $REL_LANG->say_by_key('error'), "Ящик личных сообщений получателя заполнен, вы не можете переслать ему сообщение." );

			sql_query ( "INSERT INTO messages (poster, sender, receiver, added, subject, msg, location, saved) VALUES(" . $CURUSER ["id"] . ", " . $CURUSER ["id"] . ", $to, '" . time () . "', " . sqlesc ( $subject ) . "," . sqlesc ( ($body) ) . ", " . sqlesc ( PM_INBOX ) . ", " . sqlesc ( $save ) . ")" ) or sqlerr ( __FILE__, __LINE__ );
			stdmsg ( "Удачно", "ЛС переслано." );
		}
	} //конец пересылка


//начало удаление сообщения
	elseif ($action == "deletemessage") {

		//конец удаление сообщения
	}
//else stderr("Access Denied.","Unknown action");
*/
?>
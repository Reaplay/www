{if !$IS_HEAD}
Внимание! Добавленный клиент будет закреплен за вами
{/if}
<link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 
<script type="text/javascript" src="js/jquery.plugin.js"></script> 
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript" src="js/jquery.datepick-ru.js"></script>
<script type="text/javascript" src="js/check_email.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js" ></script>	
<script>jQuery(function($){
     $("#phone").mask("(999) 999-9999");
  });</script>
  <script type="text/javascript" src="js/check_form_client.js" ></script>
{literal}<script>
$(function() {
	$('#popupDatepicker').datepick({dateFormat: 'dd-mm-yyyy'});

});


</script>{/literal}
<form method="post" action="client.php?a=add&amp;t=a">
	<table border="1" cellspacing="0" cellpadding="5" align="center">
	<tr>
			<td width="" class="heading" valign="top" align="right">ФИО&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="name" size="40" />
			</td>
		</tr>
	<!--	<tr>
			<td width="" class="heading" valign="top" align="right">Отделение&nbsp;</td>
			<td valign="top" align="left">
				<select name = "department">{$p_department}</select>
			</td>
		</tr>-->
<tr>
			<td width="" class="heading" valign="top" align="right">Менеджер&nbsp;</td>
			<td valign="top" align="left">
				<select name = "manager">{$p_manager}</select>
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Сотовый телефон&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="mobile" size="12" id="phone" />
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">e-mail&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="email" size="20" id="email" /><span id=valid"></span>
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Дата рождения&nbsp;<br/>ДД-ММ-ГГГГ</td>
			<td valign="top" align="left">
				 <input type="text" name="birthday" id="popupDatepicker">
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Пол&nbsp;</td>
			<td valign="top" align="left">
				 <select name="gender"><option value="1">Мужской</option><option value="2">Женский</option></select>
			</td>
		</tr>
	
	<tr>
			<td width="" class="heading" valign="top" align="right"></td>
			<td valign="top" align="left">
				<button type="submit">Добавить</button>
			</td>
		</tr>	
	
	</table>
</form>
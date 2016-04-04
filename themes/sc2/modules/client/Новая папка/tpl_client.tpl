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
<form method="post" action="client.php?a={$action}">
	<table border="1" cellspacing="0" cellpadding="5" align="center">
	<tr>
			<td width="" class="heading" valign="top" align="right">ФИО&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="name" size="40" value="{$data_client.name}"/>
			</td>
		</tr>
	<!--	<tr>
			<td width="" class="heading" valign="top" align="right">Отделение&nbsp;</td>
			<td valign="top" align="left">
				<select name = "department">{$p_department}</select>
			</td>
		</tr>-->
		{if $action == "add"}
<tr>
			<td width="" class="heading" valign="top" align="right">Менеджер&nbsp;</td>
			<td valign="top" align="left">
				<select name = "manager">{$p_manager}</select>
			</td>
		</tr>
		{/if}
		{if $action == "edit"}
		<tr>
			<td width="" class="heading" valign="top" align="right">Текущий менеджер&nbsp;</td>
			<td valign="top" align="left">
				{$data_client.u_name}
			</td>
		</tr>
		{if $IS_HEAD}
		<tr>
			<td width="" class="heading" valign="top" align="right">Изменить менеджера на&nbsp;</td>
			<td valign="top" align="left">
				<select name = "manager">{$manager}</select>
			</td>
		</tr>
		{/if}
		{/if}		
		<tr>
			<td width="" class="heading" valign="top" align="right">Сотовый телефон&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="mobile" size="12" id="phone" value="{$data_client.mobile}"/>
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">e-mail&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="email" size="20" id="email" value="{$data_client.email}" /><span id=valid"></span>
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Дата рождения&nbsp;<br/>ДД-ММ-ГГГГ</td>
			<td valign="top" align="left">
				 <input type="text" name="birthday" id="popupDatepicker" value="{$data_client.birthday}">
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Пол&nbsp;</td>
			<td valign="top" align="left">
				 <select name="gender">
					<option value="1" {if $gender == "1"} selected = "selected"{/if}>Мужской</option>
					<option value="2" {if $gender == "2"} selected = "selected"{/if}>Женский</option>
				</select>
			</td>
		</tr>
	
	<tr>
			<td width="" class="heading" valign="top" align="right"></td>
			<td valign="top" align="left">
				<button type="submit">{if $action == "add"}Добавить{else}Изменить{/if}</button>
			</td>
		</tr>

	<input type="hidden" name="action" value="{$action}">
		{if $action == "edit"}
		<input type="hidden" name="id" value="{$id}">
		{/if}
	</table>
</form>
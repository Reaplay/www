<form method="post" action="user.php?a=e">
	<table border="1" cellspacing="0" cellpadding="5" align="center">
		<tr>
			<td width="" class="heading" valign="top" align="right">Логин&nbsp;</td>
			<td valign="top" align="left">
				{$data_user.login}
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">ФИО&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="name" size="40" value="{$data_user.name}" />
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Пароль&nbsp;</td>
			<td valign="top" align="left">
				<input type="password" name="password" size="40" />
			</td>
		</tr>
		{if $IS_HEAD}
		<tr>
			<td width="" class="heading" valign="top" align="right" >Доступ&nbsp;</td>
			<td valign="top" align="left">
				<select  name = "class">{$p_class}</select> <small></small>
		</td>
		{/if}
		</tr>
		{if $IS_POWER_HEAD}
		<tr>
			<td width="" class="heading" valign="top" align="right">Отделение&nbsp;</td>
			<td valign="top" align="left">
				<select name = "department">{$p_department}</select>
			</td>
		</tr>
		{/if}
		
		<tr>
			<td width="" class="heading" valign="top" align="right">Добавляет <br/>клиентов</td>
			<td valign="top" align="left">
				<input {if $data_user.add_client}checked="checked"{/if} name="add_client" type="checkbox">
			</td>
		</tr>	
			{if $IS_POWER_HEAD}
		<tr>
			<td width="" class="heading" valign="top" align="right">Добавляет <br/>пользователей</td>
			<td valign="top" align="left">	
				<input {if $data_user.add_user}checked="checked"{/if} name="add_user" type="checkbox">
			</td>
		</tr>
		{/if}
		
	<tr>
			<td width="" class="heading" valign="top" align="right"></td>
			<td valign="top" align="left">
				<input type="hidden" name = "id" value="{$data_user.id}">
				<button type="submit">Изменить</button>
			</td>
		</tr>	
	
	</table>
</form>
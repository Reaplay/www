{if !$IS_POWER_HEAD}
Пользователь будет привязан к вашему отделению
{/if}
<form method="post" action="user.php?a=a">
	<table border="1" cellspacing="0" cellpadding="5" align="center">
		<tr>
			<td width="" class="heading" valign="top" align="right">Логин&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="login" size="40" />
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">ФИО&nbsp;</td>
			<td valign="top" align="left">
				<input type="text" name="name" size="40" />
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Пароль&nbsp;</td>
			<td valign="top" align="left">
				<input type="password" name="password" size="40" />
			</td>
		</tr>
		<tr>
			<td width="" class="heading" valign="top" align="right">Доступ&nbsp;</td>
			<td valign="top" align="left">
				<select name = "class">{$p_class}</select>
		</td>
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
				<input checked="checked" name="add_client"  type="checkbox">
			</td>
		</tr>	
			{if $IS_POWER_HEAD}
		<tr>
			<td width="" class="heading" valign="top" align="right">Добавляет <br/>пользователей</td>
			<td valign="top" align="left">	<input  name="add_user"  type="checkbox">
			</td>
		</tr>
		{/if}
		
	<tr>
			<td width="" class="heading" valign="top" align="right"></td>
			<td valign="top" align="left">
				<button type="submit">Добавить</button>
			</td>
		</tr>	
	
	</table>
</form>
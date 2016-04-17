<div class="table-responsive">
	<table class="table table-condensed nomargin">
		{if $CURUSER.use_card}
		<thead>
			<tr>
				<th>Выдача карт</th>
				<th>На сегодня</th>
				<th>Пропущено</th>
				<th>Запланировано</th>


			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					Всего: {$activity_card.card_now + $activity_card.card_lost + $activity_card.card_next}
				</td>
				<td>{if $activity_card.card_now}{$activity_card.card_now}{else}N/A{/if}</td>
				<td>{if $activity_card.card_lost}{$activity_card.card_lost}{else}N/A{/if}</td>
				<td>{if $activity_card.card_next}{$activity_card.card_next}{else}N/A{/if}</td>

			</tr>
		</tbody>
		{/if}

		<thead>
			<tr>
				<th>Тип действия</th>
				<th>Перезвоны</th>
				<th>Встречи</th>
				<th>Всего</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div><a href="client.php?status_client=2" class="text-success">Активные клиенты</a> <i class="fa fa-external-link"></i></div>
				</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div>Пропущенные действия</div>
					<!--<small>small text</small>-->
				</td>
				<td>{if $activity_log.act_mt_lost}<a class="text-success" href="client.php?status_client=2&status_action=miss&type=1">{$activity_log.act_mt_lost}</a>{else}N/A{/if}</td>
				<td>{if $activity_log.act_call_lost}<a class="text-success" href="client.php?status_client=2&status_action=miss&type=2">{$activity_log.act_call_lost}</a>{else}N/A{/if}</td>
				<td>{$activity_log.act_mt_lost + $activity_log.act_call_lost}</td>
			</tr>
			<tr>
				<td>
					<div>Действия на сегодня</div>
					
				</td>
				<td>{if $activity_log.act_mt_now}{$activity_log.act_mt_now}{else}N/A{/if}</td>
				<td>{if $activity_log.act_call_now}{$activity_log.act_call_now}{else}N/A{/if}</td>
				<td>{$activity_log.act_mt_now + $activity_log.act_call_now}</td>
				
			</tr>
			<tr>
				<td>
					<div>Дальнейшие действия</div>
				</td>
				<td>{if $activity_log.act_mt_next}{$activity_log.act_mt_next}{else}N/A{/if}</td>
				<td>{if $activity_log.act_call_next}{$activity_log.act_call_next}{else}N/A{/if}</td>
				<td>{$activity_log.act_mt_next + $activity_log.act_call_next}</td>
				
			</tr>
			
			<tr>
				<td>
				<div><a href="client.php?status_client=1" class="text-success">Потенциальные клиенты</a> <i class="fa fa-external-link"></i></div>
				</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<div>Пропущенные действия</div>
					<!--<small>small text</small>-->
				</td>
				<td>{if $activity_log.pot_mt_lost}<a class="text-success" href="client.php?status_client=1&status_action=miss&type=1">{$activity_log.pot_mt_lost}</a>{else}N/A{/if}</td>
				<td>{if $activity_log.pot_call_lost}<a class="text-success" href="client.php?status_client=1&status_action=miss&type=2">{$activity_log.pot_call_lost}{else}N/A{/if}</td>
				<td>{$activity_log.pot_mt_lost + $activity_log.pot_call_lost}</td>
			</tr>
			<tr>
				<td>
					<div>Действия на сегодня</div>
					
				</td>
				<td>{if $activity_log.pot_mt_now}<a class="text-success" href="client.php?status_client=1&status_action=today&type=1">{$activity_log.pot_mt_now}</a>{else}N/A{/if}</td>
				<td>{if $activity_log.pot_call_now}<a class="text-success" href="client.php?status_client=1&status_action=today&type=2">{$activity_log.pot_call_now}</a>{else}N/A{/if}</td>
				<td>{$activity_log.pot_mt_now + $activity_log.pot_call_now}</td>
				
			</tr>
			<tr>
				<td>
					<div>Дальнейшие действия</div>
				</td>
				<td>{if $activity_log.pot_mt_next}<a class="text-success" href="client.php?status_client=1&status_action=next&type=1">{$activity_log.pot_mt_next}</a>{else}N/A{/if}</td>
				<td>{if $activity_log.pot_call_next}<a class="text-success" href="client.php?status_client=1&status_action=next&type=2">{$activity_log.pot_call_next}</a>{else}N/A{/if}</td>
				<td>{$activity_log.pot_mt_next + $activity_log.pot_call_next}</td>
				
			</tr>

		</tbody>
	</table>
</div>
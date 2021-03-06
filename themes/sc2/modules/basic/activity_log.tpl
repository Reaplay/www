<div class="table-responsive">


		{if $CURUSER.use_card}
			<div class="heading-title heading-dotted text-center">
				<h4>Карты</h4>
			</div>
	<table class="table table-condensed nomargin">
		<thead>
			<tr>
				<th>Выдача карт</th>
				<th>На сегодня<br>(Встречи/Звонки/NA)</th>
				<th>Пропущено<br>(Встречи/Звонки/NA)</th>
				<th>Запланировано<br>(Встречи/Звонки/NA)</th>


			</tr>

		</thead>
		<tbody>

		{foreach from=$data_card item=card}
			{$card.card_now = $card.card_now_mt + $card.card_now_call + $card.card_now_na}
			{$card.card_lost = $card.card_lost_mt + $card.card_lost_call + $card.card_lost_na}
			{$card.card_next = $card.card_next_mt + $card.card_next_call + $card.card_next_na}

			{if ({$card.card_now + $card.card_lost + $card.card_next}) != 0}
			<tr>
				<td>
					{$card.name}: {$card.card_now + $card.card_lost + $card.card_next}
				</td>
				<td>{if $card.card_now_mt}{$card.card_now_mt}{else}<b>0</b>{/if}/{if $card.card_now_call}{$card.card_now_call}{else}<b>0</b>{/if}/{if $card.card_now_na}{$card.card_now_na}{else}<b>0</b>{/if}</td>
				<td>{if $card.card_lost_mt}{$card.card_lost_mt}{else}<b>0</b>{/if}/{if $card.card_lost_call}{$card.card_lost_call}{else}<b>0</b>{/if}/{if $card.card_lost_na}{$card.card_lost_na}{else}<b>0</b>{/if}</td>
				<td>{if $card.card_next_mt}{$card.card_next_mt}{else}<b>0</b>{/if}/{if $card.card_next_call}{$card.card_next_call}{else}<b>0</b>{/if}/{if $card.card_next_na}{$card.card_next_na}{else}<b>0</b>{/if}</td>

			</tr>
			{/if}
		{/foreach}

			<tr>
				<td>
					Всего: {$activity_card.card_now + $activity_card.card_lost + $activity_card.card_next}
				</td>
				<td>{if $activity_card.card_now}<a class="text-success" href="card.php?status_action=today">{$activity_card.card_now}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_card.card_lost}<a class="text-success" href="card.php?status_action=miss">{$activity_card.card_lost}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_card.card_next}<a class="text-success" href="card.php?status_action=next">{$activity_card.card_next}</a>{else}<b>0</b>{/if}</td>

			</tr>
		</tbody>
		</table>
			<br /><br />
		{/if}

	<div class="heading-title heading-dotted text-center">
		<h4>Клиенты</h4>
	</div>
	<table class="table table-condensed nomargin">
		<thead>
			<tr>
				<th>Тип действия</th>
				<th>Звонок</th>
				<th>Встречи</th>
				<th>Рекомендации</th>
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
				<td></td>
			</tr>
			<tr>
				<td>
					<div>Пропущенные действия</div>
					<!--<small>small text</small>-->
				</td>
				<td>{if $activity_log.act_mt_lost}<a class="text-success" href="client.php?status_client=2&status_action=miss&type=1">{$activity_log.act_mt_lost}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_call_lost}<a class="text-success" href="client.php?status_client=2&status_action=miss&type=2">{$activity_log.act_call_lost}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_rec_lost}<a class="text-success" href="client.php?status_client=2&status_action=miss&type=3">{$activity_log.act_rec_lost}</a>{else}<b>0</b>{/if}</td>
				<td>{$activity_log.act_mt_lost + $activity_log.act_call_lost + $activity_log.act_rec_lost}</td>
			</tr>
			<tr>
				<td>
					<div>Действия на сегодня</div>
					
				</td>
				<td>{if $activity_log.act_mt_now}{$activity_log.act_mt_now}{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_call_now}{$activity_log.act_call_now}{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_rec_now}{$activity_log.act_rec_now}{else}<b>0</b>{/if}</td>
				<td>{$activity_log.act_mt_now + $activity_log.act_call_now + $activity_log.act_rec_now}</td>
				
			</tr>
			<tr>
				<td>
					<div>Дальнейшие действия</div>
				</td>
				<td>{if $activity_log.act_mt_next}{$activity_log.act_mt_next}{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_call_next}{$activity_log.act_call_next}{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.act_rec_next}{$activity_log.act_rec_next}{else}<b>0</b>{/if}</td>
				<td>{$activity_log.act_mt_next + $activity_log.act_call_next + $activity_log.act_rec_next}</td>
				
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
				<td>{if $activity_log.pot_mt_lost}<a class="text-success" href="client.php?status_client=1&status_action=miss&type=1">{$activity_log.pot_mt_lost}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_call_lost}<a class="text-success" href="client.php?status_client=1&status_action=miss&type=2">{$activity_log.pot_call_lost}{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_rec_lost}<a class="text-success" href="client.php?status_client=1&status_action=miss&type=3">{$activity_log.pot_rec_lost}{else}<b>0</b>{/if}</td>
				<td>{$activity_log.pot_mt_lost + $activity_log.pot_call_lost + $activity_log.pot_rec_lost}</td>
			</tr>
			<tr>
				<td>
					<div>Действия на сегодня</div>
					
				</td>
				<td>{if $activity_log.pot_mt_now}<a class="text-success" href="client.php?status_client=1&status_action=today&type=1">{$activity_log.pot_mt_now}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_call_now}<a class="text-success" href="client.php?status_client=1&status_action=today&type=2">{$activity_log.pot_call_now}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_rec_now}<a class="text-success" href="client.php?status_client=1&status_action=today&type=3">{$activity_log.pot_rec_now}</a>{else}<b>0</b>{/if}</td>
				<td>{$activity_log.pot_mt_now + $activity_log.pot_call_now + $activity_log.pot_rec_now}</td>
				
			</tr>
			<tr>
				<td>
					<div>Дальнейшие действия</div>
				</td>
				<td>{if $activity_log.pot_mt_next}<a class="text-success" href="client.php?status_client=1&status_action=next&type=1">{$activity_log.pot_mt_next}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_call_next}<a class="text-success" href="client.php?status_client=1&status_action=next&type=2">{$activity_log.pot_call_next}</a>{else}<b>0</b>{/if}</td>
				<td>{if $activity_log.pot_rec_next}<a class="text-success" href="client.php?status_client=1&status_action=next&type=3">{$activity_log.pot_rec_next}</a>{else}<b>0</b>{/if}</td>
				<td>{$activity_log.pot_mt_next + $activity_log.pot_call_next + $activity_log.pot_rec_next}</td>
				
			</tr>

		</tbody>
	</table>
</div>
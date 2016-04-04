<div id="debug">
<pre>
{$query|print_r}
</pre>
<!--
{if $REL_CRON['cron_is_native']}
	Scheduled jobs activating by native method
{else}
	Scheduled jobs activating from cron<br/>{/if}
{if !$REL_CRON.in_cleanup} 
	cleanup_not_running<br />
{/if}
{if $REL_CRON.remotecheck_disabled}
	remotecheck_disabled}
{elseif !$REL_CRON.in_remotecheck}
	remotecheck_not_running
{else}
	remotecheck_is_running
{/if}
<br/>
{sprintf("Очисток",$REL_CRON.num_cleaned)}<br />
{sprintf("Проверок","num_checked",$REL_CRON.num_checked)}<br />
Последняя очистка {mkprettytime($REL_CRON.last_cleanup,true,true)} ({get_elapsed_time($REL_CRON.last_cleanup)} назад)<br />
-->
<div align="center"><font color="red"><b>Дебаг</b></font>
<div class="copyright">{$PAGE_GENERATED}</div>
</div>
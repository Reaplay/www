<?php
global $REL_LANG, $REL_CONFIG, $REL_CACHE, $REL_SEO;
if (!defined('BLOCK_FILE')) {
	safe_redirect(" ../".$REL_SEO->make_link('index'));
	exit;
}

$block_online=$REL_CACHE->get('block_all-stats', 'queries',300);

// UPDATE CACHES:
if ($block_online===false) {
	$res=sql_query("(SELECT SUM(1) FROM client) UNION ALL
     (SELECT SUM(1) FROM client WHERE manager=0) UNION ALL
	 (SELECT SUM(1) FROM client WHERE status=0) UNION ALL
	 (SELECT SUM(1) FROM client WHERE gender=1) UNION ALL
	 (SELECT SUM(1) FROM client WHERE gender=2)
      ");

	$params = array(
'num_client',
'not_manager',
'not_client',
'male',
'female');
	foreach ($params as $param) {
		list($value) = mysql_fetch_array($res);
		$block_online[$param] = $value;
	}


	$REL_CACHE->set('block_all-stats', 'queries', $block_online);

}


// var_dump($block_online);
$num_client = $block_online['num_client'];
$not_manager = $block_online['not_manager'];
$not_client = $block_online['not_client'];
$male = $block_online['male'];
$female = $block_online['female'];


$content .= "
<table width=\"100%\" class=\"main\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
	<tr>
		<td align=\"center\">
			<table class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
				<tr>
					<td>
						<table width=\"100%\" class=\"main\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
							<tr>
								<td width=\"50%\" align=\"center\" style=\"border: none;\">
									<table class=\"main\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\">
										<tr>
											<td class=\"rowhead\">Людей в базе</td>
											<td align=\"right\">".$num_client."</td>
										</tr>
										<tr>
											<td class=\"rowhead\">Клиенты без менеджера</td><td align=\"right\">".($not_manager?$not_manager:"Нет")."</td>
										</tr>
										<tr>
											<td class=\"rowhead\">Еще не клиенты&nbsp;</td><td align=\"right\">".($not_client?number_format($not_client):"Нет")."</td>
										</tr>
										<tr>
											<td class=\"rowhead\"><font color=\"#9C2FE0\">VIP-клиенты</font></td><td align=\"right\">".($vip?number_format($vip):"Нет")."</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>";



?>
<?php
global $REL_CACHE, $REL_SEO;
if (!defined('BLOCK_FILE')) {
	safe_redirect(" ../".$REL_SEO->make_link('index'));
	exit;
}

$blocktitle = "Новости".(get_user_class() >= UC_ADMINISTRATOR ? "<font class=\"small\"> - [<a class=\"altlink\" href=\"".$REL_SEO->make_link('news')."\"><b>Добавить</b></a>]</font>" : "");

$resource = $REL_CACHE->get('block-news', 'query');

if ($resource===false) {

	$resource = array();
	$resourcerow = sql_query("SELECT * FROM news GROUP BY news.id ORDER BY news.added DESC LIMIT 3") or sqlerr(__FILE__, __LINE__);
	while ($res = mysql_fetch_array($resourcerow))
	$resource[] = $res;

	$REL_CACHE->set('block-news', 'query', $resource);
}

if ($resource) {
	//$content .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td class=\"text\">\n";
	$i=0;
	foreach($resource as $array) {
		$data_news[$i]['title'] = $array['subject'];
		$data_news[$i]['subject'] = $array['body'];
		$data_news[$i]['date'] = mkprettytime($array['added']);
		$i++;
		/*if ($news_flag == 0) {
			$content .=
      "<div class=\"sp-wrap\"><div class=\"sp-head folded clickable unfolded\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"bottom\" width=\"50%\"><i>".mkprettytime($array['added'])."</i> - <b>".$array['subject']."</b></td></tr></table></div><div style=\"display: block;\" class=\"sp-body\">".format_comment($array['body']);
			$content .="<hr/><div align=\"right\">";
			if (get_user_class() >= UC_ADMINISTRATOR) {
				$content .= "[<a href=\"".$REL_SEO->make_link('news','action','edit','newsid',$array['id'],'returno',urlencode($_SERVER['PHP_SELF']))."\"><b>E</b></a>]";
				$content .= "[<a onclick=\"return confirm('Вы уверены?');\" href=\"".$REL_SEO->make_link('news','action','delete','newsid',$array['id'],'returno',urlencode($_SERVER['PHP_SELF']))."\"><b>D</b></a>] ";
			}

			$content .= "</div></div>";
			$news_flag = 1;
		} else {
			$content .=
      "<div class=\"sp-wrap\"><div class=\"sp-head folded clickable\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"bottom\" width=\"50%\"><i>".mkprettytime($array['added'])."</i> - <b>".$array['subject']."</b></td></tr></table></div><div class=\"sp-body\">".format_comment($array['body']);
			$content .="<hr/><div align=\"right\">";
			if (get_user_class() >= UC_ADMINISTRATOR) {
				$content .= "[<a href=\"".$REL_SEO->make_link('news','action','edit','newsid',$array['id'],'returno',urlencode($_SERVER['PHP_SELF']))."\"><b>E</b></a>]";
				$content .= "[<a onclick=\"return confirm('Вы уверены?');\" href=\"".$REL_SEO->make_link('news','action','delete','newsid',$array['id'],'returno',urlencode($_SERVER['PHP_SELF']))."\"><b>D</b></a>] ";
			}
			
			$content .= "</div></div>";
		}*/
	}
	//$content .= "<p align=\"right\">[<a href=\"".$REL_SEO->make_link('newsarchive')."\">Архив новостей</a>]</p></td></tr></table>\n";
} else {

	/*$content .= "<table class=\"main\" align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"10\"><tr><td class=\"text\">";
	$content .= "<div align=\"center\"><h3>Новостей нет</h3></div>\n";
	$content .= "</td></tr></table>";*/
}
$REL_TPL->assignByRef('data_news',$data_news);

?>
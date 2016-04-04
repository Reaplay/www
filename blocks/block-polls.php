<?php
global $CURUSER, $REL_CACHE,, $REL_CONFIG;
if (!defined('BLOCK_FILE')) {
	safe_redirect(" ../".$REL_SEO->make_link('index'));
	exit;
}

if ($CURUSER) {
	$content = '';

	$id = $REL_CACHE->get('block-polls', 'id');

	if ($id===false) {
		$id = sql_query("SELECT id FROM polls ORDER BY id DESC LIMIT 1");
		$id = @mysql_result($id,0);
		$REL_CACHE->set('block-polls', 'id', $id);

	}

	if (!$id) {$content .="<h1>��� �������!</h1>".((get_user_class() >= ADMINISTARTOR)?"[<a href=\"".$REL_SEO->make_link('pollsadmin','action','add')."\">������� �����</a>]":""); } else {

		$pquestion = array();
		$pstart = array();
		$pexp = array();
		$public = array();
		$sidvalues = array();
		$votes = array();
		$sids = array();
		$votesres = array();
		$sidcount = array();
		$sidvals = array();
		$votecount = array();
		$usercode = array();
		$comments = array();


		$pollres = $REL_CACHE->get('block-polls', 'query');
		if($pollres===false){
			$poll = sql_query("SELECT polls.*, polls_structure.value, polls_structure.id AS sid,polls_votes.vid,polls_votes.user,users.username,users.class FROM polls LEFT JOIN polls_structure ON polls.id = polls_structure.pollid LEFT JOIN polls_votes ON polls_votes.sid=polls_structure.id LEFT JOIN users ON users.id=polls_votes.user WHERE polls.id = $id ORDER BY sid ASC");

			while ($pollarray = mysql_fetch_array($poll))
			$pollres[] = $pollarray;

			$REL_CACHE->set('block-polls', 'query', $pollres);
		}

		foreach($pollres as $pollarray) {
			$pquestion[] = $pollarray['question'];
			$pstart[] = $pollarray['start'];
			$pexp[] = $pollarray['exp'];
			$public[] = $pollarray['public'];
			$comments[] = $pollarray['comments'];
			$sidvalues[$pollarray['sid']] = $pollarray['value'];
			$votes[] = array($pollarray['sid'] => array('vid'=>$pollarray['vid'],'userid'=>$pollarray['user'],'username'=>$pollarray['username'],'userclass'=>$pollarray['class']));
			$sids[] = $pollarray['sid'];
		}

		$pstart = @array_unique($pstart);
		$pstart = $pstart[0];
		$pexp = @array_unique($pexp);
		$pexp = $pexp[0];
		$pquestion = @array_unique($pquestion);
		$pquestion = $pquestion[0];
		$public = @array_unique($public);
		$public = $public[0];
		$comments = @array_unique($comments);
		$comments = $comments[0];

		$sids = @array_unique($sids);
		sort($sids);
		reset($sids);


		$content .= '<div id="polls" style="width: 100% ; border:1;">
		<ul class="polls_title">
			<li style="margin:0px;"><h4 style="margin:0px; text-align: center;">����� � '.$id.'	</h4>&nbsp;&nbsp;&nbsp;&nbsp;������: '.mkprettytime($pstart).(!is_null($pexp)?(($pexp > time())?", �������������: ".mkprettytime($pexp):", <font color=\"red\">��������</font>: ".mkprettytime($pexp)):'').'</li>
		</ul>
		<ul class="polls_title_q">
			<li class="colheadli"><h3 style="margin-top: 7px;margin-bottom:0;">'.$pquestion.'</h3>'.((get_user_class() >= ADMINISTRATOR)?" <span style=\"margin-left: 335px;\">[<a href=\"".$REL_SEO->make_link('pollsadmin','action','add')."\">������� �����</a>] [<a href=\"".$REL_SEO->make_link('pollsadmin','action','edit','id',$id)."\">�������������</a>] [<a href=\"".$REL_SEO->make_link('pollsadmin','action','delete','id',$id)."\" onClick=\"return confirm('�� �������?');\">�������</a>]":"").'</span></li>
		</ul>';

		foreach ($sids as $sid)
		$votesres[$sid] = array();

		$voted=0;

		foreach($votes as $votetemp)
		foreach ($votetemp as $sid => $value)
		array_push($votesres[$sid],$value);




		foreach ($votesres as $votedrow => $votes) {

			$sidcount[] = $votedrow;
			$sidvals[] = $sidvalues[$votedrow];
			$votecount[$votedrow] = 0;
			$usercode[$votedrow] = '';

			foreach($votes as $vote) {
				//     print $votedrow."<hr />";
				//   print_r ($vote);
				$vid=$vote['vid'];
				$userid=$vote['userid'];
				$user['username']=$vote['username'];
				$user['class']=$vote['userclass'];

				//      print($vote['vid'].$vote['username'].$vote['userclass'].$vote['userid'].",");
				if ($vote['userid'] == $CURUSER['id']) $voted = $votedrow;
				if (!is_null($vid)) $votecount[$votedrow]++;

				if ((($public) || (get_user_class() >= MODERATOR)) && !is_null($vid))
				$usercode[$votedrow] .= "<a href=\"".$REL_SEO->make_link('userdetails','id',$userid,'username',$user['username'])."\">".get_user_class_color($user['class'],$user['username'])."</a>".((get_user_class() >= MODERATOR)?" [<a onClick=\"return confirm('������� ���� �����?')\" href=\"".$REL_SEO->make_link('polloverview','deletevote','','vid',$vid)."\">D</a>] ":" ");

				if (($votecount[$votedrow]) >= $maxvotes) $maxvotes = $votecount[$votedrow];

			}
		}     $tvotes = array_sum($votecount);

		@$percentpervote = 50/$maxvotes;
		if (!$percentpervote) $percentpervote=0;

		foreach ($sidcount as $sidkey => $vsid){
			@$percent = round($votecount[$vsid]*100/($tvotes));
			if (!$percent) $percent = 0;
			//$content .="<ul><dt class=\"polls_r\">";
			if ($vsid == $voted)
			$content .="<ul><li class=\"polls_r\"><b>".$sidvals[$sidkey]." - ��� �����</b>";
			elseif (((!is_null($pexp) && ($pexp > time())) || is_null($pexp)) && !$voted) $content .="<form name=\"voteform\" method=\"post\" action=\"".$REL_SEO->make_link('polloverview','vote','','id',$id)."\"><ul><li class=\"polls_r\">
  <input type=\"radio\" name=\"vote\" value=\"$vsid\" />
  <input type=\"hidden\" name=\"type\" value=\"$ptype\" />".$sidvals[$sidkey];
			else $content .= "<ul><li class=\"polls_r\">".$sidvals[$sidkey];
			$content .="</li><li class=\"polls_l\"><img src=\"./themes/{$REL_CONFIG['ss_uri']}/images/bar_left.gif\" alt=\"left\" /><img src=\"./themes/{$REL_CONFIG['ss_uri']}/images/bar.gif\" alt=\"center\" height=\"12\" width=\"".round($percentpervote*$votecount[$vsid])."%\" /><img src=\"./themes/{$REL_CONFIG['ss_uri']}/images/bar_right.gif\" alt=\"right\" />&nbsp;&nbsp;$percent%, �������: ".$votecount[$vsid]."</li></ul>";
		}
		if (((!is_null($pexp) && ($pexp > time())) || is_null($pexp)) && !$voted) $novote=true;
		if ($novote) $content .="<ul class=\"polls_f\"><li><input type=\"submit\" class=\"button\" value=\"���������� �� ���� �������!\" style=\"margin-top: 2px;\"/></li>";
		elseif (!is_null($pexp) && ($pexp < time())) $content .='<ul><li>����� ������</li>';
		elseif ($voted) $content .='<ul><li class="pollsend">�� ��� ���������� � ���� ������</li>';
		$content .='<li style="text-align:center; float:left;">����� �������: '.$tvotes.', ������������: '.$comments.' [<a href="'.$REL_SEO->make_link('polloverview','id',$id).'"><b>���������</b></a>] [<a href="'.$REL_SEO->make_link('polloverview','id',$id).'#comments"><b>��������������</b></a>] [<a href="'.$REL_SEO->make_link('pollsarchive').'"><b>����� �������</b></a>]</li></ul>'.($novote?'</form>':'');

		$content .= "</div>";
	}


} else $content = "<div align=\"center\"><h1>�������, ����� ������������ � ������</h1></div>";

?>

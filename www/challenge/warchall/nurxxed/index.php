<?php
chdir('../../../');
define('GWF_PAGE_TITLE', 'Warchall: Nurxxed');
require_once('challenge/html_head.php');
require_once GWF_CORE_PATH.'module/WeChall/solutionbox.php';
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 6, 'challenge/warchall/nurxxed/index.php');
}
$chall->showHeader();
$chall->onCheckSolution();

$home = 'http://nurxxed.warchall.net';
$war_url = GWF_WEB_ROOT.'challenge/warchall/begins/index.php';
echo GWF_Box::box($chall->lang('info', array($home, $war_url)), $chall->lang('title'));

formSolutionbox($chall, 14);
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
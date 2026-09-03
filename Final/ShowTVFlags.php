<?php
	define('debug',false);	// settare a true per l'output di debug

	require_once(dirname(dirname(__FILE__)) . '/config.php');
	if(empty($_REQUEST['TourCode']) and empty($_SESSION['TourCode'])) die('No Tournament Selected');

	$TourCode=(empty($_REQUEST['TourCode']) ? $_SESSION['TourCode'] : $_REQUEST['TourCode']);

	$JS_SCRIPT[]='<style>';

	$JS_SCRIPT[]='body {color:#0F0F0F; background-color:#D0D0D0; font-size:30px;}';
	$JS_SCRIPT[]='</style>';
	$JS_SCRIPT[]='<script type="text/javascript" src="'.$CFG->ROOT_DIR.'Common/Fun_JS.inc.js"></script>';
	$JS_SCRIPT[]='<script type="text/javascript" src="'.$CFG->ROOT_DIR.'Common/ajax/ObjXMLHttpRequest.js"></script>';
	$JS_SCRIPT[]='<script type="text/javascript" src="'.$CFG->ROOT_DIR.'Final/Fun_AJAX_ShowFlags.js"></script>';
	$JS_SCRIPT[]='<script type="text/javascript">var TourCode="'.$TourCode.'";</script>';
	$JS_SCRIPT[]='<script type="text/javascript">var minHeight="'.$_SESSION['WINHEIGHT'] .'";</script>';
	$ONLOAD=' onload="GetFlags()"';

	include('Common/Templates/head-popup.php');
	include('Common/Templates/tail-popup.php');
?>
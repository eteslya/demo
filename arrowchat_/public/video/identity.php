<?php

	/*
	|| #################################################################### ||
	|| #                             ArrowChat                            # ||
	|| # ---------------------------------------------------------------- # ||
	|| #    Copyright ©2010-2012 ArrowSuites LLC. All Rights Reserved.    # ||
	|| # This file may not be redistributed in whole or significant part. # ||
	|| # ---------------- ARROWCHAT IS NOT FREE SOFTWARE ---------------- # ||
	|| #   http://www.arrowchat.com | http://www.arrowchat.com/license/   # ||
	|| #################################################################### ||
	*/

	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php');
	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . 'init.php');

	if ($userid == 0) 
	{
		print "Content-type: text/plain\n\n<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<result>";
		print "\t<update>false</update>";
		print "</result>";
		exit;
	}

	if (!empty($_GET['username']) AND $_GET['identity'] == '0') 
	{
		print "Content-type: text/plain\n\n<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<result>";
		print "\t<update>true</update>";
		print "</result>";
	} 

	if (!empty($_GET['identity']) AND $_GET['identity'] != '0') 
	{
		print "Content-type: text/plain\n\n<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<result>";
		print "\t<update>true</update>";
		print "</result>";
	} 

	if (!empty($_GET['friends'])) 
	{
		$friend = $_GET['friends'];

		print "Content-type: text/plain\n\n<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<result>";
		print "\t<friend>\n\t\t<user>{$friend}</user>";
		
		if (!empty($chat['identity'])) 
		{
			print "\t\t<identity>{$chat['identity']}</identity>";
		}
		
		print "\t</friend>";
		print "</result>";
	}

?>
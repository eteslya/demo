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

	// ########################## GET POST DATA ###########################
	$session = @$_GET['session'];

	if (empty($session))
	{
		die("There was no session.  Please open up a new video chat session.");
	}

	// Gets the folder path without filename
	function GetFileDir($php_self) 
	{ 
		$filename = explode("/", $php_self);
		for( $i = 0; $i < (count($filename) - 1); ++$i ) 
		{ 
			$filename2 .= $filename[$i] . '/'; 
		} 
		
		return $filename2; 
	} 

	$url = "http://" . $_SERVER['SERVER_NAME'] . GetFileDir($_SERVER['PHP_SELF']);

	// ############################ START HTML ############################
	echo <<<EOD
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
	<html> 
	<head> 
	<title>Invite a user to video chat</title> 
	 
	<style> 
	html, body, div, span, applet, object, iframe,
	h1, h2, h3, h4, h5, h6, p, blockquote, pre,
	a, abbr, acronym, address, big, cite, code,
	del, dfn, em, font, img, ins, kbd, q, s, samp,
	small, strike, strong, sub, sup, tt, var,
	dl, dt, dd, ol, ul, li,
	fieldset, form, label, legend,
	table, caption, tbody, tfoot, thead, tr, th, td {
		margin: 10px;
		padding: 0;
		border: 0;
		outline: 0;
		font-weight: inherit;
		font-style: inherit;
		font-size: 100%;
		font-family: inherit;
		vertical-align: baseline;
		font-family:'Lucida	Grande',Verdana,Arial,sans-serif;
		font-size: 11px;
	}
	</style> 
	</head>
		<body>
		
			<b>Invite a user to your video</b><br />
			Copy and paste this URL to the paste you'd like to invite:<br /><br />
			
			<input type="text" style="width: 300px;" value="{$url}?rid={$session}" />

		</body>
	</html>
EOD;

?>
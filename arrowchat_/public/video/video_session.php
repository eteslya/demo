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

	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/API_Config.php');
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/OpenTokSDK.php');
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/SessionPropertyConstants.php');

	$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
	
	$session = $apiObj->create_session($room_id);
	$sessionId = $session->getSessionId();
	
	echo $sessionId;

?>
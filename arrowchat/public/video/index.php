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

	// ########################## INCLUDE BACK-END ###########################
	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php');
	require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . AC_FOLDER_INCLUDES . DIRECTORY_SEPARATOR . 'init.php');

	// ########################## GET POST DATA ###########################
	if (isset($_GET['rid'])) 
	{
		$room_id = $_GET['rid'];
	} 
	else 
	{
		$room_id = substr(number_format(time() * rand(), 0, '', ''), 0, 10);
	}

	if (strlen($room_id) == 9) 
	{
		$room_id = "0".$room_id;
	}
	
	// ########################## START SESSION ###########################
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/API_Config.php');
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/OpenTokSDK.php');
	require_once (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes/SessionPropertyConstants.php');
	
	$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
	
	if (isset($_REQUEST['rid'])) 
	{
		$sessionId = $_REQUEST['rid'];
	} 
	else 
	{
		$session = $apiObj->create_session($room_id);
		$sessionId = $session->getSessionId();
	}
	
	$api_key = API_Config::API_KEY;
	$token = $apiObj->generate_token($sessionId);

	// ############################ START HTML ############################
	echo <<<EOD
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
<head> 
<title>Video Chat</title> 
 
<style> 
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
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

object {
	float: left;
}

#videobar {
	float: top;	
}

#publisher-controls {
	display: none;
}

#push-to-talk {
	padding-top: 5px;
	display: none;
}

#devicePanelContainer {
	position: absolute;
	left: 250px;
	top: 10px;
	display:none;
}

#devicePanelCloseButton {
	position: relative;
	z-index: 10;
	margin-left: 285px;
	margin-right: 12px;
	padding: 3px;
	text-align: center;
	font-size: 11px;
	background-color: lightgrey;
}
#devicePanelBackground {
	background-color: lightgrey;
	width: 340px;
	height: 230px;
}
#devicePanelInset #devicePanel {
	position: relative;
	top: -74px;
	left: -9px;
}

a.settingsClose:link,
a.settingsClose:visited,
a.settingsClose:hover {
	text-decoration: none;
	cursor: pointer;
}

table {
	clear: both;
}

td {
	vertical-align: top;
	padding-right: 15px;
}

.publisherContainer {
	float: left;
}

.subscriberContainer {
	width: 264px;
	margin-left: 4px;
	float:left;
}

html, body {
	margin: 0px;
	padding: 0px;
	background: #000;
	overflow: hidden;
}

#navigation {
	position: fixed;
	bottom: 0px;
	background: #333;
	width: 100%;
	left: 0px;
	padding: 0px;
	display: none;
}

#navigation img {
	border: 0;
	float: right;
	margin-left: 5px;
}

#navigation_elements {
	margin: 5px;
	height: 20px;
}

#unpublishLink {
	display: none;
}

#loading {
	width: 310px;
	padding-top: 120px;
	margin: 0 auto;
	text-align: center;
}

#loading {
	width: 250px;
	padding-top: 120px;
	margin: 0 auto;
	text-align: center;
}

#canvas {
	margin: 0 auto;
	display: none;
}

#myCamera, #otherCamera {
	float: left;
}

.camera {
}

#endcall {
	width: 250px;
	padding-top: 120px;
	margin: 0 auto;
	text-align: center;
	display: none;
}
</style> 
	<script src="http://static.opentok.com/v0.91/js/TB.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			var apiKey = {$api_key};
			var sessionId = '{$sessionId}';
			var token = '{$token}';
			var session;
			var publisher;
			var subscribers = {};
			var totalStreams = 0;

			if (TB.checkSystemRequirements() != TB.HAS_REQUIREMENTS) {
				alert('Sorry, but your computer configuration does not meet minimum requirements for video chat.');
			} else {
				session = TB.initSession(sessionId);
				session.addEventListener('sessionConnected', sessionConnectedHandler);
				session.addEventListener('sessionDisconnected', sessionDisconnectedHandler);
				session.addEventListener('connectionCreated', connectionCreatedHandler);
				session.addEventListener('connectionDestroyed', connectionDestroyedHandler);
				session.addEventListener('streamCreated', streamCreatedHandler);
				session.addEventListener('streamDestroyed', streamDestroyedHandler);
			}

			function connect() {
				session.connect(apiKey, token);
			}

			function disconnect() {
				unpublish();
				session.disconnect();
				hide('navigation');
				show('endcall');
				var div = document.getElementById('canvas');	div.parentNode.removeChild(div);
				window.resizeTo(300,330);
			}

			function publish() {
				if (!publisher) {
					var parentDiv = document.getElementById("myCamera");
					var div = document.createElement('div');		
					div.setAttribute('id', 'opentok_publisher');
					parentDiv.appendChild(div);
					var params = {width: '320', height: '240'};
					publisher = session.publish('opentok_publisher', params); 	
					resizeWindow();
					show('unpublishLink');
					hide('publishLink');
				}
			}

			function unpublish() {
				if (publisher) {
					session.unpublish(publisher);
				}

				publisher = null;
				show('publishLink');
				hide('unpublishLink');
				resizeWindow();
			}

			function resizeWindow() {
				if (publisher) {
					width = (totalStreams+1)*(320+30);
					document.getElementById('canvas').style.width = (totalStreams+1)*320+'px';
				} else {
					width = (totalStreams)*(320+30);
					document.getElementById('canvas').style.width = (totalStreams)*320+'px';
				}

				if (width < 320+30) { width = 320+30; } 
				if (width < 300) { width = 300; }
				window.resizeTo(width,240+165);
			}

			function sessionConnectedHandler(event) {
				hide('loading');
				show('canvas');

				if (event.groups.length > 0) {
				    globalGroup = event.groups[0];
					// globalGroup.enableEchoSuppression();
				}

				for (var i = 0; i < event.streams.length; i++) {
					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams++;
					}
					addStream(event.streams[i]);
				}

				publish();
				resizeWindow();
				show('navigation');
				show('unpublishLink');
				show('disconnectLink');
				hide('publishLink');
			}

			function streamCreatedHandler(event) {
				for (var i = 0; i < event.streams.length; i++) {
					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams++;
					}
					addStream(event.streams[i]);
				}
				resizeWindow();
			}

			function streamDestroyedHandler(event) {
				for (var i = 0; i < event.streams.length; i++) {
					if (event.streams[i].connection.connectionId != session.connection.connectionId) {
						totalStreams--;
					}
				}
				resizeWindow();
			}

			function sessionDisconnectedHandler(event) {
				publisher = null;
			}

			function connectionDestroyedHandler(event) {
			}

			function connectionCreatedHandler(event) {
			}

			function exceptionHandler(event) {
			}

			function addStream(stream) {

				if (stream.connection.connectionId == session.connection.connectionId) {
					return;
				}

				var div = document.createElement('div');	
				var divId = stream.streamId;	
				div.setAttribute('id', divId);	
				div.setAttribute('class', 'camera');
				document.getElementById('otherCamera').appendChild(div);
				var params = {width: '320', height: '240'};
				subscribers[stream.streamId] = session.subscribe(stream, divId, params);
			}

			function show(id) {
				document.getElementById(id).style.display = 'block';
			}

			function hide(id) {
				document.getElementById(id).style.display = 'none';
			}

			function position() {
				var h = 240;

				if( typeof( window.innerWidth ) == 'number' ) {
					h = window.innerHeight;
				} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
					h = document.documentElement.clientHeight;
				} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
					h = document.body.clientHeight;
				}
				
				if (document.getElementById('canvas') && document.getElementById('canvas').style.display != 'none') {
					if (h > 240){
						offset = (h-30-240)/2;
						document.getElementById('canvas').style.marginTop = offset+'px';
					} else {
						document.getElementById('canvas').style.marginTop = '0px';
					}
				}
			}
			function inviteUser() {
				window.open ('invite.php?session='+sessionId, 'inviteusers',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=120"); 

			}
		</script>
</head>
	<body>
		<div id="loading"><img src="res/init.png"></div>
		<div id="endcall"><img src="res/ended.png"></div>
		<div id="canvas">
			<div id="myCamera" class="publisherContainer"></div>
			<div id="otherCamera"><div>
		</div>
		<div id="navigation">
			<div id="navigation_elements">
				<a href="#" onclick="javascript:disconnect();" id="disconnectLink"><img src="res/hangup.png"></a>
				<a href="#" onclick="javascript:inviteUser()" id="inviteLink"><img src="res/invite.png"></a>
				<a href="#" onclick="javascript:publish()" id="publishLink"><img src="res/turnonvideo.png"></a>
				<a href="#" onclick="javascript:unpublish()" id="unpublishLink"><img src="res/turnoffvideo.png"></a>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>
		</div>
	</body>
    <script>
		window.resizeTo(300,330);
		connect();
		window.onload = function() { position(); }
		window.onresize = function() { position(); }
	</script>
</html>
EOD;

?>
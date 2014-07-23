<?php
require_once 'bootstrap.php';
secure_page();
$c = get_data();
?>

<!doctype html>
<html lang="en">
<head>
	<title><?=SITE_NAME?>: Protected</title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="css/style.css">

	<script type="text/javascript">
		function redirect(e) {
			var con = confirm('Redirect to CodeCanyon?');
			if (con) {
				location.href = "http://codecanyon.net/item/simple-secure-login/155308";
			}
		}
	</script>

</head>
<body>

	<div id="wrapper">

		<header>
			<h2>Welcome, <?=$c->username?></h2>
			<small><?=($c->is_admin == 'Yes')?'<a href="manage_users.php">Manage Users</a> | <a href="settings.php">Settings</a> | ':'<a href="edit_profile.php">Edit Profile</a> | '?>
				<a href="?logout" title="Logout">Logout</a></small>
		</header>

		<div class="main content" role="main">

			<h3>Simple, Secure Login V<?=APP_VERSION?></h3>
			<p>
				Hello and welcome to the new and improved Simple, Secure Login V3. So your probably wondering what's new about this version?
				What makes it better than it's predecessor? Well this is now even more secure than ever. It now encrypts passwords
				using <span>SHA1</span> rather than plain old MD5. It's also secure against <span>CSRF</span> (Cross Site Request Forgery)
				attacks, for those who are  unaware of <span>CSRF Attacks</span> check out this
				<a href="http://en.wikipedia.org/wiki/Cross-site_request_forgery">CSRF</a> article on Wikipedia. We also have a new interface
				that allows administrators to Create, Read, Update and Delete users. As always this includes the user lockout, after <span><?=NUMBER_OF_ATTEMPTS?></span>
				failed login attempts the user is locked out for 20 minutes.
			</p>

			<h3>Updated Documentation</h3>
			<p>
				I have updated the documentation for <span>Simple, Secure Login</span> making it easier than ever to integrate this application into
				your product. Along with many other things such as <span>database</span> installation.
			</p>

			<h3>Who Should Buy This Product and Why?</h3>
			<p>
				It's so simple to use and install. If your looking for instant protection and minimal effort then this product is for you. Installing
				this product couldn't be easier. To protect any page simply add the following to the top of any <span>.php</span> page.
			</p>

			<code>
				<span class="red">&lt?php</span> <br>
				<span class="orange">require_once</span>
				<span class="grey">'</span><span class="green">bootstrap.php</span><span class="grey">'</span>
				<span class="orange"></span>; <br>
				<span class="grey"> secure_page<span class="orange">(</span>
				<span class="orange">)</span>;</span><br>
				<span class="red">?&gt</span>
			</code>

			<p>
				No lies, that at the top of any <span>.php</span> page and it will lock it down. How easy is that? You don't have to do nothing
				else the application will take care of the rest. Now that's why <span>PHP</span> is awesome eh? This is covered in much more
				detail in the documentation. I'll hold your hand throughout, I also cover troubleshooting too so don't worry you'll be up and
				running soon enough. Did I mention version 2 has sold just short of <span>500</span> times?
			</p>

		</div><!--/main-->

		<div class="footer">
			<p>&copy; <?=date("Y")?> - <a href="http://phpcodemonkey.com" title="Visit my Homepage">John Crossley</a></p>
		</div><!--/footer-->


	</div><!--/wrapper-->

</body>
</html>

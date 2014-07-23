<?php
require_once 'bootstrap.php';
$c = secure_page_admin();
$settings = $c->settings;
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href=" css/style.css">
  <script src="js/jquery.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/custom.js"></script>
  <script src="js/edit_users.js"></script>

  <title><?=SITE_NAME?>: Settings</title>
</head>

<body>
<div class="wrapper">

  <div class="no-js">
    <p>This application uses JavaScript to function correctly, to use this app and it's features enable JavaScript!</p>
  </div><!--/no-js-->

   <div id="feedback" class="alert"></div>

  <header>
    <h2>Settings</h2> <small><?=($c->is_admin == 'Yes')?'<a href="manage_users.php">Manage Users</a> | ':'<a href="edit_profile.php">Edit Profile</a> | '?>
        <a href="?logout" title="Logout">Logout</a></small>
  </header>

  <div class="main content" role="main">
    <h3>SSLv3 Application Settings</h3>
    <p>
      This application will be expanding on a regular basis. I have incorperated some settings for you guys to
      configure the application. <strong><em>Important!</em></strong> the application includes some fields in the
      database such as PayPal email. These are for the next revision of the application. Not to be confused now. Please
      see the <em>Changelog</em> for more information on when these features will be available.
    </p>

    <div class="a_line"></div>

    <div class="user_edit_section">

      <form>
        <div class="inputs">
          <p>
            Enable Registration:
            <select id="registration" class="status_list">
              <option value="1" <?=$c->current_status(1, $settings->allow_registration)?>>Yes allow anybody to Register</option>
              <option value="0" <?=$c->current_status(0, $settings->allow_registration)?>>No don't allow anyone to Register</option>
            </select>
          </p>

          <p class="input-block">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" placeholder="protected.php", value="<?=$settings->redirect_location?>">
            <small>The <strong>location</strong> where should the new users be redirected by default?</small>
          </p>
          <button class="button" id="save_settings">Save Settings</button>
        </div><!--//inputs-->
      </form>

    </div><!--/user_edit_section-->

  </div><!--/main-->

  <div class="footer">
    <p>&copy; <?=date("Y")?> - <a href="http://phpcodemonkey.com" title="Visit my Homepage">John Crossley</a></p>
  </div><!--/footer-->

</div><!--/wrapper-->

</body>
</html>
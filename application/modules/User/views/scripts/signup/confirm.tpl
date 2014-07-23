<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    User
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: confirm.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     Alex
 */
?>

<h2>
  <?php echo $this->translate("Thanks for joining!") ?>
</h2>

<p>
  <?php
  if( !($this->verified || $this->approved) ) {
    echo $this->translate("Welcome! A verification message has been sent to your email address with account activation instructions. Once you have clicked the link provided in the email and we have approved your account, you will be able to sign in. <br/>Please check your Junk E-mail folder just in case the confirmation email got delivered there instead of your inbox. If so, select the confirmation message and click Not Junk, which will allow future messages to get through.");
  } else if( !$this->verified ) {
    echo $this->translate("Welcome! A verification message has been sent to your email address with account activation instructions. Once you have activated your account, you will be able to sign in. <br/>Please check your Junk E-mail folder just in case the confirmation email got delivered there instead of your inbox. If so, select the confirmation message and click Not Junk, which will allow future messages to get through.");
  } else if( !$this->approved ) {
    echo $this->translate("Welcome! Once we have approved your account, you will be able to sign in.");
  }
  ?>
</p>

<br />

<h3>
  <a href="<?php echo $this->url(array(), 'default', true) ?>"><?php echo $this->translate("OK, thanks!") ?></a>
</h3>
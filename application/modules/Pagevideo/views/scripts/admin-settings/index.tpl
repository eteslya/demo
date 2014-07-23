<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Pagevideo
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: index.tpl 2010-09-20 17:53 idris $
 * @author     Idris
 */
?>

<h2><?php echo $this->translate("Page Video Plugin") ?></h2>

<?php if( count($this->navigation) ): ?>
  <div class='page_admin_tabs'>
    <?php
      // Render the menu
      //->setUlClass()
      echo $this->navigation()->menu()->setContainer($this->navigation)->render();
    ?>
  </div>
<?php endif; ?>
<div class="settings admin_home_middle">
  <?php echo $this->form->render($this); ?>
    <?php echo $this->content()->renderWidget('page.admin-settings-menu',array('active_item'=>'page_admin_main_video')); ?>

</div>

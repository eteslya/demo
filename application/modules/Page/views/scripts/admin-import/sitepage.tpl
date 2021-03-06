<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Page
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: sitepage.tpl  16.12.11 16:41 ulan t $
 * @author     Ulan T
 */
?>

<?php if( count($this->navigation) ): ?>
<div class='page_admin_tabs'>
  <?php
  echo $this->navigation()->menu()->setContainer($this->navigation)->render();
  ?>
</div>
<?php endif; ?>

<?php if( count($this->sub_navigation) ): ?>
<div class="admin_home_right">
  <ul class="admin_home_dashboard_links">
    <li style="width:200px">
      <ul >
        <?php foreach($this->sub_navigation as $item):?>
        <li class="<?php echo $item->getClass(); ?> hecore-menu-tab <?php if($item->isActive()): ?>active-menu-tab<?php endif; ?>">
          <a href="<?php echo $item->getHref() ?>">
            <?php echo $this->translate($item->getLabel()); ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>
  </ul>
</div>
<?php endif; ?>

<?php if($this->pageCount) : ?>
<div class="settings">
  <?php
  echo $this->form->render($this);
  ?>
</div>
<?php else : ?>
<div class="tip" style="clear: none;">
  <span><?php echo $this->translate("There is no pages to import"); ?></span></div>
<?php endif;?>
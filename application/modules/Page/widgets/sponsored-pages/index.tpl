<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Page
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: index.tpl 2011-11-08 17:53 taalay $
 * @author     Taalay
 */
?>

<script type="text/javascript">
  var internalTips = null;
  en4.core.runonce.add(function() {
    var options = {
      url: "<?php echo $this->url(array('action' => 'show-content'), 'like_default'); ?>",
      delay: 300,
      onShow: function(tip, element) {
        var miniTipsOptions = {
          'htmlElement': '.he-hint-text',
          'delay': 1,
          'className': 'he-tip-mini',
          'id': 'he-mini-tool-tip-id',
          'ajax': false,
          'visibleOnHover': false
        };

        internalTips = new HETips($$('.he-hint-tip-links'), miniTipsOptions);
        Smoothbox.bind();
      }
    };

    var $thumbs = $$('.sponsored-pages');
    var $mosts_hints = new HETips($thumbs, options);
  });
</script>

<?php $rand = rand(0, 10000); ?>
<div class="page_list">
  <ul>
    <?php foreach($this->pages as $page): ?>
    <li>
      <?php echo $this->htmlLink($page->getHref(), $this->itemPhoto($page, 'thumb.icon', '', array('class' => 'thumb_icon item_photo_page')), array('class' => 'page_profile_thumb item_thumb sponsored-pages', 'id' => $rand . '-page-profile_'.$page->getGuid())); ?>
      <div class="item_info">
        <div class="item_name">
          <?php echo $this->htmlLink($page->getHref(), $page->getTitle(), array('class' => 'page_profile_title')); ?><br />
        </div>
        <div class="item_description">
          <?php echo $page->getDescription(true, true, false, 30); ?>
        </div>
        <div class="clr"></div>
        <?php if (Engine_Api::_()->getDbTable('settings', 'core')->getSetting('page.show.owner', 0) == 1):?>
          <div class="item_date">
            <?php echo $this->translate("Published by"); ?> <?php echo $this->htmlLink($page->owner->getHref(), $page->owner->getTitle()); ?>
          </div>
        <?php endif;?>
      </div>
    </li>
    <?php endforeach; ?>
      <div class="create_own_page">
        <?php echo $this->htmlLink($this->url(array(), 'page_create'), $this->translate('Page_Create_Own_Page'));?>
      </div>
  </ul>
</div>
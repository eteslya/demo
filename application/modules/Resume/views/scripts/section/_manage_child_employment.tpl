<?php
/**
 * Radcodes - SocialEngine Module
 *
 * @category   Application_Extensions
 * @package    Resume
 * @copyright  Copyright (c) 2009-2010 Radcodes LLC (http://www.radcodes.com)
 * @license    http://www.radcodes.com/license/
 * @version    $Id$
 * @author     Vincent Van <vincent@radcodes.com>
 */
?>

<?php 
$child = $this->child;
$time_period = $this->partial('section/_employment_time_period.tpl', 'resume', array('employment' => $this->child));
?>

<div class="resume_sections_child_title">
  <?php echo $child->getTitle(); ?>
</div>
<div class="resume_sections_child_details">
  <div class="resume_sections_child_company">
    <?php echo $child->company; ?>
  </div>
  <div class="resume_sections_child_location">
    <?php echo $child->location; ?>
  </div>
</div>
<div class="resume_sections_child_date">
  <?php echo $time_period; ?>
</div>

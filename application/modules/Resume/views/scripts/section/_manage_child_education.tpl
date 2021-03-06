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
$p1 = array();
if ($child->concentration) $p1[] = $child->concentration;
if ($child->degree) $p1[] = $child->degree;

?>

<div class="resume_sections_child_title">
  <?php echo $child->getTitle(); ?>
</div>
<div class="resume_sections_child_details">
  <div class="resume_sections_child_major">
    <?php echo join(", ", $p1); ?>&nbsp;
  </div>
  <div class="resume_sections_child_minor">
    <?php echo $child->minor; ?>
  </div> 
</div>
<div class="resume_sections_child_date">
<?php if ($child->class_year): ?>
  <?php echo $child->class_year; ?>
<?php else: ?>
  &nbsp;  
<?php endif; ?>
</div>

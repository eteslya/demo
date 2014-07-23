
<div class="generic_layout_container layout_top">
   <?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
</div>
<div class="generic_layout_container layout_main">

   <div class="generic_layout_container layout_right">
      <?php echo $this->content()->renderWidget('ynaffiliate.mini-menu') ?>
   </div>

   <div class="generic_layout_container layout_middle">
      <div id="formborder">
      <table cellpadding="0" cellspacing="0" border="0" width="100%">
         <!--  <tr style="background:#E9F4FA none repeat scroll 0 0;">
            <th align="left" style="padding-top: 5px;padding-bottom: 5px;color:#717171;"><?php echo $this->translate('Category'); ?></th>
            <th align="left" style="padding-top: 5px;padding-bottom: 5px;color:#717171;"><?php echo $this->translate('Referred URLs'); ?></th>
         </tr>-->
         <tr>
            <td class="ynaffiliate_link" colspan="2">
             <?php echo $this->translate('You can copy this link and share it with others') ?>

            </td>
         </tr>
             <?php 
         if (count($this->suggests) > 0) :
         	foreach ($this->suggests as $suggest) : 
         		if ($suggest['href'] == '') {
         			continue;
         		}
         	if ($this->translate($suggest['suggest_title']) != "Home Page" && $this->translate($suggest['suggest_title']) != "Group Buy Home Page")
				{
         	?>
         <tr>
         	<td class = "ynaffiliate_link">
         		<span class = "ynaffiliate_account_bold">
         			<?php echo $this->translate($suggest['suggest_title']); ?>
         		</span>
         	</td>
         	<td class="ynaffiliate_link" >
         		<input class="ynaffiliate_text "type="text" style = "width: 300px;" readonly="readonly" id = "ynaffiliate_textarea" onclick="javascript:SelectAll($(this));" value = "<?php 
         			echo Engine_Api::_()->ynaffiliate()->getAffiliateUrl($suggest['href'], $this->viewer_id);
         		?>"/>
         	</td>
         </tr>
         <?php 
		 
				}
         	endforeach;
         endif;
         ?>

      </table>
   </div>
   </div>
</div>
<script type="text/javascript">
function SelectAll(id)
{
	id.focus();
    id.select();
}
</script>
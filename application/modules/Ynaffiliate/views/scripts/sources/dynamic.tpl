
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

            <tr>
               <td class="ynaffiliate_link" >
                  <?php echo $this->translate('Destination URL:') ?>                 
               </td>
            </tr>
            <tr>
               <td class="ynaffiliate_description" >                
                  <?php echo $this->translate('Please enter links within this domain:') ?>
               </td>
            </tr>

            <tr>

               <td class="ynaffiliate_link" >
                  <input id = "dynamic_target_link" style = "width: 600px" onkeyup="javascript:getAffiliateLink($('dynamic_target_link').value)" class="ynaffiliate_text" type="text" name="lname" /><?php ?>
               </td>
            </tr>
            <tr>
            <tr>
               <td class="ynaffiliate_link" >
                  <?php echo $this->translate('Referred URL:') ?>

               </td>
            </tr>

            <td class="ynaffiliate_link" >

               <input id = "dynamic_affiliate_link" onclick="javascript:SelectAll($(this));" style = "width: 600px" class="ynaffiliate_text "type="text" name="lname" /><?php ?>
            </td>
            </tr>
            <tr>
               <td>
                  <div class="tip" id ="error_message" style = "display: none">
                     <span id = "ynaff_error_message">
                        <?php echo $this->translate('The Url is not valid!'); ?>
                     </span>
                  </div>
               </td>
            </tr>


<!--     <tr id = "error_message" style = "display: none">
   <td class="ynaffiliate_error_message" id = "ynaff_error_message" style = "padding-left: 12px;">
            <?php //echo $this->translate('The Url is not valid!'); ?>
   </td>
</tr>-->
<tr> 
            <td class="ynaffiliate_link" >
               <?php echo $this->translate('You can copy and share the Referred URL with others'); ?>

            </td>
            </tr>

         </table>
      </div>
   </div>
</div>

<script type="text/javascript">
   function getAffiliateLink(target_link) {
      if (target_link != '') {
         var request = new Request.JSON(
         {
            'format' : 'json',
            'url' : en4.core.baseUrl
               + 'affiliate/sources/get-affiliate-link',
            'data' : {
               'target_link' : target_link
            },
            'onSuccess' : function(response) {
               if (response.error == 1) {
                  $('error_message').setStyle('display','block');
                  $('ynaff_error_message').set('text', response.text);
                  $('dynamic_affiliate_link').value = '';
               }
               else {
                  if ($('error_message').getStyle('display') == 'block') {
                     $('error_message').setStyle('display','none');
                  }
                  $('dynamic_affiliate_link').value = response.affiliate_url;
               }
            }
         });
         request.send();
      }
   }
   function SelectAll(id)
   {
      id.focus();
      id.select();
   }
</script>
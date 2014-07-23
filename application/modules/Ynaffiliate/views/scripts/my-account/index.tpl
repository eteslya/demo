<div class="generic_layout_container layout_top">
<?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
</div>
<div class="generic_layout_container layout_main">
	
	<div class="generic_layout_container layout_right">
		<?php echo $this->content()->renderWidget('ynaffiliate.mini-menu') ?>
	</div>
   
   <div class="generic_layout_container layout_middle">
		<div style="margin-bottom: 10px;">
      <table cellpadding="0" cellspacing="0" width="100%">
         <tr>
            <td style="width: 50%;margin-top: 8px; padding:10px 1px;" valign="top">
               <div align="left" style="">
                     <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr style="background:#E9F4FA none repeat scroll 0 0;">
                           <th align="center" style="padding-top: 5px;padding-bottom: 5px;color:#717171;"><?php echo $this->translate('Account'); ?></th>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account" >
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Gateway'); ?></span>: <?php echo $this->translate('PayPal'); ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account">
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Display Name'); ?></span>: <?php echo $this->account_name; ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account">
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Email Address'); ?></span>: <?php echo $this->account_email; ?>
                           </td>
                        </tr>
                              <tr>
                                 <td align="right" class="ynaffiliate_account">
                                    <div class="p_4">
                                       <a href="<?php echo $this->url(array('action' => 'edit'),'ynaffiliate_account') ?>" title="<?php echo $this->translate('Edit Account'); ?>" ><button  name="edit_account"><?php echo $this->translate('Edit Account'); ?></button></a>

                                    </div>
                                 </td>
                              </tr>
                     </table>
               </div>
             
            </td>
            <td style="width: 50%;margin-top: 8px;vertical-align: top;">
               <div  align="right" style="padding-left:30px; padding-top:10px">
                  <table cellpadding="0" cellspacing="0" border="0" width="90%">
                     <tr style="background:#E9F4FA none repeat scroll 0 0;">
                        <th align="center" style="padding-top: 5px;padding-bottom: 5px;color:#717171;"><?php echo $this->translate('Summary'); ?> </th>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Available Points'); ?></span>:
                        	<span id="current_request_money" style="color: blue;font-weight: bold;">
                              		<?php  echo $this->availablePoints;?>
                           </span> 
                        </td>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Current Request'); ?></span>: 
                           <span id="current_request_money" style="color: blue;font-weight: bold;">
                              		<?php  echo $this->currentRequestPoints;?>
                           </span> 
                        </td>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Currency');   ?></span>: 
                           <span id="current_request_money" style="color: blue;font-weight: bold;">
  		 							<?php  echo $this->currency;?>
  		 				   </span> 
                        </td>
                     </tr>
                     <tr>
                        <td align="right" class="ynaffiliate_account">
                           <div class="p_4">
                              <div style="float:left; padding-right: 10px;">
                                 <?php 
                                    if ($this->account_email == ''): ?>  
                                       <?php echo $this->translate("Please provide PayPal account!"); ?>
                                 <?php else: ?>
                                 	<?php if ($this->is_admin == 1) : ?>
                                 		<?php echo $this->translate("You cannot make request!"); ?>
                                 	<?php else: ?>
                                       <a class="smoothbox" href="<?php echo $this->url(array('user_id' => '1'), 'ynaffiliate_payment_threshold') ?>" title="<?php echo $this->translate('Request'); ?>" ><button  name="request"><?php echo $this->translate('Request'); ?></button></a>
                                    <?php endif;?>   
                                 <?php endif; ?>
                              </div>    
  
                           </div>
                        </td>
                     </tr>
                  </table>
                  <div align="left" style="">
                     <a href="javascript:showDetail()"><?php echo $this->translate('View details'); ?></a>
                  </div>
                  <script type="text/javascript">
                     function showDetail() {
                        if ($('requestdetail').getStyle('display') == "none") {
                           $('requestdetail').show();
                        }
                        else if  ($('requestdetail').getStyle('display') == "block") {
                           $('requestdetail').hide();
                        }
                     }
                  </script>
                  <table id = "requestdetail" cellpadding="0" cellspacing="0" border="0" width="90%" style="display: none">
                     <tr style="background:#E9F4FA none repeat scroll 0 0;">
                        <th align="center" style="padding-top: 5px;padding-bottom: 5px;color:#717171; width: 400px"><?php echo $this->translate('Details'); ?> </th>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Points Conversion Rate'); ?></span>: 
                           <span id="current_money" style="color: red;font-weight: bold;" > 
                           		<?php 
                           			$baseCurrency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
                           			$points_convert_rate = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1);
									echo $this->translate('1 '.$baseCurrency.' = '.$points_convert_rate." ".'point(s)');?> </span> 
                        </td>
                        </tr>
                        <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Total Points'); ?></span>: 
                           <span id="current_money" style="color: red;font-weight: bold;" > <?php echo $this->totalPoints; ?> </span> 
                        </td>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Received Points'); ?></span>: 
                           <span id="current_money_money" style="color: red;font-weight: bold;"><?php echo $this->requestedPoints; ?></span>  
                        </td>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Minimum Request Points'); ?></span>: <span style="color: red;font-weight: bold;"> <?php echo $this->minRequest;  ?>  </span>
                        </td>
                     </tr>
                     <tr>
                        <td class="ynaffiliate_account" align="left">
                           <span class="ynaffiliate_account_bold"><?php echo $this->translate('Maximum Request Points'); ?></span>: <span style="color: red;font-weight: bold;"> <?php echo $this->maxRequest;  ?> </span>
                        </td>
                     </tr>
                  </table>
               </div>
            </td>
         </tr>
      </table>
   </div>
	</div>
</div>

<style type="text/css">
  .p_4 a:hover{
      text-decoration: none;
   }
</style>
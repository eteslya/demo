
<div class="generic_layout_container layout_top">
<?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
</div>
<div class="generic_layout_container layout_main">
	
	<div class="generic_layout_container layout_right">
		<?php echo $this->content()->renderWidget('ynaffiliate.mini-menu') ?>
	</div>
   
   <div class="generic_layout_container layout_middle">
       <h3><?php // echo $this->translate("Affiliate Statistic") ?></h3>
		<?php //echo $this->form->render($this); ?>
       <br />
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr style="background:#E9F4FA none repeat scroll 0 0;">
                           <th align="center" style="padding-top: 5px;padding-bottom: 5px;color:#717171;"><?php echo $this->translate('Affiliate Statistic'); ?></th>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account" >
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Number of subscriptions'); ?></span>: 
                              	<?php  echo $this->locale()->toNumber($this->subscriptions);?>
                           </td>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account">
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Number of Purchases'); ?></span>: 
                              <?php  echo $this->locale()->toNumber($this->purchases)?>
                           </td>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account">
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Commission Points'); ?></span>: 
                              <?php  echo $this->locale()->toNumber($this->commissionPoints);?>
                           </td>
                        </tr>
                        <tr>
                           <td class="ynaffiliate_account">
                              <span class="ynaffiliate_account_bold"><?php echo $this->translate('Requested Points'); ?></span>: 
                              <?php echo $this->locale()->toNumber($this->requestedPoints);?>
                    
                           </td>                            

                     </table>
	</div>
</div>
<div class="headline">
  <h2>
    <?php echo $this->translate('GroupBuy');?>
  </h2>
  <div class="tabs">
    <?php
      // Render the menu
      echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
    ?>
  </div>
</div>
<?php
 	$item = $this->deal;      
?> 
<script type="text/javascript"> 
var fr  = null;
var is_already = true;
 function makeBill(f)
{
	total_fee_again = '<?php 
	  $deal = Engine_Api::_()->getItem('deal', $item->deal_id);
	echo $deal->total_fee?>';
	$('amount').value = total_fee_again;
    if($('amount1'))
        $('amount1').value = total_fee_again; 
    if(f == null || f == undefined && is_already == false){     
      fr.submit();
       
    }else{
         fr =  f;
         is_already = false;
         new Request.JSON({
          url: '<?php echo $this->url(array("module"=>"groupbuy","controller"=>"index","action"=>"makebill"), "default") ?>',
          data: {
            'format': 'json',
            'deal' : <?php echo $item->deal_id; ?>
          },
          'onComplete':function(responseObject)
            {  
                makeBill();
            }
        }).send();
        return false; 
    }   
    return true;
}
 </script>
 <?php 
 $viewer = Engine_Api::_()->user()->getViewer(); 
 $account = Groupbuy_Api_Cart::getFinanceAccount($viewer->getIdentity(),2);
 if($account['account_username'] == ''): ?>
    <div class="tip" style="clear: inherit;">
      <span>
      <?php echo $this->translate('You can not publish this deal. '); ?>
      <a href="<?php echo $this->url(array('action'=> 'edit'),'groupbuy_account'); ?>">
      <?php echo $this->translate('Click here'); ?></a> <?php echo $this->translate('  to add seller account.'); ?>
    </span>
           <div style="clear: both;"></div>
 </div>
<?php elseif($this->canSell == true):?>
  <h2>
    <?php echo $this->translate('Deal information');?>
  </h2>
<div class="table">    
                <table width="100%">
                      <tr>
                          <td valign='top' width='1' style=' text-align: center; padding-top:6px;  padding-bottom:6px; text-align: center;'>
                           <a href="<?php echo $item->getHref()?>" title="<?php echo $item->title?>"><img src="<?php if($item->getPhotoUrl("thumb.normal") != ""): echo $item->getPhotoUrl("thumb.normal"); else: echo 'application/modules/Groupbuy/externals/images/nophoto_deal_thumb_profile.png'; endif;?>" style = "max-width:200px;max-height:150px" /></a>
                        </td>
                      <td valign='top' class="contentbox" style="width: auto; padding-left: 30px;">
                      <strong id="title"><?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?> </strong>
                         <div id="body" style="padding-top:5px;" class="auction_list_description">
                          <?php echo substr(strip_tags($item->description), 0, 350); if (strlen($item->description)>350) echo "..."; ?>
                          </div>
                          <?php 
                          $user = Engine_Api::_()->user()->getViewer();
                          $freeF = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('groupbuy_deal', $user, 'free_fee');
                           $freeP = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('groupbuy_deal', $user, 'free_display');
                           if($freeP == 1 && $freeF == 1):
                              $item->total_fee = 0;  
                           endif;
                          ?> 
                         <?php if($item->total_fee > 0): ?>
                       <div style="padding-top:5px;" >
                       <span style="font-weight: bold;"> <?php echo $this->translate('Total fee: ');?></span> <font color="red" style="font-weight: bold;"><?php echo $this->currencyadvgroup($item->total_fee,Engine_Api::_()->groupbuy()->getDefaultCurrency());?> <?php //echo $item->currency ?></font>
                       </div>
                      
                       <?php endif; ?>
                        <div style="padding-top: 5px;">
                       <span style="font-weight: bold;"><?php echo $this->translate('Available Amount: ') ?></span><font color="red" style="font-weight: bold;" ><?php //echo $itcurrency->symbol;?><span id="current_amount"><?php echo $this->currencyadvgroup($this->current_amount, $item->currency);?> </span> <?php //echo $item->currency ?></font>
                       </div>
                        <br/>
                        <?php if($item->total_fee > 0): ?>
                         <?php $virtual = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.virtualmoney', 0);
                         $currency = Engine_Api::_()->groupbuy()->getDefaultCurrency();  
                            if ($virtual == 1 && $this->current_amount >= $item->total_fee && $currency == $this->currency) : ?>   
                                 
                                <form onsubmit="return check();" action="<?php echo $this->url(array('action'=>'publishmoney', 'deal' => $item->deal_id),'groupbuy_general') ?>" method="POST" name="cart_form">
                                   <button  name="buydeal" id = "virtualmoney" type="submit" style="border-right: 1px solid #ccc; float: left; width: 120px; margin-left: -5px;margin-top: 4px" title="<?php echo $this->translate('Pay with account money');?>" >
                                     <a href="javascript:;" style="text-decoration: none;"> 
                                           <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                           <img style="padding-left: 5px; margin-top: -4px;" src="./application/modules/Groupbuy/externals/images/icon_money.png" alt="">
                                     </a>
                                   </button>
                                   <input TYPE="hidden" id="amount1" NAME="amount1" VALUE="<?php echo $item->total_fee;?>"/> 
                               </form>
                                  
                           <?php endif;?>
                        <form action="<?php echo $this->paymentForm;?>" method="post" name="cart_form" onsubmit="return makeBill(this);">
                        <div class="p_4">
                           <?php $method = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.adminmethod', 0);
                                    if ($method == 1 || $method == 0) : ?>           
                           <button  name="minh" type="submit" style="float: none; width: 137px; margin-left: -5px;" title="<?php echo $this->translate('Pay with Paypal');?>" >
                             <a  href="javascript:;" style="text-decoration: none;"> 
                                <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                <img style="padding-left: 5px; margin-top: -4px;" src="./application/modules/Groupbuy/externals/images/icon_paypal.png" alt="">
                             </a>
                           </button>
                           <input TYPE="hidden" NAME="cmd" VALUE="_xclick"/>
                           <input TYPE="hidden" NAME="business" VALUE="<?php echo $this->receiver['email']?>"/>
                           <input TYPE="hidden" id = "amount" NAME="amount" VALUE="<?php echo $item->total_fee;?>"/>
                           <input TYPE="hidden" NAME="currency_code" VALUE="<?php echo Engine_Api::_()->groupbuy()->getDefaultCurrency();?>"/>
                           <input TYPE="hidden" NAME="description" VALUE="Pay auction"/>
                           <input type="hidden" name="notify_url" value="<?php echo $this->paramPay['ipnNotificationUrl']?>"/>
                           <input type="hidden" name="return" value="<?php echo $this->paramPay['returnUrl']?>"/>
                           <input type="hidden" name="cancel_return" value="<?php echo $this->paramPay['cancelUrl']?>"/>
                           <input type="hidden" name="no_shipping" value="1"/>
                           <input type="hidden" name="no_note" value="1"/>
                            <?php endif;?>     
                        </div>
                    </form>    
                    <?php else: ?>
                    <form action="<?php echo $this->url(array('action'=>'publish-free', 'deal' => $item->deal_id),"groupbuy_general") ?>" method="POST" name="cart_form">
                    <button class="p_4" style="width: 127px; text-decoration: none; margin-left: -8px" title="<?php echo $this->translate('Publish free');?>">
                           <span class="icon_groupbuy_publish" name="publish" type="submit" style="float: left; height: 26px; display: block; margin-top: -3px" title="<?php echo $this->translate('Publish free');?>" > </span>
                           <a style="text-decoration: none;" href="<?php echo $this->url(array('action'=>'publish-free', 'deal' => $item->deal_id),"groupbuy_general") ?>" >
                           <?php echo $this->translate('Publish free');?>
                           </a>  
                           </button>
                    </form>
                    <?php endif; ?>
                    </br>
                     <div style="margin-top: 7px; *margin-left: -5px; margin-top: 5px; line-height: 25px;">
                           <?php echo $this->htmlLink(array(
                              'action' => 'manage-selling',
                                'route' => 'groupbuy_general',
                            ), $this->translate('Cancel'), array(
                              'style' => 'font-weight: bold; text-decoration: none;',
                              'class'=>'icon_groupbuy_back'
                            )) ?>
                            </div>
                    </td>           
                </tr>
                </table>
 </div>
 <?php else: ?>
 <div class="tip" style="clear: inherit;">
      <span>
<?php  echo $this->translate('You can not publish this deal!');?>
 </span>
           <div style="clear: both;"></div>
    </div>
 <?php endif; ?>
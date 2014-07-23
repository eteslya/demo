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
  function selfURL() {
     $server_array = explode("/", $_SERVER['PHP_SELF']);
      $server_array_mod = array_pop($server_array);
      if($server_array[count($server_array)-1] == "admin") { $server_array_mod = array_pop($server_array); }
      $server_info = implode("/", $server_array);
	  $http = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://'	;
      return $http.$_SERVER['HTTP_HOST'].$server_info."/";
 } 
 $item = $this->deal;
 $itcurrency = $item->getCurrency();      
	$precision = $itcurrency->precision;
 ?> 
<script type="text/javascript"> 
var fr  = null;
var is_already = true;
function update(numbers){
		var final_price = <?php echo $item->final_price?>;
		var total 		= numbers * final_price;
		total = total.toFixed(<?php echo $precision ?>);
		
		// check and update status of value.		
		if($('number')){
			$('number').value = numbers;
		}		
		
		// update amount of COD
		if($('number_buy')){
            $('number_buy').value = numbers;  
		}
		if($('number_buy1')){
            $('number_buy1').value = numbers;  
        }
		if($('total_amount')){
            $('total_amount').value = total;
		}
        if($('total_amount1')){
            $('total_amount1').value = total;
        }
		
		// update total value of this bill.
		if($('total')){
			$('total').innerHTML = total;	
		}
		
		// update TOTAL AMOUNT of PAYPAL
		if($('amount')){
            //$('amount').value = total; 
        }
        if($('amount2')){
            $('amount2').value = total;
            $('quantity').value = numbers;
		}
        if($('amount1')){
            $('amount1').value = total;
        }
        if($('virtualmoney'))
        {
            if(total > <?php echo $this->current_amount ?>)
            {
                 $('virtualmoney').style.display = 'none';
            }
            else
            {
                $('virtualmoney').style.display = 'block';
            }
        }
        if($('quantity_paypal'))
        {
            $('quantity_paypal').value = numbers;
        }
	}
function makeBill(f,payment){
	
    var numbers = $('number').value;
	var maxbought = '<?php echo $item->max_bought;?>';
	if (maxbought != 0) { 
		var checkbought = '<?php echo $item->getMaxBought($this->viewer)?>';
		if  (checkbought == 0) {
			alert("You have bought maximum quatity allowed. You cannot buy this deal anymore");
			update(0);
			if ($('buygift')) {
				$('buygift').hide();
			}
			if ($('paypalbutton')) {
				$('paypalbutton').hide();
			}
			if ($('codbutton')) {
				$('codbutton').hide();
			}
			return false;
		}
	}
    if(numbers == "")
    {
    	update(1);
        alert('<?php echo $this->translate("Quantity must be 1 or more; we took care of that for you.!") ?>');
        return false;
    }
    else
    {
    	update(numbers);
    }
    if(f == null || f == undefined && is_already == false){     
      fr.submit();
       
    }else{
         fr =  f;
         is_already = false;
         new Request.JSON({
          url: '<?php echo $this->url(array("module"=>"groupbuy","controller"=>"index","action"=>"makebill-buy"), "default") ?>',
          data: {
            'format': 'json',
            'deal' : <?php echo $item->deal_id; ?>,
            'numbers' : parseInt(numbers),
            'payment' : payment
          },
          'onComplete':function(responseObject)
            {  
            	//alert('finish');
                makeBill();
            }
        }).send();
        return false; 
    }   
    return true;
}

function check()
{
    var numbers = $('number').value;
    if(numbers != "")
    {
    	update(numbers);	
        return true;
    }
    else
    {
    	update(1);
        alert('<?php echo $this->translate("Quantity must be 1 or more; we took care of that for you.!") ?>');
        return false;
    }
}
 
function numberChange(msg)
{
	function showMessage(text){
		if(!msg){alert(text);}
	}
    var numbers = $('number').value;

    if(numbers != "")
    {
        if(isNumber(numbers))
        {
          numbers = parseInt(numbers);
		  $('number').value = numbers;
		    if(numbers <= 0 || $('number').value == '')
            {
               update(1);
               showMessage('<?php echo $this->translate("Quantity must be 1 or more; we took care of that for you.!") ?>');
            }
			else
            {
				var maxbought = '<?php echo $item->max_bought;?>';
				if (maxbought != 0) { 
					var checkbought = '<?php echo $item->getMaxBought($this->viewer)?>';
					if  (checkbought == 0) {
						showMessage("You have bought maximum quatity allowed. You cannot buy this deal anymore");
						update(0);
						if ($('buygift')) {
							$('buygift').hide();
						}
						if ($('paypalbutton')) {
							$('paypalbutton').hide();
						}
						if ($('codbutton')) {
							$('codbutton').hide();
						}
					}
					else {
						if (numbers > checkbought) {	
							showMessage("You can only buy " + checkbought + " more deals!");
							update(checkbought);
						}
						else {
							update(numbers);
						}
					}
				}
				else {
					var maxsold = '<?php echo $item->max_sold;?>';
					var currentsold = '<?php echo $item->current_sold;?>';
					var leftsold = maxsold - currentsold;
					if (numbers > leftsold) {	
						showMessage("You can only buy " + leftsold + " more deals!");
						update(leftsold);
					}
					else {
						update(numbers);
					}
				}
            }
		  
		}
        else
        {
        	update(1);
        	showMessage('<?php echo $this->translate("Number of quantity is invalid!") ?>');
        }
    }
    else 
    {
    	$('total').innerHTML = 0;
    	$('amount').value = 0;
    }
}
function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

 </script>
 <?php if($this->canBuy == true && $item->status == 30 && $item->published == 20):?>
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
                       <div style="padding-top:5px;" >
                       <span style="font-weight: bold;"> <?php echo $this->translate('Price: ');?></span> <font color="red" style="font-weight: bold;" ><span id="price"><?php echo  $this->currencyadvgroup($item->price,$item->currency);?> </span><?php // echo $item->currency ?></font>
                       </div>
                       <div style="padding-top:5px;" >
                       <span style="font-weight: bold;"> <?php echo $this->translate('VAT: ');?></span> <font color="red" style="font-weight: bold;" ><span id="price"><?php echo  $item->vat?> </span>%</font>
                       </div>
                       <div style="padding-top:5px;" >
                       <span style="font-weight: bold;"> <?php echo $this->translate('Final Price: ');?></span> <font color="red" style="font-weight: bold;" ><span id="price"><?php echo  $this->currencyadvgroup($item->final_price,$item->currency);?> </span><?php //echo $item->currency ?></font>
                       </div>
                       <div style="padding-top: 5px;">
                       <span style="font-weight: bold;"><?php echo $this->translate('Quantity: ') ?></span><input onkeyup="numberChange(0)" onblur="numberChange(1)" type="text" id="number" value="1"/>
                       </div>
                       <div style="padding-top: 5px;">
                       <span style="font-weight: bold;"><?php echo $this->translate('Total: ') ?></span><font color="red" style="font-weight: bold;" ><?php echo $itcurrency->symbol;?><span id="total"><?php echo $this->currencyadvgroup($item->final_price, $item->currency);?> </span> <?php //echo $item->currency ?></font>
                       </div>
                       <div style="padding-top: 5px;">
                       <span style="font-weight: bold;"><?php echo $this->translate('Available Amount: ') ?></span><font color="red" style="font-weight: bold;" ><?php //echo $itcurrency->symbol;?><span id="current_amount"><?php echo $this->currencyadvgroup($this->current_amount, $this->currency);?> </span> <?php //echo $item->currency ?></font>
                       </div>
                        <br/>
                        <?php if($item->price > 0 && $item->status == 30 && $item->published == 20): ?>
                           <?php  if ($item->method == 1 || $item->method == 0) : ?>	
	                        	<?php if ( !isset($_SESSION['buygift']['buygift']) || ($_SESSION['buygift']['buygift'] != 1) ):?>                  
                                    <button style="float:left; width: 141px; margin-top: 8px; background: url('./application/modules/Groupbuy/externals/images/icon_for_friend.png') no-repeat 0% 50%; padding-left: 26px;" id="buygift" title="<?php echo $this->translate('Buy for Friend') ?>">
                                    <a  href="javascript:;" style="text-decoration: none;"> 
                                    <span style="display: block; float: left;">
                                    <?php echo $this->translate('Buy for Friend') ?> 
                                    </span>
                                    </a>
                                   </button>
			                        <script type="text/javascript">
									  $('buygift').addEvent('click', function(){
									    var sb_url = '<?php echo $this->url(array('deal_id'=> $item->deal_id,'action'=>'buygift','numberbuy' => 'nbbuy'), 'groupbuy_general', true)?>';
										var str_sb_url = sb_url.replace('nbbuy', $('number').value);
									    Smoothbox.open(str_sb_url);
									  });
									  </script>
                                      
                                          <?php $method = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.adminmethod', 0);
                                            $paypal_active = Groupbuy_Api_Gateway::getActiveGateway('Paypal');
                                            if (($method == 1 || $method == 0) && $paypal_active && ($item->method == 1 || $item->method == 0)) : ?>         
                                            <form action="<?php echo $this->paymentForm;?>" method="post" name="cart_form" onsubmit="return makeBill(this,'Paypal');">
                                            <div class="p_4">
                                               <button  name="minh" type="submit" id = "paypalbutton" style="float: left; width: 137px;margin-top:4px; background-image: url('./application/modules/Groupbuy/externals/images/icon_paypal.png');background-repeat:no-repeat;background-position: 100% 50%;margin-right: 15px;"  title="<?php echo $this->translate('Pay with Paypal.');?>">
                                                <a  href="javascript:;" style="text-decoration: none;"> 
                                               <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                               </a>
                                               </button>
                                               
                                               <input TYPE="hidden" NAME="cmd" VALUE="_xclick"/>
                                               <input TYPE="hidden" NAME="business" VALUE="<?php echo $this->receiver['email']?>"/>
                                               <input TYPE="hidden" id="amount" NAME="amount" VALUE="<?php echo $item->final_price;?>"/>
                                               <input TYPE="hidden" NAME="currency_code" VALUE="<?php echo $item->currency;?>"/>
                                               <input TYPE="hidden" NAME="description" VALUE="Pay auction"/>
                                               <input type="hidden" id = "item_name" name="item_name" value="<?php echo $item->title  ?>">
                                               <input type="hidden" id = "quantity_paypal" name="quantity" value="1">
                                               <input type="hidden" name="notify_url" value="<?php echo $this->paramPay['ipnNotificationUrl']?>"/>
                                               <input type="hidden" name="return" value="<?php echo $this->paramPay['returnUrl']?>"/>
                                               <input type="hidden" name="cancel_return" value="<?php echo $this->paramPay['cancelUrl']?>"/>
                                               <input type="hidden" name="no_shipping" value="1"/>
                                               <input type="hidden" name="no_note" value="1"/>
                                               
                                               
                                            </div>
                                             
                                        </form>
                                         <?php endif;?>      
                                      
								<?php else: ?>
                                
									<p class="icon_gift">
										<strong style = "padding-left: 40px;">
										<?php echo $this->translate('Gift for: '); echo $_SESSION['buygift']['friend_name'];?>
										</strong>
									</p>
									
									<div style = "padding-top: 5px;padding-bottom: 5px;">
									<span>
									<?php // echo $this->htmlLink(array('route'=>'groupbuy_general','action'=>'editgift'), $this->translate('Edit'), array(
	                //  'class'=>'smoothbox',
	                //)) ?>
	                				<a id ="editgiftinfo" style ="color: #5F93B4; cursor:pointer" ><?php echo $this->translate('Edit');?></a>
												                        <script type="text/javascript">
									  $('editgiftinfo').addEvent('click', function(){
									    var sb_url = '<?php echo $this->url(array('action'=>'editgift','numberbuy' => 'nbbuy'), 'groupbuy_general', true)?>';
										var str_sb_url = sb_url.replace('nbbuy', $('number').value);
									    Smoothbox.open(str_sb_url);
									  });
									  </script>
									</span>
									|
									<span>
									<?php echo $this->htmlLink(array(
	                                      'action' => 'deletegift',
	                                      'route' => 'groupbuy_general',
	                                      ), $this->translate('Cancel'), array(
	                                      'class' => 'smoothbox',
	                                    )) ?>
									</span>
									</div>
                                            <?php $method = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.adminmethod', 0);
                                            $paypal_active = Groupbuy_Api_Gateway::getActiveGateway('Paypal');
                                            if (($method == 1 || $method == 0) && $paypal_active && ($item->method == 1 || $item->method == 0)) : ?>         
                                            <form action="<?php echo $this->paymentForm;?>" method="post" name="cart_form" onsubmit="return makeBill(this,'Paypal');">
                                            <div class="p_4">
                                               <button  name="minh" type="submit" id = "paypalbutton" style="float: left; width: 137px; border-left: none; background-image: url('./application/modules/Groupbuy/externals/images/icon_paypal.png');background-repeat:no-repeat;background-position: 100% 50%;margin-right: 15px;"  title="<?php echo $this->translate('Pay with Paypal.');?>">
                                                <a  href="javascript:;" style="text-decoration: none;"> 
                                               <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                               </a>
                                               </button>
                                               
                                               <input TYPE="hidden" NAME="cmd" VALUE="_xclick"/>
                                               <input TYPE="hidden" NAME="business" VALUE="<?php echo $this->receiver['email']?>"/>
                                               <input TYPE="hidden" id="amount" NAME="amount" VALUE="<?php echo $item->final_price;?>"/>
                                               <input TYPE="hidden" NAME="currency_code" VALUE="<?php echo $item->currency;?>"/>
                                               <input TYPE="hidden" NAME="description" VALUE="Pay auction"/>
                                               <input type="hidden" id = "item_name" name="item_name" value="<?php echo $item->title  ?>">
                                               <input type="hidden" id = "quantity_paypal" name="quantity" value="1">
                                               <input type="hidden" name="notify_url" value="<?php echo $this->paramPay['ipnNotificationUrl']?>"/>
                                               <input type="hidden" name="return" value="<?php echo $this->paramPay['returnUrl']?>"/>
                                               <input type="hidden" name="cancel_return" value="<?php echo $this->paramPay['cancelUrl']?>"/>
                                               <input type="hidden" name="no_shipping" value="1"/>
                                               <input type="hidden" name="no_note" value="1"/>
                                               
                                               
                                            </div>
                                             
                                        </form>
                                         <?php endif;?>  
									<?php endif;?>
                                    
                                <?php $Checkout_active = Groupbuy_Api_Gateway::getActiveGateway('2Checkout'); 
                                $setting_checkout = Groupbuy_Api_Gateway::getSettingGateway('2Checkout');
                                if (($method == 3 || $method == 0) && ($item->method == 3 || $item->method == 0) && $Checkout_active && $setting_checkout['currency'] == $item->currency) : 
                                $settings = Groupbuy_Api_Cart::getSettingsGateWay('2Checkout');
                                ?>
                                 <form action="https://www.2checkout.com/checkout/spurchase" method="post" onsubmit="return makeBill(this,'2Checkout');">
                                        <p>
                                            <input type="hidden" name="sid" value="<?php echo $setting_checkout['admin_account'] ?>"/>
                                            <input type="hidden" name="product_id1" value="<?php echo $item->deal_id;?>"/>
                                            <input type="hidden" id="quantity" name="quantity1" value="1"/>
                                            <input type="hidden" name="cart_order_id" value="<?php echo $item->deal_id;?>"/>     
                                            <input type="hidden" name="currency" value="<?php echo $item->currency;?>"/>
                                            <input type="hidden" id="amount2" name="total" value="<?php echo $item->final_price;?>"/>
                                            <input type="hidden" name="demo" value="<?php echo $settings['env'];?>"/>
                                            <input type="hidden" name="x_receipt_link_url" value="<?php echo str_replace('callback','callback2Checkout',$this->paramPay['ipnNotificationUrl']);?>"/>
                                            <input type="hidden" name="merchant_order_id" value="Order ID: <?php echo $item->deal_id;?>"/>
                                            <input type="hidden" name="id_type" value="1"/>
                                            <input type="hidden" name="lang" value="en"/>

                                            <button  name="checkout" type="submit" id = "checkoutbutton" style="float: left; width: 119px; " title="<?php echo $this->translate('Pay with 2Checkout');?>" >
                                            <a href="javascript:;" style="text-decoration: none;"> 
                                            <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                            <img style="padding-left: 5px; margin-top: -2px;" src="./application/modules/Groupbuy/externals/images/icon_2co.png" alt="">
                                             </a>
                                            </button>
                                        </p>
                                    </form> 
                                    <?php endif;?>  
                                   <?php $virtual = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.virtualmoney', 0);
                                   if (($item->method == 4 || $item->method == 0) && $virtual == 1 && $this->current_amount >= $item->final_price && $item->currency == $this->currency ) : ?>   
                                 
                                        <form onsubmit="return check();" action="<?php echo selfURL() ?>group-buy/accountmoney/deal/<?php echo $item->deal_id  ?>" method="POST" name="cart_form">
                                       
                                           <button  name="buydeal" id = "virtualmoney" type="submit" style="float: left; width: 120px;" title="<?php echo $this->translate('Pay with account money');?>">
                                            <a href="javascript:;" style="text-decoration: none;"> 
                                           <span style="display: block; float: left;"><?php echo $this->translate('Pay with');?></span>
                                           <img style="padding-right: 5px; margin-top: -4px;" src="./application/modules/Groupbuy/externals/images/icon_money.png" alt="">
                                            </a>
                                           </button>
                                           <input TYPE="hidden" id="total_amount1" NAME="total_amount1" VALUE="<?php echo $item->final_price;?>"/> 
                                           <input TYPE="hidden" id="number_buy1" NAME="number_buy1" VALUE="1"/>
                                           <input TYPE="hidden" id="amount1" NAME="amount1" VALUE="<?php echo $item->final_price;?>"/>
                                       </form>
                                  
                                   <?php endif;?>
			                    <?php endif;?>
				                    <?php if ( (!isset($_SESSION['buygift']['buygift']) || ($_SESSION['buygift']['buygift'] != 1)) && ($item->method == 0 || $item->method == 2) ) :?>
				                     <form onsubmit="return check();" action="<?php echo selfURL() ?>group-buy/delivery/deal/<?php echo $item->deal_id  ?>" method="POST" name="cart_form">
				                           <button class="icon_groupbuy_cod"  name="publish" id = "codbutton" type="submit" style="float: left; background: url(./application/modules/Groupbuy/externals/images/icon_cod.png) no-repeat 5px 5px; padding-left:35px;" title="<?php echo $this->translate('Cash on Delivery');?>" >
                                          <a  href="javascript:;" style="text-decoration: none;"> 
                                            <span style="display: block; float: left;">
                                            <?php echo $this->translate('Cash on Delivery');?>      
                                            </span>
                                            </a>
                                           </button>
				                       <input TYPE="hidden" id="total_amount" NAME="total_amount" VALUE="<?php echo $item->final_price;?>"/> 
				                       <input TYPE="hidden" id="number_buy" NAME="number_buy" VALUE="1"/> 
				                       <input TYPE="hidden" id="amount" NAME="amount" VALUE="<?php echo $item->final_price;?>"/>
				                    </form>
				                    
				                   <?php endif;?>
                    <?php else: ?>
                    <?php if ($item->method == 2 || $item->method == 0) : ?>	
                    <form action="<?php echo selfURL() ?>group-buy/delivery/deal/<?php echo $item->deal_id  ?>" method="POST" name="cart_form">
                           <button class="icon_groupbuy_cod"  name="publish" id = "codbutton" type="submit" style="border-right: medium none ;float: left; width: 159px;" title="<?php echo $this->translate('Cash on Delivery');?>" >
                                 <a href="javascript:;" style="text-decoration: none;"> 
                                    <img style="padding-left: 5px; margin-top: 0px;  float: left;" src="./application/modules/Groupbuy/externals/images/icon_cod.png" alt="">
                                    <span style="display: block; float: left;">
                                    <?php echo $this->translate('Cash on Delivery');?>      
                                    </span>
                                    </a>
                           </button>
                       <input TYPE="hidden" id="total_amount" NAME="total_amount" VALUE="<?php echo $item->final_price;?>"/> 
                       <input TYPE="hidden" id="number_buy" NAME="number_buy" VALUE="1"/>
                        <input TYPE="hidden" id="amount" NAME="amount" VALUE="<?php echo $item->final_price;?>"/>
                   </form>
						<?php endif;?>
                    <?php endif; ?>
                    <br/>
                     <div style="margin-top: 7px; margin-left: -5px; margin-top: 5px; line-height: 25px;">
                           <?php echo $this->htmlLink(array(
                              'action' => '',
                                'route' => 'groupbuy_general',
                            ), $this->translate('Back'), array(
                              'style' => 'font-weight: bold; text-decoration: none;',
                              'class'=>'icon_groupbuy_back'
                            )) ?>
                            </div>  
                    <div id = "maxmsg" style = "display: none; font-weight: bold; color: #1820FA">
                    	<br/><?php echo $this->translate('You have reached max bought allowed for this deal. You cannot buy this deal anymore!')?>
                    </div>
                    </td> 
                </tr>
                </table>
 </div>
 <?php else: ?>
<div class="tip" style="clear: inherit;">
      <span>
   <?php echo $this->translate('You can not buy this deal!');?>
   </span>
           <div style="clear: both;"></div>
    </div>
 <?php endif; ?>
<style type="text/css">
.icon_gift {
background-image: url(application/modules/Groupbuy/externals/images/gifticon.png);
background-repeat: no-repeat;
padding-top: 8px;
padding-bottom: 8px;
</style>
<script type="text/javascript">
window.addEvent('domready',function(){
	update(1);
	var buyff = '<?php echo $this->buyff;
	 					?>';
	var giftss = '<?php if (isset($_SESSION['buygift']) && ($_SESSION['buygift']['buygift'] == 1)) {
							echo "1"; 
						}
						else {
							echo "0";						 
						}?>';
	var numbuy = '<?php if (isset($_SESSION['buygift']) && ($_SESSION['buygift']['numberbuy'] != '')) {
						echo $_SESSION['buygift']['numberbuy']; 
					}
					else {
						echo "0";						 
					}?>';						

	var maxbought = '<?php echo $item->max_bought;?>';
	if (maxbought != 0) {
		var checkbought = '<?php echo $item->getMaxBought($this->viewer)?>';
		if  (checkbought == 0) {
			update(0);
			if ($('buygift')) {
				$('buygift').hide();
			}
			if ($('paypalbutton')) {
				$('paypalbutton').hide();
			}
			if ($('codbutton')) {
				$('codbutton').hide();
			}
			if ($('backbutton')) {
				$('backbutton').hide();
			}
            if ($('virtualmoney')) {
                $('virtualmoney').hide();
            }
            if ($('checkoutbutton')) {
                $('checkoutbutton').hide();
            }
			if (($('maxmsg')) && $('maxmsg').getStyle('display') == 'none') {
				$('maxmsg').show();
			}
		}
	}
	else {
		var checkbought = 1;
	}
	if (buyff == 1 && giftss == 0 && checkbought != 0) {
		 
		 var sb_url = '<?php echo $this->url(array('deal_id'=> $item->deal_id,'action'=>'buygift'), 'groupbuy_general', true)?>';
		    Smoothbox.open(sb_url);
		    
		 }
	else if (buyff == 2 && checkbought != 0) {
			var sb_url = '<?php echo $this->url(array('deal_id'=> $item->deal_id,'action'=>'buygift','method'=>'2'), 'groupbuy_general', true)?>';
		    Smoothbox.open(sb_url);
		}
	if (numbuy != 0) {
			$('number').value = numbuy;
			update(numbuy);
		}

});
</script>


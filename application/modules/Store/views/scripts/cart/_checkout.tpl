<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Store
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    Id: _checkout.tpl  4/25/12 6:23 PM teajay $
 * @author     Taalay
 */
?>
<script type="text/javascript">
  window.addEvent('domready', function(){
    new Fx.Accordion($('accordion'), '#accordion h3', '#accordion .content');
  });

  window.addEvent('load', function() {
    flasher(1);
  });

  function flasher(color)
  {
    color = 1 - color;
    if (color == 1) {
      addFlasher();
    } else {
      removeFlasher();
    }

    setTimeout(function() {
      flasher(color);
    }, 600);
  }

  function addFlasher()
  {
    var buttons = $$('.offer_use_button');
    buttons.each(function(element) {
      element.addClass('flasher_for_offer_button');
    });
  }

  function removeFlasher()
  {
    var buttons = $$('.offer_use_button');
    buttons.each(function(element) {
      element.removeClass('flasher_for_offer_button');
    });
  }

  function switchCheckoutForm($via_credits)
  {
    product_manager.switchCheckoutForm($via_credits);
  }

  function use_offer($offer_id)
  {
    product_manager.useOffer($offer_id);
  }
</script>

<div id="accordion">
  <h3 onclick="switchCheckoutForm(0)"><?php echo $this->translate('Order Summary')?></h3>
  <div class="content" id="store_payments">
    <ul id="store-checkout-panel">
      <li class="checkout-item">
        <div class="checkout-price">
          <span><?php echo $this->translate('STORE_items'); ?>:&nbsp;</span>
          <span class="store-price"
                id="store-cart-total-price"><?php echo $this->toCurrency($this->totalPrice, $this->currency); ?>
          </span>
        </div>
      </li>
      <li class="checkout-item">
        <div class="checkout-tax">
          <span><?php echo $this->translate('STORE_tax');?>:&nbsp;</span>
          <span class="store-price"><?php echo $this->toCurrency($this->taxesPrice, $this->currency); ?></span>
        </div>
      </li>
      <li class="checkout-item">
        <div class="checkout-shipping-price">
          <span><?php echo $this->translate('STORE_shipping');?>:&nbsp;</span>
          <span class="store-price"><?php echo $this->toCurrency($this->shippingPrice, $this->currency); ?></span>
        </div>
      </li>

      <div>
        <div class="checkout-total-price">
          <span class="checkout-title"><?php echo $this->translate('STORE_total');?>:&nbsp;</span>
          <span class="store-price">
            <?php echo $this->toCurrency($this->taxesPrice + $this->shippingPrice + $this->totalPrice, $this->currency); ?>
          </span>
        </div>

        <?php if ($this->gateways->count() > 0 && $this->taxesPrice + $this->shippingPrice + $this->totalPrice > 0): ?>
          <?php foreach ($this->gateways as $gateway): ?>
            <?php if ($gateway->title == 'Credit') : ?>
              <?php continue; ?>
            <?php endif;?>
            <div class="checkout-item center">
			
			<!--span ><img src="/bv/custom/v.gif" height="20px"/> <img src="/bv/custom/mc.gif"  height="20px"/> <img src="/bv/custom/amex.gif"  height="20px"/> <img src="/bv/custom/disc.gif"  height="20px"/></span-->
  
			<span><img src="/bv/application/modules/Store/externals/images/buttons/paypal.gif"></span>
			<div type="button" id="done2" name="done2" onclick="checkout(<?php echo  $gateway->getIdentity(); ?>);" class="payButtom" style="width:150px; color:#fff; cursor:pointer">Pay with Paypal</div>

			
			<div style="float:left; margin:50px 20px 20px 20px; display:block; width: 110px; height: 150px">

  <span id="siteseal" style="margin-buttom:20px; display:block; width: 110px; height: 50px; "><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=5ucsYW4SuvPHjkb4zD8nb3Q7dNcHhm1zMrBcsComT8Dgt0myWpsnUtAX9xz"></script></span> 
<span style="margin-top:20px"><script type="text/javascript" src="https://www.rapidscansecure.com/siteseal/siteseal.js?code=65,28249BDDAA76A676342C0D72DC02F4F8BE5FDA36"></script></span>
</div>


              <?php
/*			  echo $this->htmlImage(
                $gateway->getButtonUrl(),
                $this->translate('STORE_Checkout with %s', $gateway->getTitle()),
                array('alt' => $gateway->getTitle(),
                  'onclick' => 'checkout(' . $gateway->getIdentity() . ');'));
             */
			 ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </ul>
  </div>

  <?php if ($this->api->isCreditEnabled()) : ?>
    <h3 onclick="switchCheckoutForm(1)"><?php echo $this->translate('Order via Credits')?></h3>
    <div class="content" id="store_credits">
      <ul class="" id="store-credit-panel">
        <li class="checkout-item">
          <div class="checkout-price">
            <span><?php echo $this->translate('STORE_items'); ?>:&nbsp;</span>
            <span class="store-price">
              <span class="store_credit_icon">
                <span class="store-credit-price"><?php echo $this->api->getCredits($this->totalPrice); ?></span>
              </span>
            </span>
          </div>
        </li>
        <li class="checkout-item">
          <div class="checkout-tax">
            <span><?php echo $this->translate('STORE_tax');?>:&nbsp;</span>
            <span class="store-price">
              <span class="store_credit_icon">
                <span class="store-credit-price"><?php echo $this->api->getCredits($this->taxesPrice); ?></span>
              </span>
            </span>
          </div>
        </li>
        <li class="checkout-item">
          <div class="checkout-shipping-price">
            <span><?php echo $this->translate('STORE_shipping');?>:&nbsp;</span>
            <span class="store-price">
              <span class="store_credit_icon">
                <span class="store-credit-price"><?php echo $this->api->getCredits($this->shippingPrice); ?></span>
              </span>
            </span>
          </div>
        </li>
        <div>
          <div class="checkout-total-price">
            <span class="checkout-title"><?php echo $this->translate('STORE_total');?>:&nbsp;</span>
            <span class="store-price">
              <span class="store_credit_icon">
                <span class="store-credit-price"><?php echo $this->api->getCredits($this->taxesPrice + $this->shippingPrice + $this->totalPrice); ?></span>
              </span>
            </span>
          </div>

          <?php if ($this->taxesPrice + $this->shippingPrice + $this->totalPrice > 0): ?>
            <?php foreach ($this->gateways as $gateway): ?>
              <?php if ($gateway->title == 'Credit') : ?>
                <div class="checkout-item center">
                  <button class="button" onclick="checkout('<?php echo $gateway->getIdentity(); ?>');">
                    <?php echo $this->translate('STORE_Checkout with %s', $gateway->getTitle()); ?>
                  </button>
                </div>
              <?php endif;?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </ul>
    </div>
  <?php endif; ?>
</div>

<br />
<br />

<div class="offers_list_container">
  <?php if (isset($this->offers) && count($this->offers)) : ?>
    <h3><?php echo $this->translate('OFFERS_Available Offers')?></h3>
    <div class="offers_list">
      <ul>
        <?php foreach ($this->offers as $offer) : ?>
          <li>
            <?php echo $this->htmlLink($offer->getHref(), $this->itemPhoto($offer, 'thumb.icon', '', array('class' => 'thumb_icon item_photo_offer')), array('class' => 'offer_profile_thumb item_thumb')); ?>
            <div class="item_info">
              <div class="item_name">
                <?php echo $this->htmlLink($offer->getHref(), $offer->getTitle(), array('class' => 'offer_profile_title')); ?><br />
              </div>
              <div class="item_discount item_details">
                <?php echo $offer->discount; ?> <?php if ($offer->discount_type == 'percent') echo '%'; ?>
              </div>
              <div class="item_use_offer float_right">
                <button class="<?php if ($this->offer_id != $offer->getIdentity()) : ?>offer_use_button<?php endif; ?>" id="offer_use_button_<?php echo $offer->getIdentity()?>" style="padding: 2px 5px;" onclick="use_offer(<?php echo $offer->getIdentity();?>)"><?php if ($this->offer_id == $offer->getIdentity()) echo $this->translate('OFFERS_Used'); else echo $this->translate('OFFERS_Use');?></button>
              </div>
              <div class="clr"></div>
            </div>
          </li>
        <?php endforeach;?>
      </ul>
    </div>
  <?php endif;?>
</div>
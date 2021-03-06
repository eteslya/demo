<?php
/**
 * 
 *
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 * @version    $Id: cart.tpl 7244 2010-09-01 01:49:53Z john $
 * 
 */
?>
<h2>
	<?php echo $this->translate('%1$s\'s Cart', $this->htmlLink($this->viewer()->getHref(), $this->viewer()->getTitle()))?>
</h2>

<?php if(!empty($this->cartitems) && count($this->cartitems)): ?>
	<form method="post" id="cart_form">
		<table cellpadding="8" cellspacing="8" class="cart_table">
			<thead>
				<tr>
					<td><h3><?=$this->translate('Listing')?></h3></td>
					<td><h3><?=$this->translate('Price')?></h3></td>
					<td><h3><?=$this->translate('Quantity')?></h3></td>
					<td><h3><?=$this->translate('Options')?></h3></td>
				</tr>
			</thead>
			<tbody>
				<?php
					$total_amount = 0;
					$shipping_fee = 0;
				?>
				<?php foreach($this->cartitems as $cartitem): ?>
				<?php 
					$marketplace = Engine_Api::_()->getItem('marketplace', $cartitem->marketplace_id);
					if(empty($marketplace)){
						$cartTable = Engine_Api::_()->getDbtable('cart', 'marketplace');
						$cartTable->delete(array('marketplace_id = ?' => $cartitem->marketplace_id));
						continue;
					}

					$total_amount += $marketplace->price * $cartitem->count;
					$product_shipping_fee = Engine_Api::_()->marketplace()->getShipingFee($cartitem->marketplace_id, $this->viewer()->getIdentity());
					$product_shipping_fee = 0;
					$shipping_fee += ($product_shipping_fee?$product_shipping_fee:$this->flat_shipping_rate) * $cartitem->count;
				?>
					<tr>
						<td><?=$this->htmlLink($marketplace->getHref(), $marketplace->getTitle())?></td>
						<td><?=Engine_Api::_()->marketplace()->getCurrencySign().$marketplace->price?></td>
						<td><input type="text" name="marketplaces_count[<?=$cartitem->marketplace_id?>]" value="<?=$cartitem->count?>" maxlength="3" style="width:30px;" onchange="return;this.form.submit();" /></td>
						<td><?=$this->htmlLink(array('route' => 'marketplace_general', 'action' => 'deletefromcart', 'marketplace_id' => $cartitem->marketplace_id), 'Delete', array('class' => 'smoothbox'))?></td>
					</tr>
				<?php endforeach; ?>
				<?php 
					$total_amount_full = $total_amount + $shipping_fee;
				?>
			</tbody>
		</table>
		<div style="width: 434px;text-align: right;">
			<ul style="margin:15px 0;">
			<?php if($shipping_fee && 0): ?>
				<li>
					<span style="font-size:13px;">Shipping Fee:</span>
					<span style="font-size:13px;"><?php echo Engine_Api::_()->marketplace()->getCurrencySign().number_format($shipping_fee, 2);?></span>
				</li>
			<?php endif; ?>
			<?php if(0): ?>
				<li>
					<span style="font-size:18px;">Total Amount:</span>
					<span style="font-size:18px;"><?php echo Engine_Api::_()->marketplace()->getCurrencySign().number_format($total_amount_full, 2);?></span>
				</li>
			<?php endif; ?>
			</ul>
		</div>
		<?=$this->htmlLink('javascript:void(0);', 'Checkout', array('class' => 'marketplace_button', 'onclick' => '$("redirect").value="1";$("cart_form").submit();'))?>
		<?=$this->htmlLink('javascript:void(0);', 'Update', array('class' => 'marketplace_button', 'onclick' => '$("cart_form").submit();'))?>
		<?=$this->htmlLink('javascript:void(0);', 'Continue Shopping', array('class' => 'marketplace_button', 'onclick' => '$("redirect").value="2";$("cart_form").submit();'))?>
		<input type="hidden" id="redirect" name="redirect" value="0" />
	</form>
<?php else:?>
	<h2><?=$this->translate('Cart is Empty');?></h2>
<?php endif;?>
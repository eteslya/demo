<?php
/**
 * 
 *
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 * @version    $Id: index.tpl 7244 2010-09-01 01:49:53Z john $
 * 
 */
?>

		<ul class="marketplaces_profile_tab">
		  <?php foreach( $this->paginator as $mi ): ?>
		  <?php $item = Engine_Api::_()->getItem('marketplace', $mi['marketplace_id']); ?>
			<li>
				<table>
					<tbody>
						<tr>
							<td valign="middle">
							  <div class='marketplaces_profile_tab_photo'>
								<?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.normal')) ?>
							  </div>
							</td>
							<td>
							  <div class='marketplaces_profile_tab_info'>
								<div class='marketplaces_profile_tab_title'>
								  <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
								  <?php if( $item->closed ): ?>
									<img src='application/modules/Marketplace/externals/images/close.png'/>
								  <?php endif;?>
								</div>
								<div class='marketplaces_browse_info_date'>
								  <?php echo $this->timestamp(strtotime($item->creation_date)) ?>
								</div>
								<div class='marketplaces_browse_info_price'>
								  <span style="font-size:14px;font-weight:bold;">Price:</span> <span style="font-size:14px;font-weight:bold;"><?php echo Engine_Api::_()->marketplace()->getCurrencySign().$item->price; ?></span>
								</div>
							  </div>
							</td>
						</tr>
					</tbody>
				</table>
			</li>
		  <?php endforeach; ?>
		</ul>

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
 $viewer = Engine_Api::_()->user()->getViewer(); 
 $account = Groupbuy_Api_Cart::getFinanceAccount($viewer->getIdentity(),2);
 //$virtual = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.virtualmoney', 0);
 if (!$account):  ?>
<div class="tip" style="clear: inherit;">
      <span>
      <?php echo $this->translate('You do not have any finance account yet. '); ?>
      <a href="<?php echo $this->url(array('action'=>'create'),'groupbuy_account'); ?>"><?php echo $this->translate('Click here'); ?></a> <?php echo $this->translate('  to add your account.'); ?>
    </span>
           <div style="clear: both;"></div>
 </div>
 <?php else: ?>
<?php echo $this->form->render($this);  endif;?>
<script type="text/javascript">
function removeSubmit()
{
   $('buttons-wrapper').hide(); 
}
function setFeatured()
{
     <?php $fee = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.fee', 10); ?>
     <?php $feeP = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.displayfee', 10); ?>
     <?php $freeP = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('groupbuy_deal', $viewer, 'free_display');
      if($freeP == 1)
            $feeP = 0;
      $freeF = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('groupbuy_deal', $viewer, 'free_fee');
      if($freeF == 1)
        $fee = 0;
         ?>
     var total = 0;
    if($('featured').checked == true)
    {
        total =  <?php echo $feeP + $fee ?>;
    }
    else
        total = <?php echo $feeP ?>;
    $('total_fee').value = total;
}
en4.groupbuy= {
	removeCategory: function(a,b) {
		var d = $('add_more_id_'+(a-1));
		if(d) {
			d.show();
		}
		var c = $('category_id_'+a);
		if(c) {
			c.selectedIndex =  0;
		}
		var e =$('category_'+a+'-wrapper');
		if(e) {
			e.hide();
		}
	},
	addMoreCategory: function(a,b) {
		var c = $('add_more_id_'+a);
		if(c) {
			c.hide();
		}
		var e =$('category_'+b+'-wrapper');
		if(e) {
			e.show();
		}
	}
}
var cal_start_time_onHideStart = function(){
    // check end date and make it the same date if it's too
    cal_end_time.calendars[0].start = new Date( $('start_time-date').value );
    // redraw calendar
    cal_end_time.navigate(cal_end_time.calendars[0], 'm', 1);
    cal_end_time.navigate(cal_end_time.calendars[0], 'm', -1);
}
var cal_end_time_onHideStart = function(){
    // check start date and make it the same date if it's too
    cal_start_time.calendars[0].end = new Date( $('end_time-date').value );
    // redraw calendar
    cal_start_time.navigate(cal_start_time.calendars[0], 'm', 1);
    cal_start_time.navigate(cal_start_time.calendars[0], 'm', -1);
}
//$(document).addEvent('domready',function(){initMap(true)});
</script>

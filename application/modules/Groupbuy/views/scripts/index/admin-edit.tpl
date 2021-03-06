
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
<form action="<?php echo $this->escape($this->form->getAction()) ?>" method="<?php echo $this->escape($this->form->getMethod()) ?>" class="global_form groupbuy_browse_filters">
  <div>
    <div>
      <h3>
        <?php echo $this->translate($this->form->getTitle()) ?>
      </h3>
    
      <div class="form-elements">
        <?php echo $this->form->getDecorator('FormErrors')->setElement($this->form)->render();?>
        <?php echo $this->form->title; ?>
        <?php echo $this->form->{'category_id'}; ?>	
        
        <?php
        	if(isset($this->form->currency)):
				echo $this->form->currency; 
			endif; 
        ?>
        <?php
        	if(isset($this->form->vat_id)):
				echo $this->form->vat_id; 
			endif; 
        ?>
        
        <?php
        	if(isset($this->form->method) && $this->deal->published < 20):
         		echo $this->form->method;
			endif; 
        ?>
        <?php echo $this->form->value_deal; ?>
        <?php echo $this->form->price; ?>
        <?php echo $this->form->min_sold; ?>
        <?php echo $this->form->max_sold; ?>
        <?php echo $this->form->max_bought; ?>
        <?php echo $this->form->features; ?>
        <?php echo $this->form->fine_print; ?>
        <?php echo $this->form->description; ?>
        <?php // echo $this->form->latitude; ?>
        <?php //echo $this->form->longitude; ?>
        <?php echo $this->form->timezone; ?>
        <?php echo $this->form->start_time; ?>
        <?php echo $this->form->end_time; ?>
        <?php echo $this->form->location_id; ?>
        <?php echo $this->form->company_name; ?>
        <?php echo $this->form->address; ?>
        <?php echo $this->form->phone; ?>
        <?php echo $this->form->website; ?>
        <?php echo $this->form->getSubForm('fields'); ?>
        <?php if($this->form->auth_view)echo $this->form->auth_view; ?>
        <?php if($this->form->auth_comment)echo $this->form->auth_comment; ?>
        <?php echo $this->form->feep; ?>
        <?php echo $this->form->featured; ?>
        <?php echo $this->form->total_fee; ?>
        
     <?php if(Count($this->paginator) > 0): ?>
      <?php echo $this->form->deal_id; ?>
      <ul class='groupbuy_editphotos'>        
        <?php foreach( $this->paginator as $photo ): ?>
          <li>
            <div class="groupbuy_editphotos_photo">
              <?php echo $this->itemPhoto($photo, 'thumb.normal')  ?>
            </div>
            <div class="groupbuy_editphotos_info">
              <?php
                $key = $photo->getGuid();
                echo $this->form->getSubForm($key)->render($this);
              ?>
              <div class="groupbuy_editphotos_cover">
                <input type="radio" name="cover" value="<?php echo $photo->getIdentity() ?>" <?php if( $this->deal->photo_id == $photo->file_id ): ?> checked="checked"<?php endif; ?> />
              </div>
              <div class="groupbuy_editphotos_label">
                <label><?php echo $this->translate('Main Photo');?></label>
              </div>
            </div>
            <br/>
          </li>
        <?php endforeach; ?>
      </ul>
      <?php echo $this->form->execute->render(); ?>
      or <a href="<?php echo Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'groupbuy', 'controller' => 'manage', 'action' => 'index'), 'admin_default', true)
        ?>"> <?php echo $this->translate("cancel"); ?></a>
      <?php else: ?>
      <div class="form-wrapper">
      <div class="form-label" id="buttons-label">&nbsp;</div>
      <?php echo $this->form->execute->render(); ?>
     or <a href="<?php echo Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'groupbuy', 'controller' => 'manage', 'action' => 'index'), 'admin_default', true)
        ?>"><?php echo $this->translate("cancel"); ?></a>
       </div>
      <?php endif; ?>
        </div>
      
    </div>
  </div>
</form>


<?php if( $this->paginator->count() > 0 ): ?>
  <br />
  <?php echo $this->paginationControl($this->paginator); ?>
<?php endif; ?>

<script type="text/javascript">
function removeSubmit(){
   $('execute').hide(); 
}
function setFeatured()
{
     <?php $viewer = Engine_Api::_()->user()->getViewer(); 
     $fee = Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.fee', 10); ?>
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
//$(document).addEvent('domready',function(){initMap(true)});
</script>

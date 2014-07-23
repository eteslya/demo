<h2><?php echo $this->translate("Affiliate Plugin") ?></h2>

<!-- admin menu -->
<?php echo $this->content()->renderWidget('ynaffiliate.admin-main-menu') ?>
<div class="clear">
   <div class="settings">
      <form enctype="application/x-www-form-urlencoded" class="global_form" action="<?php echo $this->formUrl ?>" method="post">
         <div>
            <h3><?php echo $this->translate("Send Money")
?></h3>
            <p class="form-description">
            </p>
            <div class="form-elements">
               <div id="store_currency-wrapper">
                  <div class="form-wrapper">
                     <div class="form-label">
                        <label class="optional"><?php echo $this->translate('Request Amount:') ?></label>
                     </div>
                     <div id="store_product_rate-element" class="form-element">
                        <?php echo $this->request->request_amount . ' ' . $this->currency; ?>
                     </div>
                  </div>
                  <div class="form-wrapper">
                     <div class="form-label">
                        <label class="optional"><?php echo $this->translate('Account Request:') ?></label>
                     </div>
                     <div id="store_product_rate-element" class="form-element">
                        <?php echo $this->account_email ?>
                     </div>
                  </div>
                  <div class="form-wrapper">
                     <div class="form-label">
                        <label class="optional"><?php echo $this->translate('Message Response:') ?></label>
                     </div>
                     <div id="store_product_rate-element" class="form-element">
                        <textarea name="note"></textarea>
                     </div>
                  </div>
                  <input type="hidden" name="no_shipping" value="1"/>
                  <input TYPE="hidden" NAME="cmd" VALUE="_xclick">
                  <input TYPE="hidden" NAME="business" VALUE=" <?php echo $this->account_email; ?>">
                  <input TYPE="hidden" NAME="amount" VALUE="<?php echo $this->request->request_amount; ?>">
                  <input TYPE="hidden" NAME="currency_code" VALUE="<?php echo $this->currency; ?>">
                  <input TYPE="hidden" NAME="description" VALUE="">
                  <input TYPE="hidden" NAME="response_message" VALUE="<?php echo $this->responseMessage; ?>">
                  <input type="hidden" name="notify_url" value="<?php echo $this->notifyUrl; ?>"/>
                  <input type="hidden" name="return" value="<?php echo $this->returnUrl ?>"/>
                  <input type="hidden" name="cancel_return" value="<?php echo $this->cancelUrl ?>"/>
                  <div class="form-wrapper">
                     <div id="submit-label" class="form-label">
                        &nbsp;
                     </div>
                     <div id="submit-element" class="form-element">
                        <button name="submit" id="submit" type="submit">
                           <?php echo $this->translate("Send Money") ?>
                        </button> or <a href="<?php echo $this->url(array('action' => 'index')) ?>"><?php echo $this->translate("Cancel") ?></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<style type="text/css">

   .settings #submit-element {
      margin-left: 193px;
   }
   .tabs > ul > li {
      display: block;
      float: left;
      margin: 2px;
      padding: 5px;
   }
   .tabs > ul {  
      display: table;
      height: 65px;
   }
   .tabs > ul > li > a{
      white-space:nowrap!important;
   }
</style>
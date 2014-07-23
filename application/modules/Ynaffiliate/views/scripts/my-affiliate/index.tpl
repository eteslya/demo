<script type = "text/javascript">
   var currentOrder = '<?php echo $this->formValues['order'] ?>';
   var currentOrderDirection = '<?php echo $this->formValues['direction'] ?>';
   var changeOrder = function(order, default_direction){
      // Just change direction
      if( order == currentOrder ) {
         $('direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
      } else {
         $('order').value = order;
         $('direction').value = default_direction;
      }
      $('filter_form').submit();
   }
</script>

<div class="generic_layout_container layout_top">
   <?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
</div>
<div class="generic_layout_container layout_main">

   <div class="generic_layout_container layout_right">

      <?php echo $this->content()->renderWidget('ynaffiliate.mini-menu')
      ?>

   </div>

   <div class="generic_layout_container layout_middle">
      <h3><?php echo $this->translate("List of subscribed clients") ?></h3>
      <?php
      echo $this->form->render($this);
      ?>
      <br />
      <?php
      $count = $this->paginator->getTotalItemCount();
      echo $count ." ". $this->translate('of clients');
      ?>
      <?php if (count($this->paginator) > 0): ?>
      <div class="table_scroll">
         <table id="anyid" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr style="background:#E9F4FA none repeat scroll 0 0;">

               <th class="table_th"><?php echo $this->translate('Client Name'); ?></th>
               <th class="table_th"><?php echo $this->translate('Client Email'); ?></th>
               <th class="table_th"><?php echo $this->translate('Points'); ?></th>
               <th class="table_th"><?php echo $this->translate('URL'); ?></th>
               <th class="table_th">
                  <a href="javascript:void(0);" onclick="javascript:changeOrder('u.creation_date', 'DESC');">
                     <?php echo $this->translate('Registration Date'); ?>
                  </a>
               </th>

            </tr>
            <?php
            $total = 0;
            foreach ($this->paginator as $comm) :
               $point = Engine_Api::_()->ynaffiliate()->getCommissionPointsByClient($comm['new_user_id'], $comm['affiliate_id']);
               $client = Engine_Api::_()->getItem('user', $comm['new_user_id']);
               ?>
               <tr>
                  <td class="table_td"  >
                     <?php echo $client; ?>
                  </td>
                  <td class="table_longfield" >
                     <?php echo $client->email; ?>
                  </td>
                  <td class="table_td" >
                     <?php echo $this->locale()->toNumber($point); ?>
                  </td>
                  <td class="table_longfield" >
                     <?php
                     $assoc = Engine_Api::_()->ynaffiliate()->getAssocId($comm['new_user_id']);
                     $link_id = $assoc->link_id;
                     if ($link_id != 0) {
                     	$Links = new Ynaffiliate_Model_DbTable_Links;
	                    $target_url = $Links->getTargetLink($link_id);
    	                echo $target_url;
                     }
                     else {
                     	echo $this->translate('N/A');
                     }
                     ?>
                  </td>
                  <td class="table_td" >
                     <?php echo $client->creation_date; ?>
                  </td>                          
               </tr>    
               <?php $total+=$point; ?>
            <?php endforeach; ?>   
         </table>
         </div>
         <br></br>
         <div style=" color: #5F93B4;"><?php echo $this->translate("Total:") . $this->locale()->toNumber($total) ." ". "points"; ?></div>
      </div>

      <div>
         <?php
         echo $this->paginationControl($this->paginator, null, null, array(
             'pageAsQuery' => false,
             'query' => $this->formValues,
         ));
         ?>
      </div>

   <?php else: ?>
      <div class="tip">
         <span>
            <?php echo $this->translate("You have no client yet.") ?>
         </span>
      </div>
   <?php endif; ?>
</div>

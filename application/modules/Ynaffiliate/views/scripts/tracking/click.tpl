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
      <?php echo $this->content()->renderWidget('ynaffiliate.mini-menu') ?>
   </div>   
   <div class="generic_layout_container layout_middle">
      <h3><?php echo $this->translate("List of referring links") ?></h3>
      <?php echo $this->form->render($this); ?>
      </br>
 <?php
      $count = $this->paginator->getTotalItemCount();
      echo $count." ". $this->translate('URL(s)');
      ?>
       <?php if (count($this->paginator) > 0): ?>
      <div class="table_scroll">
      <table  id="anyid" cellpadding="0" cellspacing="0" border="0" width="100%">
         <tr style="background:#E9F4FA none repeat scroll 0 0;">
            <th class="table_th"><?php echo $this->translate('Referring URLs'); ?></th>
            <th class="table_th" ><?php echo $this->translate('Click'); ?></th>
            <th class="table_th" ><?php echo $this->translate('Successful Registration'); ?></th>
            <th class="table_th" >
               <a href="javascript:void(0);" onclick="javascript:changeOrder('last_click', 'DESC');">
                  <?php echo $this->translate('Date'); ?></a>
            </th>
         </tr>
          <?php
            
            foreach ($this->paginator as $link) {
              
               ?>
         <tr>
            <td class="table_td"  >
               <?php echo $link['target_url']; ?>
            </td>
            <td class="table_td" >
               <?php echo $link['click_count']; ?>
            </td>
            <td class="table_td" >
               <?php echo $link['success_count']; ?>
            </td>
            <td class="table_td" >
               <?php echo $link['last_click']; ?>
            </td>
         </tr>   
       
            <?php } ?>   

      </table>
</div>
   </div>
    <div>
         <?php echo $this->paginationControl($this->paginator); ?>
      </div>

   <?php else: ?>
      <div class="tip">
         <span>
            <?php echo $this->translate("There is no URL yet.") ?>
         </span>
      </div>
   <?php endif; ?>
</div>
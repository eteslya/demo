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
       <h3><?php echo $this->translate("List of affiliate purchases") ?></h3>
		<?php echo $this->form->render($this); ?>
       
       <br />
        <?php if( count($this->paginator) > 0 ): ?>
       <div class="table_scroll">
        <table class="admin_table">
           <thead class="table_thead">
                        <tr>
                           <th>
							<a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'DESC');">
       						 <?php echo $this->translate('Purchase Date'); ?>
        					</a></th>
                           <th><?php echo $this->translate('Client Name'); ?></th>
                           <th><?php echo $this->translate('Purchase Types'); ?></th>
                           <th><?php echo $this->translate('Total Amount'); ?></th>
                           <th><?php echo $this->translate('Commission Rate'); ?></th>
                           <th><?php echo $this->translate('Commission Amount'); ?></th>
                           <th><?php echo $this->translate('Points'); ?></th>     
                           <th><?php echo $this->translate("Status") ?></th>                        
                        </tr>
            </thead>
            <tbody>
             <?php foreach($this->paginator as $item): ?>
                        <tr>
                           <td>
                             <?php echo $item->purchase_date; ?>
                           </td>
                           <td>
                              <?php echo Engine_Api::_()->getItem('user',$item->from_user_id);	 ?>
                           </td>
                            <td>
                             <?php  $Rules = new Ynaffiliate_Model_DbTable_Rules;
			            			$rules = $Rules->getRuleById($item->rule_id);
			            			echo $rules->rule_title;
	            			 ?>
                           </td>
                           <td>
                              <?php echo round($item->purchase_total_amount, 2);?>
                           </td>
                           <td>
                              <?php if ($item->commission_type == 0) {
			            				echo $item->commission_rate.'%';
			            		  	}
			            		  	else {
			            		  		echo $item->commission_rate.' '.$item->purchase_currency;
			            		  	} ?>
                           </td>
                            <td>
                              <?php echo round($item->commission_amount, 2); ?>
                           </td>
                            <td>
                              <?php echo floor($item->commission_points); ?>
                           </td>    
                            <td><?php 	echo ucfirst($item->approve_stat);?>
            </td>                      
                        </tr>    
               <?php endforeach;?>           
             </tbody>             
            </table>
          </div>
       <br></br>
       <div>
       <?php  echo $this->paginationControl($this->paginator, null, null, array(
          'pageAsQuery' => false,
          'query' => $this->formValues,
        ));     ?>
    </div>
     <!--    <div style=" color: #5F93B4;"><?php echo $this->translate("Total:") ;?></div>-->
        <?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("You have no commission yet.") ?>
    </span>
  </div>
<?php endif; ?>
	</div>
</div>
<style type="text/css">
 table.admin_table thead tr th {
    background-color: #E9F4FA;
    border-bottom: 1px solid #AAAAAA;
    font-weight: bold;
    padding: 7px 10px;
    white-space: normal;
    text-align: center;
}
table.admin_table tbody tr td {
    border-bottom: 1px solid #EEEEEE;
    font-size: 0.9em;
    padding: 7px 10px;
    vertical-align: top;
    white-space: normal;
    text-align: center;
}

</style>  
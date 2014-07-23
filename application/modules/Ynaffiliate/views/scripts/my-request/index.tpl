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
       <h3><?php echo $this->translate("My Request") ?></h3>
		<?php echo $this->form->render($this); ?>
       <br>
       <?php if( count($this->paginator) > 0 ): ?>
        <div class="table_scroll">
        <table class="admin_table">
        <thead>
                        <tr style="background:#E9F4FA none repeat scroll 0 0;">
                           <th style="text-align:center">
                           <a href="javascript:void(0);" onclick="javascript:changeOrder('request_date', 'DESC');">
       							<?php echo $this->translate('Date'); ?>
       						</a>
       						</th>
                           <th style="text-align:center"><?php echo $this->translate('Requested Amount'); ?></th>
                           <th style="text-align:center"><?php echo $this->translate('Currency'); ?></th>
                           <th style="text-align:center"><?php echo $this->translate('Requested Point'); ?></th>
                           <th style="text-align:center"><?php echo $this->translate('Request Status'); ?></th>
                           
                        </tr>
       </thead>
       <tbody>
       <?php foreach($this->paginator as $item): ?>
                        <tr>
                           <td>
                             <?php echo $item->request_date; ?>
                           </td>
                           <td>
                              <?php echo $item->request_amount; ?>
                           </td>
                            <td>
                             <?php echo floor($item->request_points); ?>
                           </td>
                           <td>
                              <?php echo ucfirst($item->request_status); ?>
                           </td>
                            <td>
                              <?php echo $item->currency; ?>
                           </td>
                        </tr>    
          <?php endforeach;?>
       </tbody>     
            </table>
        </div>
          <br />  
                <!-- Page Changes  -->
    <div>
       <?php  echo $this->paginationControl($this->paginator, null, null, array(
          'pageAsQuery' => false,
          'query' => $this->formValues,
        ));     ?>
    </div>
    <?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("You have no request yet.") ?>
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
    white-space: nowrap;
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
<div class="generic_layout_container layout_top">
   <?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
</div>
<div class="generic_layout_container layout_main">
   <div class="generic_layout_container layout_right">
      <?php
      $affiliate = new Ynaffiliate_Plugin_Menus;
      if ($affiliate->canView()) {
         echo $this->content()->renderWidget('ynaffiliate.mini-menu');
      }
      ?>
   </div>
   <div class="generic_layout_container layout_middle">

      <div id="formborder">
         <form id="commission" method="post" name="commissionform">
            <?php if (count($this->paginator)): ?>
             <div class="table_scroll">
               <table cellpadding="0" cellspacing="0" border="0" width="100%">
                  <?php if ($this->selectbox == true) { ?>
                     <tr>
                        <td class="table_td">
                           <?php echo $this->translate('Profile Types'); ?>
                        </td>
                        <td class="table_td">
                           <select name="kitty" onchange="javascript:$('commission').submit();">
                              <?php
                              $option_id_selected = $this->userprofile;
                              foreach ($this->profile as $row) {
                                 ?>
                                 <option value="<?php echo $row->option_id; ?>" 
                                 <?php
                                 if ($row->option_id == $option_id_selected) {
                                    echo 'selected = "selected"';
                                 }
                                 ?>
                                         >
                                            <?php echo $row->label; ?> 
                                 </option>
                              <?php } ?>               

                           </select>
                     </tr>
                  <?php } ?>
                  <tr>
                     <th class="table_th">
                        <?php echo $this->translate('Rule Type'); ?>
                     </th>
                     <th class="table_th">
                        <?php echo $this->translate('First Purchase'); ?>
                     </th>
                     <th class="table_th">
                        <?php echo $this->translate('Future Purchases'); ?>
                     </th>
                  </tr>   

                  <?php
                  //  $dt = $this->data;
                  $rule = $this->paginator;
                  
                  $i = 1;
                  foreach ($rule as $type) {
             
                   if ($type['enabled'] == 1) {
                           ?>
                     <tr>   
                        <td class="table_td"><?php echo $type['rule_title'] ?></td>
                          <?php
                     if (isset($type['first'])) {
                        ?>
                        <td class="table_td"><?php echo $type['first'] . " %" ?></td>
                        <td class="table_td"><?php echo $type['future'] . " %" ?></td>                     
                      <?php } else {?> 
                         <td class="table_td"><?php echo $this->translate("N/A")?></td>
                        <td class="table_td"><?php echo $this->translate("N/A")?></td> 
                        <?php } ?>
                     </tr>  
                   <?php } 
                  }?>                    

               </table>
             </div>
               <br />
               <div>
                  <?php echo $this->paginationControl($this->paginator); ?>
               </div>

            <?php else: ?>
               <div class="tip">
                  <span>
                     <?php echo $this->translate("There is no rule yet.") ?>
                  </span>
               </div>
            <?php endif; ?>

         </form>
      </div>


   </div>	
</div>

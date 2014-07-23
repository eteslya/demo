<style type="text/css">
   .ynaff_thead > tr > th{
      font-size: 8pt;
      text-align: left;

   }
   

   div select {
      margin-top: 0px!important;
   }
</style>
<h2><?php echo $this->translate("Affiliate Plugin") ?></h2>

<?php echo $this->content()->renderWidget('ynaffiliate.admin-main-menu') ?>

<p>
   <?php echo $this->translate("YNAFFILIATE_VIEWS_SCRIPTS_ADMINMANAGE_COMMISSION_DESCRIPTION") ?>
</p>
<br /> 


<?php 
$baseCurrency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];

echo $this->translate('Current Currency: ');?>
<?php echo $baseCurrency; ?>
<br />
<?php 
$points_convert_rate = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1);
echo $this->translate('Points conversion rate: 1 '.$baseCurrency.' = '.$points_convert_rate.' point(s)');?>

<br /> 
<br />
<div class='admin_search'>   
   <?php echo $this->form->render($this); ?>
</div>

<br/>
<br/>
<?php
if (count($this->paginator) > 0):
   $baseCurrency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
   ?>
   <div class="admin_table_form">
      <table class='admin_table'>
         <thead class="ynaff_thead">
            <tr>
               <!--<th class='admin_table_short'><input type='checkbox' class='checkbox' /></th>-->
               <th><?php echo $this->translate("Client Name") ?></th> 
               <th><?php echo $this->translate("Affiliate Name") ?></th>
               <th><?php echo $this->translate("Purchase Type") ?></th> 
               <th><?php echo $this->translate("Purchase Currency") ?></th> 
               <th><?php echo $this->translate("Purchase Amount") ?></th> 
               <th><?php echo $this->translate("Commision Rate") ?></th>  
               <th><?php echo $this->translate("Commision Amount") ?></th> 
               <th><?php echo $this->translate("Points") ?></th>
               <th><?php echo $this->translate("Status") ?></th>   
               <th><?php echo $this->translate("Purchase Date") ?></th>

            </tr>
         </thead>
         <tbody>
   <?php foreach ($this->paginator as $item): ?>
               <tr>
                 <!--   <td><input type='checkbox' class='checkbox' value=""/></td>-->
                  <td><?php echo Engine_Api::_()->getItem('user', $item->from_user_id); ?></td> 
                  <td><?php echo Engine_Api::_()->getItem('user', $item->user_id); ?></td>
                  <td><?php
      $Rules = new Ynaffiliate_Model_DbTable_Rules;
      $rules = $Rules->getRuleById($item->rule_id);
      echo $rules->rule_title;
      ?>
                  </td> 
                  <td><?php echo $item->purchase_currency; ?></td>
                  <td><?php echo round($item->purchase_total_amount, 2); ?></td> 
                  <td><?php
      if ($item->commission_type == 0) {
         echo $item->commission_rate . '%';
      } else {
         echo $item->commission_rate . ' ' . $item->purchase_currency;
      }
      ?>
                  </td>  
                  <td><?php echo round($item->commission_amount, 2); ?></td> 
                  <td><?php echo floor($item->commission_points); ?></td>
                  <td><?php
      if ($item->purchase_currency != $baseCurrency && $item->commission_points == 0) :
         echo $this->translate('Currency Pair not exists!');
      else :
         if ($item->approve_stat == 'waiting') :
            ?>
                           <a href="<?php echo $this->url(array('action' => 'accept', 'id' => $item->commission_id)) ?>" class="smoothbox"><?php echo $this->translate('Accept ') ?></a>|
                           <a href="<?php echo $this->url(array('action' => 'deny', 'id' => $item->commission_id)) ?>" class="smoothbox"><?php echo $this->translate(' Deny') ?></a>
                           <?php
                        else :
                           echo ucfirst($item->approve_stat);
                        endif;
                     endif;
                     ?>
                  </td>  
                  <td><?php echo $item->purchase_date; ?></td>           
               </tr>
   <?php endforeach; ?>
         </tbody>
      </table>
   </div>
   <br />
   <!-- Page Changes  -->
   <div>
      <?php
      echo $this->paginationControl($this->paginator, null, null, array(
          'pageAsQuery' => false,
          'query' => $this->formValues,
      ));
      ?>
   </div>
   <!--  
      <div class='buttons'>
         <button onclick="" type='submit'>
   <?php echo $this->translate("Aprrove Selected") ?>
         </button> -->
   <!--<button onclick="javascript:approveSelected();" type='submit'>
   <?php //echo $this->translate("Approve Selected")   ?>
   </button> -->
   <!--     </div>

      <br/>

   -->
      <?php else: ?>
   <div class="tip">
      <span>
   <?php echo $this->translate("There is no commission yet.") ?>
      </span>
   </div>
<?php endif; ?>

<style type="text/css">

   .admin_search {
      max-width: 800px !important;
   }
</style>
<style type="text/css">
   table.admin_table thead tr th {
      white-space: normal !important;
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

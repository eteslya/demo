<h2>
   <?php echo $this->translate('Affiliate Plugin') ?>
</h2>

<?php echo $this->content()->renderWidget('ynaffiliate.admin-main-menu') ?>

<?php
// Render the admin js
echo $this->render('_jsAdmin.tpl')
?>


<br />

<div class="admin_fields_type">
   <h3>Profile Type:</h3>
   <?php echo $this->formSelect('profileType', $this->topLevelOption->option_id, array(), $this->topLevelOptions) ?>
</div>
<br/>
<?php if (count($this->paginator)): ?>
   <div class="admin_table_form">
      <table class='admin_table'>
         <thead>
            <tr>
               <th><?php echo $this->translate("Payment Types") ?></th>
               <th><?php echo $this->translate("First Purchase") ?></th>
               <th><?php echo $this->translate("Future Purchases") ?></th> 

               <th><?php echo $this->translate("Options") ?></th> 

            </tr>
         </thead>

         <tbody>
            <?php
            $rule = $this->paginator;

            foreach ($rule as $type) {
               //var_dump($type);
               //  die();
               ?>
               <tr>   
                  <td><?php echo $type['rule_title'] ?></td>
                  <?php
                  if (isset($type['first'])) {
                     ?>
                     <td><?php echo $type['first'] . " %" ?></td>
                     <td><?php echo $type['future'] . " %" ?></td>



                     <?php
                  } else {
                     ?>
                     <td><?php echo $this->translate("N/A") ?></td>
                     <td><?php echo $this->translate("N/A") ?></td>


                  <?php } ?>


                  <td>
                     <a class="smoothbox" href='<?php echo $this->url(array('action' => 'edit', 'rule_id' => $type['rule_id'], 'profile_id' => $this->profile_id, 'rulemap_id' => $type['rulemap_id'])); ?>'>
                        <?php echo $this->translate("Edit") ?>
                     </a>
                  </td>

               </tr>
            <?php } ?>



         </tbody>
      </table>
   </div>
   </br>
   <div>
      <?php echo $this->paginationControl($this->paginator); ?>
   </div>

<?php else: ?>
   <div class="tip">
      <span>
         <?php echo $this->translate("There are no rule yet.") ?>
      </span>
   </div>
<?php endif; ?>
<style type="text/css">
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
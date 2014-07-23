<ul class="ynaffiliate_quicklinks_menu">
     <li class="<?php echo $this->active_mini_menu == "my" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('action' => 'my-affiliate'), 'ynaffiliate_general', true) ?>" ><?php echo $this->translate('My Clients') ?></a>
     </li>
     <li class="<?php echo $this->active_mini_menu == "purchase" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'tracking', 'action' => 'purchase'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('Commission Tracking') ?></a>
     </li>

     <li class="<?php echo $this->active_mini_menu == "click" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'tracking', 'action' => 'click'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('Links Tracking') ?></a>
     </li>
     <li class="<?php echo $this->active_mini_menu == "request" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'my-request'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('My Requests') ?></a>
     </li>
     <li class="<?php echo $this->active_mini_menu == "statistic" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'statistic'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('Statistic') ?></a>
     </li>



     <li class="<?php echo $this->active_mini_menu == "static" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'sources', 'action' => 'index'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('Suggest Links') ?></a>
     </li>
     <li class="<?php echo $this->active_mini_menu == "dynamic" ? "active" : "" ?>"" >
         <a href="<?php echo $this->url(array('controller' => 'sources', 'action' => 'dynamic'), 'ynaffiliate_extended', true) ?>" ><?php echo $this->translate('Dynamic Links') ?></a>
     </li>	

</ul>

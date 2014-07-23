<h2>
  <?php echo $this->translate('Affiliate Plugin') ?>
</h2>

<!-- admin menu -->
<?php echo $this->content()->renderWidget('ynaffiliate.admin-main-menu') ?>
<p>
   <?php echo $this->translate("YNAFFILIATE_VIEWS_SCRIPTS_ADMINMANAGE_COMMISSION_DESCRIPTION") ?>
</p>
<br />

<div class="profile_fields">
		<h4><span><?php echo $this->translate('Statistics');?></span></h4>
		<ul>
			<li>
				<span><?php echo $this->translate("Total Affiliates") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->totalAffiliates); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Total Clients") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->totalClients); ?>
				</span>
			</li>
			<!--<li>
				<span><?php echo $this->translate("Successful Subscriptions") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->totalSubscriptions); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Groupbuy - Deal Publishing") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->dealPublishing); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Groupbuy - Deal Purchase") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->dealPurchase); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Store - Store Publishing") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->storePublishing); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Store - Product Publishing") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->productPublishing); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Store - Product Purchase") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->productPurchase); ?>
				</span>
			</li>-->
			<?php if (@$this->commissionInfo) :
					$Rules = new Ynaffiliate_Model_DbTable_Rules;
					$Modules = new Core_Model_DbTable_Modules;
					foreach ($this->commissionInfo as $commissionInfo) :
					?>
					<li>
						<span>
							<?php
							$module_title = $Modules->getModule($commissionInfo['module']); 
							$rule_title = $Rules->getRuleById($commissionInfo['rule_id']);
							echo $module_title->title." - ".$rule_title->rule_title;?>
						</span>
						<span>
						<?php echo $this->locale()->toNumber($commissionInfo['count']);?>
						</span>
					</li>
					<?php 
					endforeach;
			endif;?>
			<li>
				<span><?php echo $this->translate("Total Commission Points") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->totalCommissions); ?>
				</span>
			</li>
			<li>
				<span><?php echo $this->translate("Total Requested Points") ?></span>
				<span>
				<?php echo $this->locale()->toNumber($this->totalRequested); ?>
				</span>
			</li>
		</ul>	
	</div>


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
.profile_fields {
    margin-top: 10px;
    overflow: hidden;
}
.profile_fields h4 {
    border-bottom: 1px solid #EAEAEA;
    font-weight: bold;
    margin-bottom: 10px;
    padding: 0.5em 0;
}
.profile_fields h4 > span {
    background-color: #FFFFFF;
    display: inline-block;
    margin-top: -1px;
    padding-right: 6px;
    position: absolute;
    color: #717171;
    font-weight: bold;
}
.profile_fields > ul {
    padding: 10px;
    list-style-type: none;
}
.profile_fields > ul > li {
    overflow: hidden;
    margin-top: 3px;
}

.profile_fields > ul > li > span {
    display: block;
    float: left;
    margin-right: 15px;
    overflow: hidden;
    width: 275px;
}

.profile_fields > ul > li > span + span {
    display: block;
    float: left;
    min-width: 0;
    overflow: hidden;
    width: auto;
}
.tabs > ul > li > a{
      white-space:nowrap!important;
   }
</style>

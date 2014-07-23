<!-- render my widget -->
<?php echo $this->content()->renderWidget('ynaffiliate.main-menu') ?>
<!--  do not remove this line  -->
<h2><?php echo $this->translate("Help") ?></h2>
<div class="layout_left">
	<?php echo $this->content()->renderWidget('ynaffiliate.help-navigator') ?>	
</div>
<div class="layout_middle">
	<ul>
		<li>
			<h2><?php echo $this->item->getTitle() ?></h2>	
		</li>
		<li>
			<div>
				<?php echo $this->item->content ?>
			</div>		
		</li>
	</ul>
</div>

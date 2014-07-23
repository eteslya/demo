<div class="headline">
  <h2>
    <?php echo $this->translate('Affiliate');?>
  </h2>
  <div class="tabs">
  <?php if( count($this->navigation) > 0 ): ?>
      <?php echo $this->navigation()
          ->menu()
          ->setContainer($this->navigation)
          ->render();
      ?>
    </div>
  <?php endif; ?>
</div>


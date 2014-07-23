
<?php
  $url = $this->url(array('module' => 'hashtag','controller' => 'index','action'=>'search' ), 'default', true);
  foreach($this->tags as $tag):?>
  <div style="margin: 5px; padding: 5px;">
    <?php echo '<a href="javascript:void(0)" class="trands_hashtag" onClick="click_hashtags(\''.$url.'\',\''.$tag->hashtag. '\', \''.$this->translate("WALL_RECENT").'\',\'widget\');" title="'.$this->translate('TITLE_LINK_HASHTAG').'">#'.$tag->hashtag.'</a>'; ?>
  </div><div style="clear: both"></div>
<?php endforeach; ?>


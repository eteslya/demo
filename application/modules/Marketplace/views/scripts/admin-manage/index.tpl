<?php
/**
 * 
 *
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 * @version    $Id: index.tpl 7250 2010-09-01 07:42:35Z john $
 * 
 */
?>
<script type="text/javascript">
  en4.core.runonce.add(function(){$$('th.admin_table_short input[type=checkbox]').addEvent('click', function(){ $$('input[type=checkbox]').set('checked', $(this).get('checked', false)); })});

  var delectSelected =function(){
    var checkboxes = $$('input[type=checkbox]');
    var selecteditems = [];

    checkboxes.each(function(item, index){
      var checked = item.get('checked', false);
      var value = item.get('value', false);
      if (checked == true && value != 'on'){
        selecteditems.push(value);
      }
    });

    $('ids').value = selecteditems;
    $('delete_selected').submit();
  }
</script>

<h2><?php echo $this->translate("Marketplace Plugin") ?></h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php
      // Render the menu
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>

<p>
  <?php echo $this->translate("MARKETPLACES_VIEWS_SCRIPTS_ADMINMANAGE_INDEX_DESCRIPTION") ?>
</p>

<br />
<?php if( count($this->paginator) ): ?>

<table class='admin_table'>
  <thead>
    <tr>
      <th class='admin_table_short'><input type='checkbox' class='checkbox' /></th>
      <th class='admin_table_short'>ID</th>
      <th><?php echo $this->translate("Title") ?></th>
      <th><?php echo $this->translate("Owner") ?></th>
      <th><?php echo $this->translate("Views") ?></th>
      <th><?php echo $this->translate("Featured") ?></th>
      <th><?php echo $this->translate("Date") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->paginator as $item): ?>
      <tr>
        <td><input type='checkbox' class='checkbox' value="<?php echo $item->marketplace_id ?>"/></td>
        <td><?php echo $item->marketplace_id ?></td>
        <td><?php echo $item->getTitle() ?></td>
        <td><?php echo $this->user($item->owner_id)->getTitle() ?></td>
        <td><?php echo $this->locale()->toNumber($item->view_count) ?></td>
        <td>
			<?=$this->htmlLink(array('route' => 'default', 'module' => 'marketplace', 'controller' => 'admin-manage', 'action' => 'featured', 'marketplace_id' => $item->getIdentity()), ($item->featured?$this->translate('Yes'):$this->translate('No')), array('class' => 'smoothbox'))?>
		</td>
        <td><?php echo $this->locale()->toDateTime($item->creation_date) ?></td>
        <td>
          <a href="<?php echo $this->url(array('user_id' => $item->owner_id, 'marketplace_id' => $item->marketplace_id), 'marketplace_entry_view') ?>">
            <?php echo $this->translate("view") ?>
          </a>
          |
          <?php echo $this->htmlLink(
            array('route' => 'default', 'module' => 'marketplace', 'controller' => 'admin-manage', 'action' => 'delete', 'id' => $item->marketplace_id),
            $this->translate("delete"),
            array('class' => 'smoothbox')) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<br />

<div class='buttons'>
  <button onclick="javascript:delectSelected();" type='submit'>
    <?php echo $this->translate("Delete Selected") ?>
  </button>
</div>

<form id='delete_selected' method='post' action='<?php echo $this->url(array('action' =>'deleteselected')) ?>'>
  <input type="hidden" id="ids" name="ids" value=""/>
</form>
<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>

<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no marketplace listings by your members yet.") ?>
    </span>
  </div>
<?php endif; ?>

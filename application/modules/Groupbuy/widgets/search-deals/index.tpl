<script type="text/javascript">
 var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
  <div>
  <?php echo $this->form->render($this) ?>
 
</div>

<style type="text/css">
div#search-wrapper {
	float: left;
	margin-left: 30px;
} 
div#location-wrapper {
	float: left;
	margin-left: 30px;
}
div#status-wrapper {
	float: left;
	margin-left: 30px;
}
div#orderby-wrapper {
	float: left;
	margin-left: 30px;
}
div#category-wrapper {
	float: left;
	margin-left: 30px;
}
#global_page_groupbuy-index-listing div.form-elements {
	height: 35px;
}
#global_page_groupbuy-index-listing .global_form_box .form-wrapper + .form-wrapper {
	margin-top: 0px;
}
#global_page_groupbuy-index-browse .layout_groupbuy_search_deals div.form-elements {
	height: 35px;
}
#global_page_groupbuy-index-browse .global_form_box .form-wrapper + .form-wrapper {
	margin-top: 0px;
}
</style>
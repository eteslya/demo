<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Hebadge
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: index.tpl 02.04.12 09:12 michael $
 * @author     Michael
 */
?>


<script type="text/javascript">
  en4.core.runonce.add(function (){

    var submit = function (e){

      if (e){
        e.stop();
      }
      var elms = $$('.layout_core_container_tabs .layout_hebadge_badges, .layout_core_container_tabs .layout_hebadge_badges_friend, .layout_core_container_tabs .layout_hebadge_badges_recent');

      elms.each(function (item){

        if (!item.get('id')){
          return ;
        }
        var content_id = item.get('id').substr(11);
        if (!content_id){
          return ;
        }
        if (item.hasClass('hebadge_loading')){
          return ;
        }
        item.addClass('hebadge_loading');
        Hebadge.requestHTML( en4.core.baseUrl + 'core/widget/index/content_id/' + content_id + '/container/0/format/html', function (){
          item.removeClass('hebadge_loading');
        }, item , $$('.hebadge_form_search form')[0].toQueryString() );
      });
    }

    $$('.hebadge_form_search form').addEvent('submit', function (e){ submit(e); });
    $$('.hebadge_form_search a').addEvent('click', function (e){ submit(e); });
  });
</script>

<div class="hebadge_form_search">
  <form action="">
    <input type="text" name="text" value="" />
    <a href="javascript:void(0)">&nbsp;</a>
  </form>
</div>
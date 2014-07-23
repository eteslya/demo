<?php
/**
 * YouNet
 *
 * @category   Application_Extensions
 * @package    Auction
 * @copyright  Copyright 2011 YouNet Developments
 * @license    http://www.modules2buy.com/
 * @version    $Id: listing auctions
 * @author     Minh Nguyen
 */
class Groupbuy_Widget_ListingDealsController extends Engine_Content_Widget_Abstract {
	public function indexAction() {
		$viewer = Engine_Api::_() -> user() -> getViewer();
		$subject = Engine_Api::_() -> getItem('groupbuy_param', 1);
		$items_per_page = 6;
		$this->view->items_per_page = $items_per_page;
    	
		$values = null;
		$values['location'] = $subject -> location;
		$values['category'] = $subject -> category;
		$request = Zend_Controller_Front::getInstance() -> getRequest();

		$values['page'] = $request -> getParam('page');
		$values['orderby'] = $subject ->orderby;
		$values['search'] = $subject -> search;
		$values['start_time'] = $subject -> start_time;
		$values['end_time'] = $subject -> end_time;
		$values['status'] = $subject -> status;
		$values['published'] = 20;
		$values['status'] = 30;
		$values['featured'] = 1;		
		$featured = $subject -> featured;
		
		// Do the show thing
        /*
        if($values['status']){
			$where = " 1 AND deal_id != " . $featured;	
		}else{
			$where = " published = 20 AND status = 30 AND deal_id != " . $featured;
		}
		*/
		//$cur_time =  date('Y-m-d H:i:s');
        //$where = " published >= 20 AND stop = 0 AND is_delete =  0 AND start_time <= '$cur_time' AND end_time >= '$cur_time'";
        if($featured){
			$where = " 1 AND deal_id != " . $featured;
			$values['where'] = $where;	
		}
			
		//$values['limit'] = 1;
		$this -> view -> paginator = $paginator = Engine_Api::_() -> groupbuy() -> getDealsPaginator($values);
		$paginator->setItemCountPerPage($items_per_page);
		$this -> view -> user_id = $viewer -> getIdentity();
		if($featured) {
			$this -> view -> featured = Engine_Api::_() -> getItem('deal', $featured);
		}
 	   
	   
	}

}
?>

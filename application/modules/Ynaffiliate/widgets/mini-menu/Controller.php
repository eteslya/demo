<?php 

class Ynaffiliate_Widget_MiniMenuController extends Engine_Content_Widget_Abstract{
	public function indexAction(){
		$active_mini_menu = "info";
		
		if(Zend_Registry::isRegistered('active_mini_menu')){
			$active_mini_menu = Zend_Registry::get('active_mini_menu');
		}
		
		$this->view->active_mini_menu =  $active_mini_menu;
	}
}

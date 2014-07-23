<?php

class Ynaffiliate_FaqsController extends Core_Controller_Action_Standard {
	
	public function init() {
			if(!$this -> _helper -> requireUser() -> isValid()){
			return ;
		}
      $affiliate = new Ynaffiliate_Plugin_Menus;
    if(!$affiliate->canView())
    {
      $this->_redirect('/affiliate/index');
     //return $this->_helper->redirector->gotoRoute(array(), 'default', true);
  
    }
		Zend_Registry::set('active_menu', 'ynaffiliate_menu_faqs');
	}

	public function indexAction() {
		$Table = new Ynaffiliate_Model_DbTable_Faqs;
		$select = $Table->select()->where('status=?','show')->order('ordering asc');
		$this->view->items = $items =  $Table->fetchAll($select);
	}

}

<?php

class Ynaffiliate_HelpController extends Core_Controller_Action_Standard {
	
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
		// set active menu item on home page.
		Zend_Registry::set('active_menu', 'ynaffiliate_menu_helps');
	}

	public function indexAction() {
		$this->_forward('detail');
	}
	
	public function detailAction(){
		$id =  $this->_getParam('id',0);
		$table = new Ynaffiliate_Model_DbTable_HelpPages;
		$item =  $table->find($id)->current();
		
		if(!is_object($item)){
			$select = $table->select()->where('status=?','show')->order('ordering asc');
			$item = $table->fetchRow($select);
		}
		
		if(!is_object($item)){
			return $this->_forward('empty');
		}
		
		$this->view->item = $item;
		
		Zend_Registry::set('ACTIVE_HELP_PAGE', $item->getIdentity());
	}
	
	public function emptyAction(){
		
	}
}

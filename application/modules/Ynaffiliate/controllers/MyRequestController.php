<?php

class Ynaffiliate_MyRequestController extends Core_Controller_Action_Standard {

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
	}
	public function indexAction() {
		Zend_Registry::set('active_mini_menu','request');
		$this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/ynaffiliate_date.js');
		$this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/datepicker.js');
		$this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/datepicker_jqui/datepicker_jqui.css');
		$this->view->form = $form = new Ynaffiliate_Form_MyRequest();
		$values = array();  
    	if ($form->isValid($this->_getAllParams())) {
    		$values = $form->getValues();
    	}
    	$limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
    	$values['limit'] = $limit;
		$viewer = Engine_Api::_()->user()->getViewer();
		$values['user_id'] = $viewer->getIdentity();
		$paginator = $this -> view -> paginator = Engine_Api::_()->ynaffiliate()->getRequestsPaginator($values);
		$this->view->paginator->setCurrentPageNumber($page);
    	$this->view->formValues = $values; 
   }

}

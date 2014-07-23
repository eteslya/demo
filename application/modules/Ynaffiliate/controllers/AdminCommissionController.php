<?php

class Ynaffiliate_AdminCommissionController extends Core_Controller_Action_Admin {

   	public function init() {
		Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_commission');
		$this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/datepicker.js');
		$this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/ynaffiliate_date.js');
		$this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/datepicker_jqui/datepicker_jqui.css');
		$this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/main.css');
   	}

	public function indexAction() {
		$page = $this -> _getParam('page', 1);
		$this->view->form = $form = new Ynaffiliate_Form_Admin_Manage_Commission();
		$values = array();  
    	$req = $this -> getRequest();
		if($form -> isValid($this->_getAllParams())) {
			$values = $form -> getValues();
		}
    	$limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
    	$values['limit'] = $limit;
		
		$paginator = $this -> view -> paginator = Engine_Api::_()->ynaffiliate()->getCommissionsPaginator($values);
		$this->view->paginator->setCurrentPageNumber($page);
    	$this->view->formValues = $values; 
	}
	
	public function acceptAction() {
		$table = new Ynaffiliate_Model_DbTable_Commissions;
		$id = $this -> _getParam('id', 0);
		$item = $table -> find($id) -> current();
		if(!is_object($item)) {
			return;
		}
		$item -> approve_stat = 'approved';
		$item -> approved_date = date('Y-m-d H:i:s');
		$item -> save();
		
		$this -> _forward('success', 'utility', 'core', array('smoothboxClose' => true, 'parentRefresh' => true, 'format' => 'smoothbox', 'messages' => array('Approve commission successfully.')));
	}
	
	public function denyAction() {
		$table = new Ynaffiliate_Model_DbTable_Commissions;
		$id = $this -> _getParam('id', 0);
		$item = $table -> find($id) -> current();
		if(!is_object($item)) {
			return;
		}
		$item -> approve_stat = 'denied';
		$item -> approved_date = date('Y-m-d H:i:s');
		$item -> save();
		
		$this -> _forward('success', 'utility', 'core', array('smoothboxClose' => true, 'parentRefresh' => true, 'format' => 'smoothbox', 'messages' => array('Deny commission successfully.')));
	}
}

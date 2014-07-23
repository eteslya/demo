<?php

class Ynaffiliate_AdminRequestController extends Core_Controller_Action_Admin {

	public function init() {
		Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_request');
	}

	protected function getBaseUrl() {
		$baseUrl = Engine_Api::_() -> getApi('settings', 'core') -> getSetting('store.baseUrl', null);
		if(APPLICATION_ENV == 'development') {
			$request = Zend_Controller_Front::getInstance() -> getRequest();
			$baseUrl = sprintf('%s://%s', $request -> getScheme(), $request -> getHttpHost());
			Engine_Api::_() -> getApi('settings', 'core') -> setSetting('store.baseUrl', $baseUrl);
		}
		return $baseUrl;
	}

	public function indexAction() {
		$page = $this -> _getParam('page', 1);
		$this->view->form = $form = new Ynaffiliate_Form_Admin_Manage_Request();
		$values = array();  
    	if ($form->isValid($this->_getAllParams())) {
    		$values = $form->getValues();
    	}
    	$limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
    	$values['limit'] = $limit;
		
		$paginator = $this -> view -> paginator = Engine_Api::_()->ynaffiliate()->getRequestsPaginator($values);
		$this->view->paginator->setCurrentPageNumber($page);
    	$this->view->formValues = $values; 
	}
	
	public function acceptAction(){
		$this->view->form  =  $form =  new Ynaffiliate_Form_Admin_Request_Accept;
		//$req = $this -> getRequest();
		//if($req -> isPost() && $form -> isValid($req -> getPost())) {
			//$data = $form -> getValues();
			$gateway = 'paypal';
			$table = new Ynaffiliate_Model_DbTable_Requests;
			$id = $this -> _getParam('id', 0);
			$this->view->request = $item = $table -> find($id) -> current();
			$this->view->responseMessage = $item->response_message;
			$Accounts = new Ynaffiliate_Model_DbTable_Accounts;
      		$info_account = $Accounts->getPaymentAccount($item->user_id);
	      	$this->view->account_email = $info_account->paypal_email;
	      	$this->view->account_name = $info_account->paypal_displayname;
			$this->view->account = $info_account;
			$this->view->currency = $currency = $item->currency;
			$amount =  $item->request_amount;
			
			$baseUrl = $this->getBaseUrl();
			$router =  $this->getFrontController()->getRouter();
			$returnUrl = $this->view->returnUrl = $baseUrl . $router->assemble(array(
			'module'=>'ynaffiliate',
			'controller'=>'request',
			'action'=>'index',
			'id'=>$item->getIdentity(),
			'owner-id'=>$item->user_id,
			),'admin_default',true);
			
			$cancelUrl= $this->view->cancelUrl = $baseUrl . $router->assemble(array(
			'module'=>'ynaffiliate',
			'controller'=>'request',
			'action'=>'index',
			'id'=>$item->getIdentity(),
			'owner-id'=>$item->user_id,
			),'admin_default',true);
			
			$notifyUrl= $this->view->notifyUrl = $baseUrl . $router->assemble(array(
			'module'=>'ynaffiliate',
			'controller'=>'request-callback',
			'action'=>'notify',
			'id'=>$item->getIdentity(),
			'owner-id'=>$item->user_id,
			),'default',true); 
			
			$this->view->sandboxMode = $sandboxMode = Ynaffiliate_Api_Core::isSandboxMode();
			
			if($sandboxMode){
				$this->view->formUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}else{
				$this->view->formUrl = 'https://www.paypal.com/cgi-bin/webscr';
			}
		//}
	}

	public function denyAction() {
		$this -> _helper -> layout -> setLayout('admin-simple');
		$this -> view -> form = $form = new Ynaffiliate_Form_Admin_Request_Deny;

		$req = $this -> getRequest();

		$table = new Ynaffiliate_Model_DbTable_Requests;
		$id = $this -> _getParam('id', 0);
		$item = $table -> find($id) -> current();

		if(!is_object($item)) {

		}

		if($req -> isGet()) {
			return ;
		}

		if($req -> isPost() && $form -> isValid($req -> getPost())) {
			$data = $form -> getValues();

			$errors = false;

			if($errors) {
				$form -> markAsError();
				return ;
			}
			// process request.
			$item -> request_status = 'denied';
			$item -> setFromArray($data);
			$item -> response_date = date('Y-m-d H:i:s');
			$item -> save();
			
			/*$sendTo = Engine_Api::_()->getItem('user', $item->owner_id);
			$params = $item->toArray();
      		Engine_Api::_()->getApi('mail','Socialstore')->send($sendTo, 'store_requestdeny',$params);
			*/
			// Send Email Deny to Request
		}

		$this -> _forward('success', 'utility', 'core', array('smoothboxClose' => true, 'parentRefresh' => true, 'format' => 'smoothbox', 'messages' => array('Denied Successfully.')));
	}

}

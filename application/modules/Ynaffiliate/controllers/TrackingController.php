<?php

class Ynaffiliate_TrackingController extends Core_Controller_Action_Standard {

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
      $this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/datepicker.js');
      $this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/datepicker_jqui/datepicker_jqui.css');
      $this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/ynaffiliate_date.js');
   }

   public function indexAction() {
      
   }

   public function purchaseAction() {
      Zend_Registry::set('active_mini_menu','purchase');
      $page = $this -> _getParam('page', 1);
      $this->view->form = $form = new Ynaffiliate_Form_Tracking_Purchase();
      $values = array();  
      $req = $this -> getRequest();
	  if($form -> isValid($this->_getAllParams())) {
			$values = $form -> getValues();
	  }
      $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
      $values['limit'] = $limit;
      $values['user_id'] = Engine_Api::_()->user()->getViewer()->getIdentity();
	  $paginator = $this -> view -> paginator = Engine_Api::_()->ynaffiliate()->getCommissionsPaginator($values);
	  $this->view->paginator->setCurrentPageNumber($page);
      $this->view->formValues = $values; 
   }

   public function clickAction() {
      Zend_Registry::set('active_mini_menu','click');
      $this->view->form = $form = new Ynaffiliate_Form_Tracking_Click();
      
       $page = $this->_getParam('page', 1);
      $values = array();
      $user_id = Engine_Api::_()->user()->getViewer()->getIdentity();   

      if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
         $values = $form->getValues();
        
      }
      $values['user_id'] = $user_id;
      $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);     
      $values['limit'] = $limit;
      $this->view->viewer = Engine_Api::_()->user()->getViewer();
      $this->view->paginator = $paginator = Engine_Api::_()->ynaffiliate()->getLinksPaginator($values);
      $this->view->paginator->setCurrentPageNumber($page);
      $this->view->formValues = $values;
      
   }

   public function registrationAction() {
      Zend_Registry::set('active_mini_menu','registration');
      $this->view->form = $form = new Ynaffiliate_Form_Tracking_Registration();
   }

}

<?php

class Ynaffiliate_StatisticController extends Core_Controller_Action_Standard {
   
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
	public function indexAction()
	{
     	Zend_Registry::set('active_mini_menu','statistic');
		$this->view->form = $form = new Ynaffiliate_Form_Statistic();
	    $this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/ynaffiliate_date.js');
	    $this->view->headScript()->appendFile($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/scripts/datepicker.js');
	    $this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/datepicker_jqui/datepicker_jqui.css');
	    
	    /*if (!$this->getRequest()->isPost()) {
	        return;
	    }
	    if (!$form->isValid($this->getRequest()->getPost())) {
	        return;
	    }      
	    $values = $form->getValues();*/ 
		$viewer = Engine_Api::_()->user()->getViewer();
		$user_id = $viewer->getIdentity();
		$this->view->subscriptions = Engine_Api::_()->getApi('statistic', 'ynaffiliate')->getSubscriptions($viewer->getIdentity());
		$this->view->purchases = Engine_Api::_()->getApi('statistic', 'ynaffiliate')->getPurchases($viewer->getIdentity());
		$Commissions = new Ynaffiliate_Model_DbTable_Commissions;
    	$Requests = new Ynaffiliate_Model_DbTable_Requests;
		$requested_points = floor($Requests->getRequestedPoints($user_id));
		$totalPoints = floor($Commissions->getTotalPoints($user_id));
		$this->view->commissionPoints = $totalPoints;
		$this->view->requestedPoints = $requested_points;
	}

}

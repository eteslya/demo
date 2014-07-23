<?php

class Ynaffiliate_MyAccountController extends Core_Controller_Action_Standard {

   public function init() {
      if (!$this->_helper->requireUser()->isValid()) {
         return;
      }
      $affiliate = new Ynaffiliate_Plugin_Menus;
      if (!$affiliate->canView()) {
         $this->_redirect('/affiliate/index');
         //return $this->_helper->redirector->gotoRoute(array(), 'default', true);
      }
   }

   public function indexAction() {
      $viewer = Engine_Api::_()->user()->getViewer();
      $user_id = $viewer->getIdentity();
      $Accounts = new Ynaffiliate_Model_DbTable_Accounts;
      $info_account = $Accounts->getPaymentAccount($user_id);
      $this->view->account_email = $info_account->paypal_email;
      $this->view->account_name = $info_account->paypal_displayname;
      $level = Engine_Api::_()->getItem('authorization_level', $viewer->level_id);
      if (in_array($level->type, array('admin'))) {
         $isAdmin = 1;
      } else {
         $isAdmin = 0;
      }
      $this->view->minRequest = $minRequest = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.minrequest', 10);
      $this->view->maxRequest = $maxRequest = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.maxrequest', 10);
      $Commissions = new Ynaffiliate_Model_DbTable_Commissions;
      $Requests = new Ynaffiliate_Model_DbTable_Requests;
      $requested_points = floor($Requests->getRequestedPoints($user_id));
      $current_request = floor($Requests->getCurrentRequestPoints($user_id));
      $totalPoints = floor($Commissions->getTotalPoints($user_id));
      $this->view->totalPoints = $totalPoints;
      $this->view->requestedPoints = $requested_points;
      $this->view->availablePoints = $totalPoints - $requested_points - $current_request;
      $this->view->currentRequestPoints = $current_request;
      $this->view->currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
   }

   public function editAction() {
      if (!$this->_helper->requireUser()->isValid())
         return;
      $user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      $Accounts = new Ynaffiliate_Model_DbTable_Accounts;
      $info_account = $Accounts->getPaymentAccount($user_id);
      $this->view->form = $form = new Ynaffiliate_Form_MyAccount_Edit();

      $form->populate($info_account->toArray());
      $req = $this->getRequest();
      if ($req->isPost() && $form->isValid($req->getPost())) {
         $data = $form->getValues();
         if (is_object($info_account)) {
            $info_account->paypal_displayname = $data['paypal_displayname'];
            $info_account->paypal_email = $data['paypal_email'];
         }
         $info_account->save();
         $form->addNotice('Save Changed.');
      }
   }

   public function thresholdAction() {
      $user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      $this->_helper->layout->setLayout('admin-simple');
      $this->view->form = $form = new Ynaffiliate_Form_MyAccount_Request();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
      $available_points = Engine_Api::_()->ynaffiliate()->getAffiliatePoints($user_id);
      $minPointsRequest = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.minrequest', 10);
      if ($available_points < $minPointsRequest) {
      	$form->removeElement('submit');
         $form->addError('You do not have enough points to request!');
      }

      $table = new Ynaffiliate_Model_DbTable_Requests;
      $maxPointsRequest = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.maxrequest', 100);

	  $max = ($maxPointsRequest <= $available_points) ? $maxPointsRequest : $available_points;
      if ($max == 0) {
      	$max = $maxPointsRequest;
      }
	  $form->request_points->addValidator('Between', false, array($minPointsRequest, $max));
      $view = Zend_Registry::get('Zend_View');
      $form->request_points->setDescription(sprintf("Request Points Available: from %s to %s", $minPointsRequest, $max));
      $form->request_points->getDecorator('description')->setOption("placement", "append");

      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      	 $data = $form->getValues();
         $request_points = $data['request_points'];

         $min = $minPointsRequest;
         

		 if ($available_points < $minPointsRequest) {
         	$form->addError('You do not have enough points to request!');
      	 } 
         if ($request_points < $min) {
            $form->addError('Your request amount has to be at least ' . $min . ' and less than ' . $max);
         }
         if ($request_points > $max) {
            $form->addError('Your request amount has to be at least ' . $min . ' and less than ' . $max);
         }
         $item = $table->fetchNew();
         $item->setFromArray($data);
         $item->user_id = $user_id;
         $item->currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
         $point_convert_rate = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1);
         $item->request_amount = round($request_points / $point_convert_rate, 2);
         $item->request_date = date('Y-m-d H:i:s');
         $item->save();
         $this->_forward('success', 'utility', 'core', array(
             'smoothboxClose' => 10,
             'parentRefresh' => 10,
             'messages' => array('')
         ));
      }
      $this->renderScript('my-account/form.tpl');
   }

}

<?php

class Ynaffiliate_AdminManageController extends Core_Controller_Action_Admin {

   public function init() {
      Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_manage_affiliate');
      $this->view->headLink()->appendStylesheet($this->view->baseUrl() . '/application/modules/Ynaffiliate/externals/styles/main.css');
   }

   public function indexAction() {

      $this->view->form = $form = new Ynaffiliate_Form_Admin_Manage_Affiliate();
      $page = $this->_getParam('page', 1);
      $values = array();
      if ($form->isValid($this->_getAllParams())) {
         $values = $form->getValues();
      }
      $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
      $values['limit'] = $limit;
      $this->view->viewer = Engine_Api::_()->user()->getViewer();
      $this->view->paginator = $paginator = Engine_Api::_()->ynaffiliate()->getAffiliatesPaginator($values);
      $this->view->paginator->setCurrentPageNumber($page);
      $this->view->formValues = $values;
   }

   public function deleteSelectedAction() {
      $this->view->ids = $ids = $this->_getParam('ids', null);
      $confirm = $this->_getParam('confirm', false);
      $this->view->count = count(explode(",", $ids));
      // Save values
      if ($this->getRequest()->isPost() && $confirm == true) {
         $ids_array = explode(",", $ids);
         foreach ($ids_array as $id) {
            $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $id);
            if ($account) {
               $account->delete();
            }
         }

         $this->_helper->redirector->gotoRoute(array('action' => 'index'));
      }
   }

   public function approveSelectedAction() {
      $this->view->ids = $ids = $this->_getParam('ids1', null);
      $confirm = $this->_getParam('confirm', false);
      $this->view->count = count(explode(",", $ids));
      // Save values
      if ($this->getRequest()->isPost() && $confirm == true) {
         $ids_array = explode(",", $ids);
         foreach ($ids_array as $id) {
            $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $id);
            if ($account->approved == 0) {
               $account->approved = 1;
               $account->save();
            }
         }
         $this->_helper->redirector->gotoRoute(array('action' => 'index'));
      }
   }

   public function denySelectedAction() {
      $this->view->ids = $ids = $this->_getParam('ids2', null);
      $confirm = $this->_getParam('confirm', false);
      $this->view->count = count(explode(",", $ids));
      // Save values
      if ($this->getRequest()->isPost() && $confirm == true) {
         $ids_array = explode(",", $ids);
         foreach ($ids_array as $id) {
            $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $id);
            if ($account->approved == 0) {
               $account->approved = 2;
               $account->save();
            }
         }
         $this->_helper->redirector->gotoRoute(array('action' => 'index'));
      }
   }

   public function approveAffiliateAction() {

      $form = $this->view->form = new Ynaffiliate_Form_Admin_Approve();
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
         $values = $form->getValues();
         $account_id = $values['account_id'];
         $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $account_id);
         $this->view->account_id = $account->account_id;
         // This is a smoothbox by default
         if (null === $this->_helper->ajaxContext->getCurrentContext())
            $this->_helper->layout->setLayout('default-simple');
         else // Otherwise no layout
            $this->_helper->layout->disableLayout(true);

         $account->approved = 1;
         $account->save();

         $this->view->form = null;
         $this->_forward('success', 'utility', 'core', array(
             'smoothboxClose' => true,
             'parentRefresh' => true,
             'messages' => array('Change Saved')));
      }
      if (!($account_id = $this->_getParam('account_id'))) {
         throw new Zend_Exception('No Affiliate specified');
      }

      //Generate form
      $form->populate(array('account_id' => $account_id));

      //Output
      $this->renderScript('admin-manage/form.tpl');
   }

   public function statisticsAction() {

      $id = $this->_getParam('account_id', null);
      $viewer = Engine_Api::_()->getItem('user', $id);
      $user_id = $id;
      $this->view->subscriptions = Engine_Api::_()->getApi('statistic', 'ynaffiliate')->getSubscriptions($viewer->getIdentity());
      $this->view->purchases = Engine_Api::_()->getApi('statistic', 'ynaffiliate')->getPurchases($viewer->getIdentity());
      $Commissions = new Ynaffiliate_Model_DbTable_Commissions;
      $Requests = new Ynaffiliate_Model_DbTable_Requests;
      $requested_points = floor($Requests->getRequestedPoints($user_id));
      $totalPoints = floor($Commissions->getTotalPoints($user_id));
      $this->view->commissionPoints = $totalPoints;
      $this->view->requestedPoints = $requested_points;
   }

   public function denyAffiliateAction() {
      $form = $this->view->form = new Ynaffiliate_Form_Admin_Deny();
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
         $values = $form->getValues();
         $account_id = $values['account_id'];
         $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $account_id);
         $this->view->account_id = $account->account_id;
         // This is a smoothbox by default
         if (null === $this->_helper->ajaxContext->getCurrentContext())
            $this->_helper->layout->setLayout('default-simple');
         else // Otherwise no layout
            $this->_helper->layout->disableLayout(true);

         $account->approved = 2;
         $account->save();
         $this->view->form = null;
         $this->_forward('success', 'utility', 'core', array(
             'smoothboxClose' => true,
             'parentRefresh' => true,
             'messages' => array(Zend_Registry::get('Zend_Translate')->_("Change Saved"))));

//         $this->_forward('success', 'utility', 'core', array(
//             'smoothboxClose' => 1000,
//             'parentRefresh' => 10,
//             'messages' => array('Affiliate has been denied')));
      }
      if (!($account_id = $this->_getParam('account_id'))) {
         throw new Zend_Exception('No Affiliate specified');
      }

      //Generate form
      $form->populate(array('account_id' => $account_id));

      //Output
      $this->renderScript('admin-manage/form.tpl');
   }

   public function deleteAffiliateAction() {
      $form = $this->view->form = new Ynaffiliate_Form_Admin_Delete();
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
         $values = $form->getValues();
         $account_id = $values['account_id'];
         $account = Engine_Api::_()->getItem('ynaffiliate_accounts', $account_id);
         $this->view->account_id = $account->account_id;
         // This is a smoothbox by default
         if (null === $this->_helper->ajaxContext->getCurrentContext())
            $this->_helper->layout->setLayout('default-simple');
         else // Otherwise no layout
            $this->_helper->layout->disableLayout(true);



         // $account->deleted = 1;
         $account->delete();

         $this->view->form = null;
         $this->_forward('success', 'utility', 'core', array(
             'smoothboxClose' => true,
             'parentRefresh' => true,
             'messages' => array(Zend_Registry::get('Zend_Translate')->_("Change Saved"))));
      }
      if (!($account_id = $this->_getParam('account_id'))) {
         throw new Zend_Exception('No Affiliate specified');
      }

      //Generate form
      $form->populate(array('account_id' => $account_id));

      //Output
      $this->renderScript('admin-manage/form.tpl');
   }

}

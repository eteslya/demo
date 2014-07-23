<?php

class Ynaffiliate_AdminExchangeratesController extends Core_Controller_Action_Admin {

   public function init() {
      Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_exchangerates');
   }

   public function indexAction() {
      $page = $this->_getParam('page', 1);
      $table = Engine_Api::_()->getDbTable('currencies', 'ynaffiliate');
      $exchange_table = Engine_Api::_()->getDbTable('exchangerates', 'ynaffiliate');
      $currencies = $table->getCurrencies();
      $exchange_rate = array();
      $i = 0;
      foreach ($currencies as $curr) {
         $exchange_rate[$i]['exchangerate_id'] = $curr['code'];
         $exchange_rate[$i]['name'] = $curr['name'];
         $rate = $exchange_table->getExchangerateById($curr['code']);

         if (empty($rate)) {
            $exchange_rate[$i]['exchange_rate'] = null;
         } else {
            $exchange_rate[$i]['exchange_rate'] = $rate['exchange_rate'];
         }
         $i++;
      }

      $this->view->paginator = $paginator = Zend_Paginator::factory($exchange_rate);
      $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
      $this->view->paginator->setItemCountPerPage($limit);
      $this->view->paginator->setCurrentPageNumber($page);
   }

   public function editAction() {

      $id = $this->getRequest()->getParam('exchangerate_id');
      $base_currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
      $this->view->form = $form = new Ynaffiliate_Form_Admin_Exchangerates_Edit();
      //$form->setDescription("Please enter the exchange rate to convert from 1 " . $id . " to 1 " . $base_currency);
      $form->setDescription("Please enter the exchange rate for 1 " . $base_currency);
      $table = Engine_Api::_()->getDbTable('exchangerates', 'ynaffiliate');
      $rate = $table->getExchangerateById($id);

      // $form->exchangerate_id->setValue($rate['exchangerate_id']);
      $form->exchange_rate->setValue($rate['exchange_rate']);
      if (!$this->getRequest()->isPost()) {
         return;
      }

      if (!$form->isValid($this->getRequest()->getPost())) {
         return;
      }
      $values = $form->getValues();
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
  	     $rate_value = $values['exchange_rate'];
         $rate->exchange_rate = round($rate_value,2);
         $rate->save();
         $db->commit();
         $Commissions = new Ynaffiliate_Model_DbTable_Commissions;
         $Commissions->convertPoints($rate->exchangerate_id, $rate->exchange_rate);
      } catch (Exception $e) {
         $db->rollBack();
         throw $e;
      }
      $this->view->form = null;
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'format' => 'smoothbox',
          'messages' => array(Zend_Registry::get('Zend_Translate')->_("Changes Saved"))
      ));
   }

   public function addrateAction() {

      $id = $this->getRequest()->getParam('exchangerate_id');
      $base_currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
      $this->view->form = $form = new Ynaffiliate_Form_Admin_Exchangerates_Edit();
      $form->setDescription("Please enter the exchange rate for 1 " . $base_currency);

      if (!$this->getRequest()->isPost()) {
         return;
      }

      if (!$form->isValid($this->getRequest()->getPost())) {
         return;
      }

      $values = $form->getValues();

      $table = Engine_Api::_()->getDbTable('exchangerates', 'ynaffiliate');
      $rate = $table->createRow();
      $values['exchangerate_id'] = $id;
      $rate_value = $values['exchange_rate'];
      $values['exchange_rate'] = round($rate_value, 2);
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
         $rate->setFromArray($values);

         $rate->save();
         $db->commit();
         $Commissions = new Ynaffiliate_Model_DbTable_Commissions;
         $Commissions->convertPoints($rate->exchangerate_id, $rate->exchange_rate);
      } catch (Exception $e) {
         $db->rollBack();
         throw $e;
      }
      $this->view->form = null;
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'format' => 'smoothbox',
          'messages' => array(Zend_Registry::get('Zend_Translate')->_("Changes Saved"))
      ));
   }

}

<?php

class Ynaffiliate_IndexController extends Core_Controller_Action_Standard {

   public function init() {
      
   }

   function curPageURL() {
      $pageURL = 'http';
      if ($_SERVER["HTTPS"] == "on") {
         $pageURL .= "s";
      }
      $pageURL .= "://";

      if ($_SERVER["SERVER_PORT"] != "80") {
         $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
      } else {
         $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
      }
      return $pageURL;
   }

   public function indexAction() {
      if (!$this->_helper->requireUser()->isValid()) {
         return;
      }



      Zend_Registry::set('active_menu', null);

      $account = Engine_Api::_()->getApi('Core', 'Ynaffiliate')->getAccount();

      if (!is_object($account)) {
         $url = $this->getFrontController()->getRouter()->assemble(array(), 'ynaffiliate_signup', true);
         $this->_helper->redirector->setPrependBase(false)->gotoUrl($url);
      }

      if ($account->isApproved() == 1) {
         $url = $this->getFrontController()->getRouter()->assemble(array('controller' => 'commission-rule'), 'ynaffiliate_extended', true);
         $this->_helper->redirector->setPrependBase(false)->gotoUrl($url);

         //	return $this->_forward('need-approved');
      } else {
         $this->_forward('need-approved');
      }
   }

   public function needApprovedAction() {
      $account = Engine_Api::_()->getApi('Core', 'Ynaffiliate')->getAccount();
      $this->view->account = $account;
   }

   public function clickAction() {
      $url = $this->getFrontController()->getRouter()->assemble(array(), 'home');
      $found = false;
      if (isset($_COOKIE['ynaffiliate_user_id']) && isset($_COOKIE['ynaffiliate_link_id']) && isset($_COOKIE['ynaffiliate_time'])) {
         $found = true;
      }

      $user_id = $this->_getParam('user_id');

      $target = $this->_getParam('href');

      if ($target) {
         $target = base64_decode($target);
      } else {
         $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array(), 'home', true);
         $target = Engine_Api::_()->ynaffiliate()->getSiteUrl() . '/' . $url;
      }

      $Links = new Ynaffiliate_Model_DbTable_Links;

      if ($user_id) {
         $link = $Links->getLink($user_id, $target, $this->curPageURL());
         $link->click_count++;
         $link->last_click = date('Y-m-d H:i:s');
         $link->save();
         // set affiliate table.
         $days = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.expireddays', 30);
         $expired = $days * 86400 + time();
         $request = Zend_Controller_Front::getInstance()->getRequest();
         $base_url = $request->getBaseUrl();
         setcookie('ynafuser', $user_id, $expired, '/');
         setcookie('ynaflink', $link->getIdentity(), $expired, '/');
         setcookie('ynafftime', time(), $expired, '/');
       
         /*$_COOKIE['ynaffiliate_user_id'] = $user_id;
         $_COOKIE['ynaffiliate_link_id'] = $link->getIdentity();
         $_COOKIE['ynaffiliate_time'] = time();*/
      }

      $this->_helper->redirector->setPrependBase(false)->gotoUrl($target);
   }

   public function termsAction() {

      if (!$this->_helper->requireUser()->isValid()) {
         return;
      }
      
//      $affiliate = new Ynaffiliate_Plugin_Menus;
//      if (!$affiliate->canView()) {
//         $this->_redirect('/affiliate/index');
//         //return $this->_helper->redirector->gotoRoute(array(), 'default', true);
//      }
      $table = Engine_Api::_()->getDbTable('statics', 'ynaffiliate');
      $select = $table->select();
      $select->where('static_name = ?', 'terms');
      $row = $table->fetchRow($select);
      if (!count($row)) {
         return;
      }
      //echo($row[0]->static_content);
      $this->view->terms = $row->static_content;
   }

}

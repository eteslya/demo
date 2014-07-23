<?php

class Ynaffiliate_AdminCommissionRuleController extends Fields_Controller_AdminAbstract {

   protected $_fieldType = 'user';
   protected $_requireProfileType = true;

   public function indexAction() {
      Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_rule');
      $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
              ->getNavigation('ynaffiliate_admin_main', array(), 'ynaffiliate_admin_main_rule');

      parent::indexAction();
      $page = $this->_getParam('page', 1);
      //get profile id
      $profile_id = $_GET['option_id'];

      if (!$profile_id) {
         $profile_id = 1;
      }
      $this->view->profile_id = $profile_id;
      $rule_table = Engine_Api::_()->getDbTable('rules', 'ynaffiliate');
      $db = $rule_table->getAdapter();
      $select = Engine_Api::_()->ynaffiliate()->getCommissionRulesSelect($profile_id);

      $data = $db->fetchAll($select);
      $data2 = null;
      $j = 0;
      for ($i = 0; $i < count($data); $i++) {
//         if ($i % 2 == 0)
//            $j++;
         $j = $data[$i]['ruleid'];
         $data2[$j]['rulemap_id'] = $data[$i]['rulemap_id'];

         $data2[$j]['rule_title'] = $data[$i]['rule_title'];
         $data2[$j]['rule_id'] = $data[$i]['ruleid'];
         $data2[$j]['enabled'] = $data[$i]['enabled'];
         if (!isset($data[$i]['rule_value'])) {
            //  var_dump($data[$i]);die();
            $data2[$j]['first'] = null;
            $data2[$j]['future'] = null;
         } else {
            if ($data[$i]['option_id'] == 0) {
               $data2[$j]['first'] = $data[$i]['rule_value'];
            } else {
               $data2[$j]['future'] = $data[$i]['rule_value'];
            }
         }
      }

      // $this->view->data = $data2;
      $this->view->paginator = $paginator = Zend_Paginator::factory($data2);
      $limit = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.page', 10);
      $this->view->paginator->setItemCountPerPage($limit);
      $this->view->paginator->setCurrentPageNumber($page);
   }

   public function editAction() {
      $profile_id = $this->getRequest()->getParam('profile_id');
      $rule_id = $this->getRequest()->getParam('rule_id');
      $rulemaps_table = Engine_Api::_()->getDbTable('rulemaps', 'ynaffiliate');
      $rulemapdetails_table = Engine_Api::_()->getDbTable('rulemapdetails', 'ynaffiliate');


      $this->view->form = $form = new Ynaffiliate_Form_Admin_Commission_Rule();

      $check = $rulemaps_table->checkRuleMap($rule_id, $profile_id);
      if (count($check) > 0) {
           //the rule is setted
         $dt = $rulemapdetails_table->getRuleMapDetailById($check['rulemap_id']);
         foreach ($dt as $row) {
            if ($row->option_id == 0) {
               //  var_dump((float)($row->rule_value));die();
               $form->first->setValue((float) ($row->rule_value));
            } else {
               $form->future->setValue((float) ($row->rule_value));
            }
         }
      }
      if (!$this->getRequest()->isPost()) {
         return;
      }

      if (!$form->isValid($this->getRequest()->getPost())) {
         return;
      }
      $values = $form->getValues();

      if (count($check) > 0) {
          //the rule is setted => Edit rule
         $rulemap_id = $check['rulemap_id'];
         $db = $rulemapdetails_table->getAdapter();
         $db->beginTransaction();
         foreach ($dt as $row) {
            try {
               if ($row->option_id == 0) {
                  $row->rule_value = round($values['first'], 2);
               } else {
                  $row->rule_value = round($values['future'], 2);
               }
               $row->save();
               $db->commit();
            } catch (Exception $e) {
               $db->rollBack();
               throw $e;
            }
         }
        
      } else {
         //create new rule detail
         $db = $rulemaps_table->getAdapter();
         $db->beginTransaction();
         try {
            $row = $rulemaps_table->createRow();
            $row->rule_id = $rule_id;
            $row->profiletype_id = $profile_id;
            $row->save();
            $db->commit();
         } catch (Exception $e) {
            $db->rollBack();
            throw $e;
         }
         $rulemap_id = $row->rulemap_id;

         // $mapdetail = Engine_Api::_()->getDbTable('rulemapdetails', 'ynaffiliate');
         $db = $rulemapdetails_table->getAdapter();
         $db->beginTransaction();
         try {
            $row1 = $rulemapdetails_table->createRow();
            $row1->rule_map = $rulemap_id;
            $row1->option_id = 0;
            $row1->rule_value = round($values['first'], 2);
            $row1->save();

            $row2 = $rulemapdetails_table->createRow();
            $row2->rule_map = $rulemap_id;
            $row2->option_id = 1;
            $row2->rule_value = round($values['future'], 2);
            $row2->save();
         } catch (Exception $e) {
            $db->rollBack();
            throw $e;
         }
      }
//
//      $rule_table = Engine_Api::_()->getDbTable('rules', 'ynaffiliate');
//      $rule = $rule_table->getRuleById($rule_id);
//      $db = $rule_table->getAdapter();
//      $db->beginTransaction();
//
//      try {
//         //$rule->enabled = $values['enabled'];
//         $rule->save();
//         $db->commit();
//      } catch (Exception $e) {
//         $db->rollBack();
//         throw $e;
//      }
//      
      $this->view->form = null;
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'format' => 'smoothbox',
          'messages' => array(Zend_Registry::get('Zend_Translate')->_("Changes Saved"))
      ));
   }
   
   /*
   public function editAction() {

      $this->view->form = $form = new Ynaffiliate_Form_Admin_Commission_Rule();
      $rulemap_id = $this->getRequest()->getParam('rulemap_id');
      $rule_id = $this->getRequest()->getParam('rule_id');
      $rule_table = Engine_Api::_()->getDbTable('rules', 'ynaffiliate');
      $rule = $rule_table->getRuleById($rule_id);
      //    $form->enabled->setValue($rule->enabled);
      $detail = Engine_Api::_()->getDbTable('rulemapdetails', 'ynaffiliate');
      $select = $detail->select();
      $select->where('rule_map=?', $rulemap_id);
      $dt = $detail->fetchAll($select);
      foreach ($dt as $row) {
         if ($row->option_id == 0) {
            //  var_dump((float)($row->rule_value));die();
            $form->first->setValue((float) ($row->rule_value));
         } else {
            $form->future->setValue((float) ($row->rule_value));
         }
      }

      if (!$this->getRequest()->isPost()) {
         return;
      }

      if (!$form->isValid($this->getRequest()->getPost())) {
         return;
      }
      $values = $form->getValues();
      $profile_id = $this->getRequest()->getParam('profile_id');

      //update rule map details table
      $db = $detail->getAdapter();
      $db->beginTransaction();
      foreach ($dt as $row) {
         try {
            if ($row->option_id == 0) {
               $row->rule_value = round($values['first'], 2);
            } else {
               $row->rule_value = round($values['future'], 2);
            }
            $row->save();
            $db->commit();
         } catch (Exception $e) {
            $db->rollBack();
            throw $e;
         }
      }
//      //update rule table
//      $db = $rule_table->getAdapter();
//      $db->beginTransaction();
//
//      try {
//         //$rule = $rule_table->getRuleById($rule_id);
//        // $rule->enabled = $values['enabled'];
//         $rule->save();
//         $db->commit();
//      } catch (Exception $e) {
//         $db->rollBack();
//         throw $e;
//      }


      $this->view->form = null;
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => true,
          'format' => 'smoothbox',
          'messages' => array(Zend_Registry::get('Zend_Translate')->_("Changes Saved"))
      ));
   }
*/
}

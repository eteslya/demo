<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ynaffiliate_CommissionRuleController extends Core_Controller_Action_Standard {

   protected $_fieldType = 'user';
   protected $_requireProfileType = true;

   public function init() {
      if (!$this->_helper->requireUser()->isValid()) {
         return;
      }
   }

   public function indexAction() {
      $page = $this->_getParam('page', 1);
      $optionsData = Engine_Api::_()->getApi('core', 'fields')->getFieldsOptions($this->_fieldType);
      $profileType = $optionsData->getRowsMatching(array('field_id' => 1));
      $this->view->selectbox = true;
      if(count($profileType) ==1)
      {
         $this->view->selectbox = false;
      }
      $this->view->profile = $profileType;
      $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
      $table = Engine_Api::_()->getApi('core', 'fields')->getTable('user', 'values');
      //$value_table = Engine_Api::_()->getDbTable('values', 'fields');
      $select = $table->select();
      $select->where('field_id=?', 1);
      $select->where('item_id=?', $viewer_id);
      $value_profile = $table->fetchRow($select);
      $profile_id = $value_profile->value;
      if($profile_id == null)
      {
         $profile_id = 1;
      }
      if ($this->getRequest()->isPost()) {
         $profile_id = $_POST['kitty'];
      }

      $this->view->userprofile = $profile_id;
      //get rule table
//
//      $rule_table = Engine_Api::_()->getDbTable('rules', 'ynaffiliate');
//      $rulemap_table = Engine_Api::_()->getDbTable('rulemaps', 'ynaffiliate');
//      $select = $rule_table->select();
//      $payment_type = $rule_table->fetchAll($select);
//      $rule = null;
//      $i = 0;
//      //check if rule is set for this profile or not
//      foreach ($payment_type as $type) {
//         $rule[$i]['rule_id'] = $type->rule_id;
//         $rule[$i]['rule_title'] = $type->rule_title;
//         $rule[$i]['isset'] = 1;
//         $select = $rulemap_table->select();
//         $select->where('rule_id=?', $type->rule_id);
//         $select->where('profiletype_id=?', $profile_id);
//
//         $dt = $rulemap_table->fetchAll($select);
//         if (!count($dt)) {
//
//            $rule[$i]['isset'] = 0;
//         }
//         $i++;
//      }
//      $this->view->rule = $rule;
//
//      $db = $rule_table->getAdapter();
//      $select = $db->select();
//      $select->from(array('m' => 'engine4_ynaffiliate_rulemaps'), array('rule_id', 'rulemap_id'))
//              ->join(array('r' => 'engine4_ynaffiliate_rules'), 'r.rule_id = m.rule_id')
//              ->join(array('d' => 'engine4_ynaffiliate_rulemapdetails'), 'm.rulemap_id =d.rule_map');
//
//      $this->view->profile_id = $profile_id;
//      $this->view->isset = 1;
//      $data = $db->fetchAll($select->where('profiletype_id=?', $profile_id));
//      if (count($data) == 0) {
//         $this->view->isset = 0;
//      }
//      $data2 = null;
//      $j = 0;
//      for ($i = 0; $i < count($data); $i++) {
//         if ($i % 2 == 0)
//            $j++;
//         $data2[$j]['rulemap_id'] = $data[$i]['rulemap_id'];
//         $data2[$j]['rule_title'] = $data[$i]['rule_title'];
//         $data2[$j]['rule_id'] = $data[$i]['rule_id'];
//         if ($data[$i]['option_id'] == 0) {
//            $data2[$j]['first'] = $data[$i]['rule_value'];
//         }
//         if ($data[$i]['option_id'] == 1) {
//            $data2[$j]['future'] = $data[$i]['rule_value'];
//         }
//      }

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
     // var_dump($data2);die();
       $this->view->paginator = $paginator = Zend_Paginator::factory($data2);
      $this->view->paginator->setItemCountPerPage(10);
      $this->view->paginator->setCurrentPageNumber($page);
   }

}

?>

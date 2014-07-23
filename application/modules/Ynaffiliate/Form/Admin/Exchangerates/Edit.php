<?php

class Ynaffiliate_Form_Admin_Exchangerates_Edit extends Engine_Form {

   public function init() {


    // $id = $this->getRequest()->getParam('exchangerate_id');
//      $this->setTitle('Exchange Rate');
//      $this->addElement('Text', 'exchangerate_id', array(
//          'label' => 'Currency',
//          'allowEmpty' => false,
//         
//          'attribs' => array('readonly' => 'readonly'),
//         
//          'filters' => array(
//              new Engine_Filter_Censor(),
//          ),
//         // 'value' => $id,
//      ));

     
      $this->addElement('Text', 'exchange_rate', array(
          'label' => 'Exchange Rate',
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(
              array('NotEmpty', true),
              array('Float', true),
          // array('Between', true, array($min_payout, $maxvalue, true)),
          ),
          'filters' => array(
              new Engine_Filter_Censor(),
          ),
          'value' => '',
      ));
      $this->addElement('Button', 'submit', array(
          'label' => 'Submit',
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array(
              'ViewHelper',
          ),
      ));
//    
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'cancel',
          'link' => true,
          'onClick' => 'javascript:parent.Smoothbox.close();',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
      // DisplayGroup: buttons
      $this->addDisplayGroup(array(
          'submit',
          'cancel',
              ), 'buttons', array(
          'decorators' => array(
              'FormElements',
              'DivDivDivWrapper'
          ),
      ));
   }

   // }
}
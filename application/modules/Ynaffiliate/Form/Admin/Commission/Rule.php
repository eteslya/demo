<?php

class Ynaffiliate_Form_Admin_Commission_Rule extends Engine_Form {

   public function init() {


      $this->setTitle('Commission Rule');
      $this->addElement('Text', 'first', array(
          'label' => 'First Purchase (%)',
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

      $this->addElement('Text', 'future', array(
          'label' => 'Future Purchases (%)',
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

//      $this->addElement('Select', 'enabled', array(
//          'label' => 'Enable:',
//          'multiOptions' => array(           
//              0 => "Disable",
//              1 => "Enable",
//             
//          ),
//              //'multiOptions' => (array)Engine_Api::_()->getDbTable('categories','groupbuy')->getMultiOptions('..', 'All'),
//              //'onchange' => 'this.form.submit();',
//      ));
      
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
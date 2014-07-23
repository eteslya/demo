<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ynaffiliate_Form_Signup extends Engine_Form {

   protected $_item;
   

   public function getItem() {
      return $this->_item;
   }

   public function setItem(Core_Model_Item_Abstract $item) {
      $this->_item = $item;
      return $this;
   }

   
  
   public function init() {
      // $user_level = Engine_Api::_()->user()->getViewer()->level_id;
      $user = Engine_Api::_()->user()->getViewer();

      // Init form
      $this
              ->setTitle('Sign up to become Affiliate.')
              ->setDescription('Enter your affiliate information')
              ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
      ;

      //Contact Name
      $this->addElement('Text', 'contact_name', array(
          'label' => 'Contact Name',
          'description' => '',
          'required' => true,
          'allowEmpty' => false,
          'attribs' => array('readonly' => 'readonly'),
          'filters' => array(
              'StringTrim'
          ),
          'value' => $this->getItem()->displayname
      ));


      //Contact Email
      $this->addElement('Text', 'contact_email', array(
          'label' => 'Contact Email',
          'description' => '',
          'required' => false,
          'allowEmpty' => true,
          'validators' => array(
              array('NotEmpty', true),
              array('EmailAddress', true),
          ),
          'filters' => array(
              'StringTrim'
          ),
          // fancy stuff
          //'inputType' => 'email',
          // 'autofocus' => 'autofocus',
          'tabindex' => 1,
          'value' => $user->email
      ));
      $this->contact_email->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
      $this->contact_email->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');

      
      //Contact Adress
      $this->addElement('Text', 'contact_address', array(
          'label' => 'Contact Adress',
          'description' => '',
          'required' => false,
          'allowEmpty' => true,
          'filters' => array(
              'StringTrim'
          ),
      ));
      //Contact Phone
      $this->addElement('Text', 'contact_phone', array(
          'label' => 'Contact Phone',
          'description' => '',
          'required' => false,
          'allowEmpty' => false,
          'filters' => array(
              'StringTrim'
          ),
      ));


//      //Member Fee
//      $this->addElement('Text', 'memberfee', array(
//      'label' => 'Member Fee',
//      'description' => 'You can not edit this field',
//       'attribs'    => array('disabled' => 'disabled'),     
//      'filters' => array(
//        'StringTrim'
//      ),     
//    ));
//       $this->memberfee->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
//      
// 
//
//    
//    // Paypal display name
//      $this->addElement('Text', 'paypal_display', array(
//      'label' => 'Paypal Display Name*',
//      'description' => '',
//      'required' => true,
//      'allowEmpty' => false,
//     
//      'filters' => array(
//        'StringTrim'
//      ),     
//    ));
//    
//    //Paypal Email Address
//    $this->addElement('Text', 'paypal_email', array(
//      'label' => 'Paypal Email Address*',
//      'description' => 'This email address will be used to receive money request notification from admin when you request for money',
//      'required' => true,
//      'allowEmpty' => false,
//      'validators' => array(
//        array('NotEmpty', true),
//        array('EmailAddress', true),
//       
//      ),
//      'filters' => array(
//        'StringTrim'
//      ),
//      // fancy stuff
//      'inputType' => 'email',
//    //  'autofocus' => 'autofocus',
//      'tabindex' => 1,
//    ));
//    $this->paypal_email->getDecorator('Description')->setOptions(array('placement' => 'APPEND'));
//    $this->paypal_email->getValidator('NotEmpty')->setMessage('Please enter a valid email address.', 'isEmpty');
////    $this->email->getValidator('Db_NoRecordExists')->setMessage('Someone has already registered this email address, please use another one.', 'recordFound');
      // Element: terms
      $description = Zend_Registry::get('Zend_Translate')->_('I have read and agree to the <a target="_blank" href="%s/affiliate/index/terms">Terms of Service</a>.');
      $description = sprintf($description, Zend_Controller_Front::getInstance()->getBaseUrl());

      $this->addElement('Checkbox', 'terms', array(
          'label' => 'Terms of Service',
          'description' => $description,
          'required' => true,
          'validators' => array(
              'notEmpty',
              array('GreaterThan', false, array(0)),
          )
      ));
      $this->terms->getValidator('GreaterThan')->setMessage('You must agree to the terms of service to continue.', 'notGreaterThan');
      //$this->terms->getDecorator('Label')->setOption('escape', false);

      $this->terms->clearDecorators()
              ->addDecorator('ViewHelper')
              ->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::APPEND, 'tag' => 'label', 'class' => 'null', 'escape' => false, 'for' => 'terms'))
              ->addDecorator('DivDivDivWrapper');

      //$this->terms->setDisableTranslator(true);
      // Init submit
      $this->addElement('Button', 'submit', array(
          'label' => 'Submit',
          'type' => 'submit',
          'ignore' => true,
      ));
   }

}

?>
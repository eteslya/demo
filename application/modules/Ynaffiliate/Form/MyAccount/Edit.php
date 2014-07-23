<?php
class Ynaffiliate_Form_MyAccount_Edit extends Engine_Form
{

  public function init()
  {
 	$this->setTitle('Add Paypal Account')
      	->setDescription('Add your paypal account to request money. (*) is required.');
	  
		
		$this->addElement('Text','paypal_displayname',array(
			'label'=>'Paypal Display Name*',
			'description'=>'Please fill your Paypal Display Name in the textbox below.',
			'required'=>true,
			'maxlength'=>128,
			'filters'=>array('StringTrim'),
		));
		
		$this->addElement('Text','paypal_email',array(
			'label'=>'Paypal Email Address*',
			'required'=>true,
			'maxlength'=>128,
			'description'=>'Please fill your Paypal Email Address in the textbox below.',
			'filters'=>array('StringTrim'),
			'validators'=>array(
				'EmailAddress',
			),
		));
    
    /*$this->addElement('select', 'currency', array(
        'label' => 'Default Currency*',
        'description' => 'Select default currency',
        'required'=>true,
        'multiOptions' => array(1=>'USA'),
      ));
    $this->currency->getDecorator("Description")->setOption("placement", "append");*/
    
  
    
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type'  => 'submit',
    'ignore' => true,
    'decorators' => array(
        'ViewHelper',
      ),
    ));
    
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'Cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index'), 'ynaffiliate_account', true),
      'onclick' => '',
    'decorators' => array(
        'ViewHelper',
      ),
    ));
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
  
}
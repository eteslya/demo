<?php

class Ynaffiliate_Form_MyAccount_Request extends Engine_Form {

   public function init() {
      

      	$this->setTitle('Request');
         $this->addElement('Text', 'request_points', array(
             'label' => 'Point*',
             'allowEmpty' => false,
             'required' => true,
             'validators' => array(
                 array('NotEmpty', true),
             ),
             'value' => '',
             'escape'=>false,
         ));
		$this->addElement('textarea','request_message',array(
			'label'=>'Request Message',
			'filters'=>array('StringTrim'),
		));
         $this->addElement('Button', 'submit', array(
             'label' => 'Submit',
             'type' => 'submit',
             'ignore' => true,
             'decorators' => array(
                 'ViewHelper',
             ),
         ));

         // Element: cancel
         $this->addElement('Cancel', 'cancel', array(
             'label' => 'cancel',
             'link' => true,
         	 'prependText' => ' or ',
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
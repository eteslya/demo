<?php

class Ynaffiliate_Form_Admin_Global extends Engine_Form {

   public function init() {
      
         $this->setTitle('Global Settings')
              ->setDescription('These settings affect all members in your community.');
	
	$currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
      $this->addElement('Radio', 'ynaffiliate_mode', array(
        'label' => '*Enable Test Mode?',
        'description' => 'Allow admin to test Store by using development mode? ',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.mode', 1),
      )); 
	$this->addElement('radio', 'ynaffiliate_autoapprove', array(
          'label' => 'Auto Approve',
          'description' => 'Do you want to approve member automatically?',
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes ',
              '0' => 'No'
          ),         
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.autoapprove', 1)
      ));

      // add js radio
      $this->addElement('radio', 'ynaffiliate_invitation', array(
          'label' => ' Intergration with invitation',
           'description' => 'Do you want to intergrate with invitations?',
          'required' => true,
          'multiOptions' => array(
              '1' => 'Yes ',
              '0' => 'No'
          ),
           'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.invitation', 1),
      ));

      $this->addElement('Text', 'ynaffiliate_minrequest', array(
          'label' => 'Minimum  Request Points',
          'title' => 'Minimum  Request Points',
          'description' => '',
          'filters' => array(
              new Engine_Filter_Censor(),
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.minrequest', 100),
      ));
      $this->addElement('Text', 'ynaffiliate_maxrequest', array(
          'label' => 'Maximum  Request Points',
          'title' => 'Maximum Request Points',
          'description' => '',
          'filters' => array(
              new Engine_Filter_Censor(),
          ),
          'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.maxrequest', 1000),
      ));
      
       $this->addElement('Text', 'ynaffiliate_pointrate', array(
             'label' => 'Convert Rate',
             'allowEmpty' => false,
             'description' => 'Please fill in the point convert rate for 1 '.$currency,
             'required' => true,
             'validators' => array(
                 array('NotEmpty', true),
                 array('Float', true),
             ),
             'filters' => array(
                 new Engine_Filter_Censor(),
             ),
             'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1),
         ));

              // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
   }

}
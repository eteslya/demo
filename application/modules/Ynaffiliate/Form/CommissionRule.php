<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Ynaffiliate_Form_CommissionRule extends Engine_Form
{
  public function init()
  {
  

    // Init form
    $this
      ->setTitle('Commission Rule')
     // ->setDescription('Enter your affiliate information ')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
      ;
    
      $this->addElement('select', 'profiletype', array(
          'label' => 'Profile Type:',
          
          'multiOptions' => array(
              '1' => 'Regular Member',
            
          ),
      ));
  }
}
  ?>
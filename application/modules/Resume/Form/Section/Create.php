<?php



/**
 * Radcodes - SocialEngine Module
 *
 * @category   Application_Extensions
 * @package    Resume
 * @copyright  Copyright (c) 2009-2010 Radcodes LLC (http://www.radcodes.com)
 * @license    http://www.radcodes.com/license/
 * @version    $Id$
 * @author     Vincent Van <vincent@radcodes.com>
 */
 
 
 
class Resume_Form_Section_Create extends Engine_Form
{

  
  public function init()
  {
    $this->setTitle('Add New Section')
      ->setDescription('Please select new section to add to your resume.')
      ;

    $params = array(
      'resume' => 0,
      'order' => array('enabled desc', 'order')  
    );
    $sectionOptions = Engine_Api::_()->getItemTable('resume_section')->getMultiOptionsAssoc($params);  
      
    $this->addElement('Select', 'section_id', array(
      'label' => 'Section Type',
      'allowEmpty' => false,
      'required' => true,
      'attribs' => array(
        'class' => 'text'
      ),
      'multiOptions' => array(""=>"") + $sectionOptions
    ));


    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Add Section',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick'=> 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }

}
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
class Resume_Form_Resume_Create extends Engine_Form
{
  public $_error = array();

  protected $_package;

  public function getpackage()
  {
    return $this->_package;
  }

  public function setpackage($package)
  {
    $this->_package = $package;
    return $this;
  }  
  
  public function init()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    
    $field_order = 10000;
    
    $view = Zend_Registry::get('Zend_View');
    
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = $user->level_id;    
    
    $this->setTitle('Post New Resume')
      ->setDescription('Compose your resume below, then click "Post Resume" to submit it. All resume postings maybe subject to editorial review.')
      ->setAttrib('name', 'resumes_create');
   
    if ($this->_package instanceof Resume_Model_Package)  
    {
    	$this->addElement('Hidden', 'package_id', array(
    		'value' => $this->_package->getIdentity(),
    		'order' => $field_order++,
    	));
    	$this->addElement('Dummy', 'package_name', array(
    		'label' => 'Package',
    		'content' => $this->_package->toString() . ' ('.$this->_package->getTerm().')'
    	));
    }
    else
    {
	    $packages = Engine_Api::_()->resume()->getPackages(array('enabled'=>1));
	    
	    $packages_prepared = array();
	    foreach ($packages as $package)
	    {
	      $packages_prepared[$package->getIdentity()] = $package->getTitle()
	        . ' ('. $package->getTerm() .')';
	    }
	    
	    //$packages_prepared = Engine_Api::_()->resume()->convertPackagesToArray($packages);
	    
	    $this->addElement('Radio', 'package_id', array(
	      'label' => 'Package',
	      'description' => 'Please select one of the following listing packages:',
	      'multiOptions' => $packages_prepared,
	      'allowEmpty' => false,
	      'required' => true,
	      'validators' => array(
	        array('NotEmpty', true),
	      ),
	      'filters' => array(
	        'Int'
	      ),
	    ));
	  
	    $this->package_id->getDecorator("Description")->setEscape(false);  
    }
    
    $categories_prepared = array(""=>"") + Engine_Api::_()->resume()->getCategoryOptions();
    
    // category field
    $this->addElement('Select', 'category_id', array(
      'label' => 'Category',
      'multiOptions' => $categories_prepared,
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('NotEmpty', true),
      ),
      'filters' => array(
       'Int'
      ),
    ));
  
    
    $this->addElement('Text', 'title', array(
      'label' => 'Resume Title',
      'description' => 'Ex: 5yr+ Experienced PHP Programmer',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        'StringTrim',
        new Engine_Filter_Censor(),
      )
    ));
    $this->title->getDecorator("Description")->setOption("placement", "append");       


    // Description
    $this->addElement('Textarea', 'description', array(
      'label' => 'Short Description',
      'description' => 'Enter your pitch here! Sell yourself. Maximum 500 characters are allowed.',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 500)),
      ),      
    ));
    $this->description->getDecorator("Description")->setOption("placement", "append");        
    
    
    $this->addElement('File', 'photo', array(
      'label' => 'Photo'
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');    
    
    
    $this->addElement('Text', 'keywords',array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
    $this->keywords->getDecorator("Description")->setOption("placement", "append");    
   
    $this->addElement('Text', 'name', array(
      'label' => 'Full Name',
      'description' => 'Do NOT use a nickname. Ex: John Doe',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        'StringTrim',
      ),
      'value' => $viewer->getTitle(),
    ));
    $this->name->getDecorator("Description")->setOption("placement", "append");   

    $location_required = true;
    $this->addElement('Text', 'location', array(
      'label' => 'Location Address',
      'description' => 'Ex: 400 S Hill St, Los Angeles, CA 90013',
      'allowEmpty' => !$location_required,
      'required' => $location_required,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 128)),
        new Radcodes_Lib_Validate_Location_Address(),
      ),
    ));       
    $this->location->getDecorator("Description")->setOption("placement", "append");       
    
    $this->addElement('Text', 'phone', array(
      'label' => 'Phone',
      //'description' => 'Ex: (213) 456-7890; 213-456-7890; +1 (213) 456-7890;',
      'filters' => array(
        'StringTrim',
      )
    ));
    $this->phone->getDecorator("Description")->setOption("placement", "append");  
    
    $this->addElement('Text', 'mobile', array(
      'label' => 'Mobile',
      //'description' => 'Ex: (213) 456-7890; 213-456-7890; +1 (213) 456-7890;',
      'filters' => array(
        'StringTrim',
      )
    ));
    $this->mobile->getDecorator("Description")->setOption("placement", "append");  

    $this->addElement('Text', 'fax', array(
      'label' => 'Fax',
      //'description' => 'Ex: (213) 456-7890; 213-456-7890; +1 (213) 456-7890;',
      'filters' => array(
        'StringTrim',
      )
    ));
    $this->fax->getDecorator("Description")->setOption("placement", "append");      
    
    $this->addElement('Text', 'email', array(
      'label' => 'Email',
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        array('EmailAddress', true),
      ),
      'value' => $viewer->email,
    ));
    $this->email->getDecorator("Description")->setOption("placement", "append");  
    
    $this->addElement('Text', 'website', array(
      'label' => 'Website',
      'filters' => array(
        'StringTrim',
      ),
      'validators' => array(
        new Engine_Validate_Callback(array($this, 'validateWebsite')),
      ),        
    ));
    $this->website->getDecorator("Description")->setOption("placement", "append");  
    
    // Add subforms
    if( !$this->_item ) {
      $customFields = new Resume_Form_Custom_Fields();
    } else {
      $customFields = new Resume_Form_Custom_Fields(array(
        'item' => $this->getItem()
      ));
    }
    if( get_class($this) == 'Resume_Form_Resume_Create' ) {
      $customFields->setIsCreation(true);
    }

    $this->addSubForms(array(
      'fields' => $customFields
    ));
    
    // View
    $availableLabels = array(
      'everyone'              => 'Everyone',
      'registered'            => 'Registered Members',
      'owner_network'         => 'Friends and Networks',
      'owner_member_member'   => 'Friends of Friends',
      'owner_member'          => 'Friends Only',
      'owner'                 => 'Just Me'
    );
    
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('resume', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    // View
    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions), 'order' => $field_order++,));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this resume?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('resume', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));
    // Comment
    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions), 'order' => $field_order++,));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this resume?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    $photoOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('resume', $user, 'auth_photo');    
    $photoOptions = array_intersect_key($availableLabels, array_flip($photoOptions));
    // Photo
    if( !empty($photoOptions) && count($photoOptions) >= 1 ) {
      // Make a hidden field
      if(count($photoOptions) == 1) {
        $this->addElement('hidden', 'auth_photo', array('value' => key($photoOptions), 'order' => $field_order++,));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_photo', array(
            'label' => 'Photo Uploads',
            'description' => 'Who may upload photos to this resume?',
            'multiOptions' => $photoOptions,
            'value' => key($photoOptions),
        ));
        $this->auth_photo->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    
    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this resume in browse and search results',
      'value' => 1
    ));
    
    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Continue ...',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

  
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    
    $this->addDisplayGroup(array('submit','cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
    $button_group->addDecorator('DivDivDivWrapper');    

  }

  public function validateWebsite($value)
  {
    $validator = $this->website->getValidator('Engine_Validate_Callback');
    
    if (!Zend_Uri::check($value)) {
      $validator->setMessage('The Website URL appears to be invalid.');
      return false;
    }    
   
    return true;
  }
  
}
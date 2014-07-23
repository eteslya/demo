<?php

/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Marketplace
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 * @author     Jaa
 */

/**
 * @category   Application_Core
 * @package    Marketplace
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.net/license/
 */
class Marketplace_Form_Admin_Widget_Cats extends Engine_Form
{
  public function init()
  {
    parent::init();

    // Set form attributes
    $this
      ->setTitle('Widget Settings')
	;
	  
    $categories = Engine_Api::_()->marketplace()->getCategories();

    if( count($categories) > 0 ) {
      // Element: category_id
      $this->addElement('Select', 'category_id', array(
        'label' => 'Category',
      ));
      
      $this->category_id->addMultiOption(0, 'All Categories');
      foreach( $categories as $category ) {
        $this->category_id->addMultiOption($category->category_id, $category->category_name);
      }
    }
    $this->addElement('Text', 'itemCountPerPage', array(
        'label' => 'Count (number of items to show)',
    ));
  }
}
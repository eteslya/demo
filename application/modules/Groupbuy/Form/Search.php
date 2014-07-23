<?php
/**
 * YouNet
 *
 * @category   Application_Extensions
 * @package    Groupbuy
 * @copyright  Copyright 2011 YouNet Company
 * @license    http://www.modules2buy.com/
 * @version    $Id: Search.php
 * @author     Minh Nguyen
 */
class Groupbuy_Form_Search extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box',
      	'style' => 'margin-bottom: 15px;  padding-bottom: 10px; padding-top: 5px;',
      	'tabindex' => '1'
      )) ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
          'action' => 'listing',
        ), 'groupbuy_general',true));
    
    $this->addElement('Text', 'search', array(
      'label' => 'Keywords',
      'onchange' => 'this.form.submit();',
    ))->setAttrib('tabindex','3');
	
	// cateories
 	$this->addElement('Select', 'category', array(
      'label' => 'Category',
       'style' => 'width:160px',
      'multiOptions' => (array)Engine_Api::_()->getDbTable('categories','groupbuy')->getMultiOptions('..','All'),
      'onchange' => 'this.form.submit();',
    ));
	
	
	// locations
    $this->addElement('Select', 'location', array(
      'label' => 'Location',
      'multiOptions' => (array)Engine_Api::_()->getDbTable('locations','groupbuy')->getMultiOptions('..','All'),
      'onchange' => 'this.form.submit();',
    ));
    
     // status
     $this->addElement('Select', 'status', array(
      'label' => 'Status',
      'multiOptions' => array(
        '-1' => 'All',
        '20' => 'Upcoming',
        '30' => 'Running',  
        '40' => 'Closed',  
        //'50' => 'Canceled',  
      ),
       'onchange' => 'this.form.submit();',
       'value'=>30,
    ));
     $this->addElement('Select', 'published', array(
      'label' => 'Published',
      'multiOptions' => array(
        ' ' => 'All',
        '0' => 'Not Published',
        '10' => 'Waiting',
        '20' => 'Approved',
        '30' => 'Denied',  
      ),
       'onchange' => 'this.form.submit();',
    ));
    
    	// order by
    $this->addElement('Select', 'orderby', array(
      'label' => 'Browse By',
      'multiOptions' => array(
        'creation_date' => 'Most Recent Deals',
      	'featured' => 'Featured Deals',
        'rates' => 'Most Rated Deals',
      ),
      'onchange' => 'this.form.submit();',
      'value'=>'creation_date'
    ));		
    
    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));

    $this->addElement('Hidden', 'start_time', array(
      'order' => 102
    ));

    $this->addElement('Hidden', 'end_time', array(
      'order' => 103
    ));
  }
}

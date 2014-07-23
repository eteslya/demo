<?php
/**
 * YouNet
 *
 * @category   Application_Extensions
 * @package    Auction
 * @copyright  Copyright 2011 YouNet Company
 * @license    http://www.modules2buy.com/
 * @version    $Id: search auctions
 * @author     Minh Nguyen
 */

class Groupbuy_Widget_SearchDealsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
  	  
    $post = Engine_Api::_()->getItem('groupbuy_param', 1)->toArray();
	$this->view->form = $form = new Groupbuy_Form_Search();
	// var_dump($post);
	if($post['status']== 0){
		$post['status']= 30;
	}
    $form->populate($post);
    //$form->removeElement('status');
	$form->removeElement('published');
    // Process form
    //$form->isValid($post);
  }
}

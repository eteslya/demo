<?php
/**
 * 
 *
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 * @version    $Id: Controller.php 7244 2010-09-01 01:49:53Z john $
 * 
 */

/**
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 */
class Marketplace_Widget_HomeTopController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;
  
  public function indexAction()
  {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();

    $ordersTable  = Engine_Api::_()->getDbtable('orders', 'marketplace');
    $ordersTableName = $ordersTable->info('name');
    $marketplaceTable  = Engine_Api::_()->getDbtable('marketplaces', 'marketplace');
    $marketplaceTableName = $marketplaceTable->info('name');


    $select = $ordersTable->select()
      ->setIntegrityCheck(false)
      ->from($ordersTableName, array("cnt" => "COUNT({$ordersTableName}.marketplace_id)", "{$ordersTableName}.marketplace_id"))
      ->joinLeft($marketplaceTableName, "$marketplaceTableName.marketplace_id = $ordersTableName.marketplace_id", null)
      ->group("$ordersTableName.marketplace_id")
      ->order('cnt DESC')
      ->order('creation_date DESC')
      ->limit($this->_getParam('itemCountPerPage', 10))
	;

	if($category_id = $this->_getParam('category_id', 0)){
		$select
			->where($marketplaceTableName.'.category_id = ?', $category_id)
		;
	}
	
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 10));
    
    $this->view->paginator->setCurrentPageNumber(1);

    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }

    // Add count to title if configured
    if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->items_per_page = $settings->getSetting('marketplace_page', 10);
  }

  public function getChildCount()
  {
    return $this->_childCount;
  }
}
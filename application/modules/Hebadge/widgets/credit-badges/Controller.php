<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Hebadge
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: Controller.php 02.04.12 09:12 michael $
 * @author     Michael
 */

/**
 * @category   Application_Extensions
 * @package    Hebadge
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 */



class Hebadge_Widget_CreditBadgesController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $request = Zend_Controller_Front::getInstance()->getRequest();


    if ($viewer->getIdentity()){
      $this->view->owner_rank = Engine_Api::_()->getDbTable('creditbadges', 'hebadge')->getOwnerRank($viewer);
    }

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('creditbadges', 'hebadge')->getPaginator();
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page'));

    $this->getElement()->setAttrib('id', 'content_id_' . $this->view->identity);
    $this->view->name = $this->getElement()->getName();
    $this->view->simple_name = str_replace("-", "_", str_replace(".", "_", $this->getElement()->getName()));
    $this->view->paginator_type = $this->_getParam('paginator_type');

  }

}
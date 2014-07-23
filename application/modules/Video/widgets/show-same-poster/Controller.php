<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Video
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9995 2013-03-26 00:23:47Z alex $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Video
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Video_Widget_ShowSamePosterController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Check subject
    if( !Engine_Api::_()->core()->hasSubject('video') ) {
      return $this->setNoRender();
    }
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('video');

    // Set default title
    if( !$this->getElement()->getTitle() ) {
      $this->getElement()->setTitle('From the same member');
    }

    // Get tags for this video
    $itemTable = Engine_Api::_()->getItemTable($subject->getType());

    $select = $itemTable->select()
      ->from($itemTable)
      ->where('owner_id = ?', $subject->owner_id)
      ->where('video_id != ?', $subject->getIdentity())
      ->where('search = ?', true) // ?
      ;
    
    // Get paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 4));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Hide if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}
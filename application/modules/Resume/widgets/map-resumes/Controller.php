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

class Resume_Widget_MapResumesController extends Engine_Content_Widget_Abstract
{

  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    $params = array(
      'live' => true,
      'search' => 1,
      'limit' => $this->_getParam('max', 5),
      'order' => $this->_getParam('order', 'recent'),
      'period' => $this->_getParam('period'),
    
      'user' => $this->_getParam('user'),
    
      'keyword' => $this->_getParam('keyword'),
      'location' => $this->_getParam('location'),
      'distance' => $this->_getParam('distance', 50),
    
      'category' => $this->_getParam('category'),
    );
    
    if ($this->_getParam('featured', 0)) {
      $params['featured'] = 1;
    }
    
    if ($this->_getParam('sponsored', 0)) {
      $params['sponsored'] = 1;
    }
    
    $this->view->paginator = $paginator = Engine_Api::_()->resume()->getResumesPaginator($params);

    $this->view->display_style = $this->_getParam('display_style', 'wide');

    $this->view->order = $params['order'];
    
    if ($paginator->getTotalItemCount() == 0 && !$this->_getParam('showemptyresult', false)) {
      return $this->setNoRender();
    }
  }

}
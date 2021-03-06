<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Page
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: Controller.php 2011-11-10 16:05 taalay $
 * @author     Taalay
 */

/**
 * @category   Application_Extensions
 * @package    Page
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 */

class Page_Widget_SponsoredCarouselController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $cat_id = $this->_getParam('filter');
    $table = Engine_Api::_()->getDbTable('pages', 'page');

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $ipp = $settings->getSetting('page.sponsored_count', 6);
    
    $params = array(
      'cat_id' => $cat_id,
      'approved' => 1,
      'sponsored' => 1,
      'ipp' => $ipp,
      'p' => 1);
    $this->view->pages = $pages = $table->getRandomPaginator($params);

    if (!$pages->getTotalItemCount()) {
    	return $this->setNoRender();
    }
  }
}
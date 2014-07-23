<?php

class Ynaffiliate_SourcesController extends Core_Controller_Action_Standard {
	
	public function init(){
		// private page
		if(!$this -> _helper -> requireUser() -> isValid()){
			return ;
		}
    $affiliate = new Ynaffiliate_Plugin_Menus;
    if(!$affiliate->canView())
    {
       $this->_redirect('/affiliate/index');  
     //return $this->_helper->redirector->gotoRoute(array(), 'default', true);
  
    }
		Zend_Registry::set('active_menu','ynaffiliate_menu_mini');
	}
	
	public function isTestStore($userId)
  {
	return "!";
	
  }
  
	public function indexAction()
	{
     	Zend_Registry::set('active_mini_menu','static');
     	$suggests = Engine_Api::_()->ynaffiliate()->getSuggestLinks();
     	$viewer = Engine_Api::_()->user()->getViewer();
     	$this->view->viewer_id = $viewer->getIdentity();
    	$this->view->suggests = $suggests;
	}
  
  	public function dynamicAction()
	{
     	Zend_Registry::set('active_mini_menu','dynamic');
     	/*$dynamics = Engine_Api::_()->ynaffiliate()->getDynamicLinks();
     	$viewer = Engine_Api::_()->user()->getDynamicLinks();
     	$this->view->viewer_id = $viewer->getIdentity();
     	$this->view->dynamics = $dynamics;*/
  	}
	
  	public function getAffiliateLinkAction() {
  		$target_link = $this->_getParam('target_link');
  		$target_header = get_headers($target_link);
  		$target_status = $target_header[0];
  		$this->view->status = $target_status;
  		if ($target_status == null || strpos($target_status, '404') === true) {
  			$this->view->error = 1;
  			$this->view->text = Zend_Registry::get('Zend_Translate')->_('The Url format is not valid!');
  		}
  		else {
  			$request = Zend_Controller_Front::getInstance()->getRequest();
  			$host = $request->getHttpHost();
  			$parse_url = parse_url($target_link);
  			$base_url = $request->getBaseUrl();
  			if ($base_url == '') {
  				$base_url = "/";
  			}
  			$pos = strpos($target_link, $base_url);
  			if ($host != $parse_url['host'] || (!$pos)) {
  				$this->view->error = 2;
  				$this->view->text = Zend_Registry::get('Zend_Translate')->_('The Url domain is not valid!');
  			}
  			else {
		  		$viewer = Engine_Api::_()->user()->getViewer();
		  		$affiliate_url = Engine_Api::_()->ynaffiliate()->getAffiliateUrl($target_link, $viewer->getIdentity());
		  		
		  		// Save affiliate url for dynamic link after generation
		  		
		  		/*$Links = new Ynaffiliate_Model_DbTable_Links;
		  		$link = $Links->fetchNew();
		  		$link->link_title = 'Dynamic Link';
		  		$link->user_id = $viewer->getIdentity();
		  		$link->is_dynamic = 1;
		  		$link->target_url = $target_link;
		  		$link->affiliate_url = $affiliate_url;
		  		$link->creation_date = date('Y-m-d H:i:s');
		  		$link->save();*/
		  		$this->view->error = 0;
		  		$this->view->affiliate_url = $affiliate_url;
  			}
  		}
  	}
  	
}

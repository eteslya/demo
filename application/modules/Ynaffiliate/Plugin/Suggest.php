<?php

class Ynaffiliate_Plugin_Suggest{
	
	public function memberHomePage($user, $option){
		$siteUrl = Engine_Api::_()->ynaffiliate()->getSiteUrl();
		$url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array(),'home',true);
	   	$targetUrl = $siteUrl. $url;
	   	return $targetUrl;
	}
	
	public function memberProfilePage($user, $option){
		$siteUrl = Engine_Api::_()->ynaffiliate()->getSiteUrl();
		$url = $user->getHref();
	   	$targetUrl = $siteUrl. $url;
	   	return $targetUrl;
	}
	
	public function getTargetUrl($user, $option){
		$siteUrl = Engine_Api::_()->ynaffiliate()->getSiteUrl();
		if ($option->href == '') {
			$module = $option->module;
			$modulesTable = Engine_Api::_()->getDbtable('modules', 'core');
			$mselect = $modulesTable->select()
			->where('enabled = ?', 1)
			->where('name  = ?', $module);
			$module_result = $modulesTable->fetchRow($mselect);
			if(count($module_result) <= 0)	{
				return false;
			}
			$table = Engine_Api::_()->getDbtable('menuItems', 'core');
	    	$select = $table->select()
			    ->where('menu = ?', 'core_main')
		   	    ->where('module = ?', $module_result->name);
		   	$route_select = $table->fetchRow($select);
		   	$route_array = (array) $route_select->params;
		   	$route = $route_array['route'];
		   	if ($module_result->name != 'mp3music' && $module_result->name != 'pennyauction') {
		   		$url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array(),$route,true);
		   	}
		   	else {
		   		if ($module_result->name == 'mp3music') {
		   			$url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array("module" => 'mp3-music'),$route,true);
		   		}
		   		else {
		   			$url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array("module" => 'penny-auction'),$route,true);
		   		}
		   	}
		   	$targetUrl = $siteUrl. $url;
		}
		else {
			$href = $option->href;
			if ((substr($href, 0, 7) == 'http://') || (substr($href, 0, 7) == 'https://' )) {
				$targetUrl = $href;
			} 
			else {
				$request =  Zend_Controller_Front::getInstance()->getRequest();
				$targetUrl = $request->getScheme().'://'.$href;
			}
		}
	   	return $targetUrl;
	}
}

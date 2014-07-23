<?php

class Ynaffiliate_AdminStatisticController extends Core_Controller_Action_Admin{
	
	public function init() {
		Zend_Registry::set('admin_active_menu', 'ynaffiliate_admin_main_statistics');
	}
	public function indexAction(){
		$statistic = Engine_Api::_()->getApi('statistic', 'ynaffiliate');
		$this->view->totalAffiliates = $statistic->getTotalAffiliates();
		$this->view->totalClients = $statistic->getTotalClients();
		$this->view->totalSubscriptions = $statistic->getSubscriptions();
		$this->view->dealPublishing = $statistic->getDealPublishing();
		$this->view->dealPurchase = $statistic->getDealPurchase();
		$this->view->storePublishing = $statistic->getStorePublishing();
		$this->view->productPublishing = $statistic->getProductPublishing();
		$this->view->productPurchase = $statistic->getProductPurchase();
		$commissionInfo = $statistic->getCommissionInfo();
		if (count($commissionInfo) > 0) {
			$this->view->commissionInfo = $commissionInfo;
		}
		$this->view->totalCommissions = $statistic->getTotalCommissions();
		$this->view->totalRequested = $statistic->getTotalRequested();
	}
}

<?php
class Ynaffiliate_Model_Request extends Core_Model_Item_Abstract
{
	public function isWaitingToProcess(){
		return $this->request_status == 'waiting';
	}
	
	public function getAccount($gateway ='paypal'){
		return Socialstore_Api_Account::getAccount($this->owner_id, $this->store_id, $gateway);
	}
	
	
}
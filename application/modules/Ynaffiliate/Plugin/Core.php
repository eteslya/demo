<?php

class Ynaffiliate_Plugin_Core {
	
	public function onUserCreateAfter($event)
	{

		$user = $event -> getPayload();
		if (!($user instanceof User_Model_User))
		{
			return;
		}
		
		$api =  Engine_Api::_()->ynaffiliate();
		$user_id = $_COOKIE['ynafuser'];
		$link_id = $_COOKIE['ynaflink'];
		$time =  $_COOKIE['ynafftime'];
		if($user_id && $link_id){
			$api->addAssoc($user_id, $user->getIdentity(), $link_id);
		}else{
			if(!Engine_Api::_()->getApi('settings','core')->getSetting('ynaffiliate.allowinvite',true)){
				return ;
			}
			
			if(!Engine_Api::_()->hasModuleBootstrap('invite')){
				return ;
			}
			
			$session = new Zend_Session_Namespace('invite');
    		$inviteTable = Engine_Api::_()->getDbtable('invites', 'invite');
			
			// Get codes
		    $codes = array();
		    if( !empty($session->invite_code) ) {
		      $codes[] = $session->invite_code;
		    }
		    if( !empty($session->signup_code) ) {
		      $codes[] = $session->signup_code;
		    }
		    $codes = array_unique($codes);
			// Nothing, exit now
		    if( empty($codes)) {
		      return;
		    }
		    // Get related invites
		    $select = $inviteTable->select()->where('code IN(?)', $codes)->order('id');
		
			$invite = $inviteTable->fetchRow($select);
			
			if(is_object($invite)){
				$api->addAssoc($invite->user_id, $user->getIdentity(), 0, $invite->id, $invite->code, $invite->timestamp);
			}
			
		}
	}
	
	public function onUserDeleteAfter($event)
	{
		$user = $event -> getPayload();

		if (!($user instanceof User_Model_User))
		{
			return;
		}
	}

	public function onUserEnable($event)
	{
		$user = $event -> getPayload();
		if (!($user instanceof User_Model_User))
		{
			return;
		}

	}

	public function onUserDisable($event)
	{
		$user = $event -> getPayload();
		if (!($user instanceof User_Model_User))
		{
			return;
		}

	}

	public function onPaymentSubscriptionUpdateAfter($event)
	{
		try{
			$subs = $event -> getPayload();
			if (!($subs instanceof Payment_Model_Subscription))
			{
				return;
			}
			if ($subs -> status == 'active') {
				$gateway_id = $subs -> gateway_profile_id;
				$Orders = new Payment_Model_DbTable_Orders;
				$select = $Orders->select()->where("gateway_order_id = ?", $gateway_id)->where("user_id = ?", $subs->user_id);
				$result = $Orders->fetchRow($select);			
				if (($result) && $result->state == 'complete' ) {
					$params = array();
					$new_user_id = $subs->user_id;
					$user = Engine_Api::_()->ynaffiliate()->getAssocId($new_user_id);
					if ($user) {
						$user_id = $user->user_id;
						$params['affiliate_id'] = $user_id;
						$package_id = $subs->package_id;
						$Packages = new Payment_Model_DbTable_Packages;
						$select = $Packages->select()->where('package_id = ?', $package_id);
						$packages_result = $Packages->fetchRow($select);
						$amount = $packages_result->price;
						$params['total_amount'] = $amount;
						$params['currency'] = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
						$params['rule_name'] = 'subscription';
						$params['module'] = 'payment';
						$params['user_id'] = $new_user_id;
						$Commissions = new Ynaffiliate_Model_DbTable_Commissions;
						$Commissions->addCommission($params);
					}
					else {
						return;
					}
				}
				else {
					return;
				}
			}
		
		}catch(Exception $e){
			Zend_Registry::get('Zend_Log')->log(print_r($e,true), 7);
		}
	}
	
	public function onPaymentAfter($event) {
		$params = $event -> getPayload();
		Zend_Registry::get('Zend_Log')->log(print_r($params,true), 7);
		$new_user_id = $params['user_id'];
		$user = Engine_Api::_()->ynaffiliate()->getAssocId($new_user_id);
		if ($user) {
			$user_id = $user->user_id;
			$params['affiliate_id'] = $user_id;
			Zend_Registry::get('Zend_Log')->log(print_r($params,true), 7);
			$Commissions = new Ynaffiliate_Model_DbTable_Commissions;
			$Commissions->addCommission($params);
		}
		else {
			return;
		}
	}
	
	/*public function onPaymentTransactionCreateAfter($event) {
		$subs = $event -> getPayload();
		if ($subs -> state == 'okay' && $subs->type == 'payment' ) {
			$params = array();
			$new_user_id = $subs->user_id;
			$user = Engine_Api::_()->ynaffiliate()->getAssocId($new_user_id);
			if ($user) {
				$user_id = $user->user_id;
				$params['affiliate_id'] = $user_id;
				$params['total_amount'] = $subs->amount;
				$params['currency'] = $subs->currency;
				$params['rule_name'] = 'subscription';
				$params['module'] = 'payment';
				$params['user_id'] = $new_user_id;
				$Commissions = new Ynaffiliate_Model_DbTable_Commissions;
				$Commissions->addCommission($params);
			}
			else {
				return;
			}
		}
		else {
			return;
		}
	}*/

}

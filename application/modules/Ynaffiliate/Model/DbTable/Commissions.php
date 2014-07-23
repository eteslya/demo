<?php

class Ynaffiliate_Model_DbTable_Commissions extends Engine_Db_Table
{
 	protected $_rowClass = "Ynaffiliate_Model_Commission";
	
 	public function addCommission($params) {
		
 		try {
			$commission = $this->fetchNew();
			$user_id = $params['affiliate_id'];
			$rule_name = $params['rule_name'];
			$Rules = new Ynaffiliate_Model_DbTable_Rules;
			$rule = $Rules->getRuleByName($rule_name);
 			if ($rule) {
 				$rule_id = $rule->rule_id;
			}
			else {
				return;
			}
			$RulemapDetails = new Ynaffiliate_Model_DbTable_Rulemapdetails;
			$rulemaps = $RulemapDetails->getRuleMapDetail('', $user_id, $rule_id);
			if (count($rulemaps) > 0) {
				foreach ($rulemaps as $rulemap) {
					if ($rulemap->option_id == 0) {
						$first_purchase = $rulemap;
					}
					elseif ($rulemap->option_id == 1) {
						$second_purchase = $rulemap;
					} 
				}
				if ($first_purchase) {
					$rulemap_id = $first_purchase->rule_map;
				}
				$checkPurchase = $this->checkPurchase($rulemap_id, $params['user_id']);
				if (($checkPurchase) && ($second_purchase)) {
					$rule_value = $second_purchase->rule_value;
					$rule_type = $second_purchase->rule_type;
					$rule_map = $second_purchase->rule_map;
					$rule_map_detail = $second_purchase->rulemapdetail_id;
				}
				else if  (($checkPurchase) && (!$second_purchase)) { 
					return;
				}
				else {
					$rule_value = $first_purchase->rule_value;
					$rule_type = $first_purchase->rule_type;
					$rule_map = $first_purchase->rule_map;
					$rule_map_detail = $first_purchase->rulemapdetail_id;
				}
				$total_amount = $params['total_amount'];
				if ($rule_type == 0) {
					$commission_rate = $rule_value;
					$commission_amount = round($total_amount * $commission_rate/100, 2);
					$commission_type = 0;
				}
				else {
					$commission_rate = 0;
					$commission_amount = $rule_value;
					$commission_type = 1; 
				}
				$point_convert_rate = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1);
				$purchase_currency = $params['currency'];
				$base_currency = Engine_Api::_()->getApi('settings', 'core')->payment['currency'];
				if ($purchase_currency != $base_currency) {
					$ExchangeRates = new Ynaffiliate_Model_DbTable_Exchangerates;
					$new_commission_amount = $ExchangeRates->calculatePoints($purchase_currency, $commission_amount);
					if ($new_commission_amount) {
						$commission_point = $point_convert_rate * $new_commission_amount;
					}
					else {
						$commission_point = 0;
					}
				}
				else {
					$commission_point = $point_convert_rate * $commission_amount;
				}
				$commission->rule_id = $rule->rule_id;
				$commission->rulemap_id = $rule_map;
				$commission->rulemapdetail_id = $rule_map_detail;
				$commission->module = $params['module'];
				$commission->user_id = $user_id;
				$commission->from_user_id = $params['user_id'];
				$commission->purchase_currency = $params['currency'];
				$commission->purchase_total_amount = $params['total_amount'];
				$commission->commission_amount = $commission_amount;
				$commission->commission_rate = $commission_rate;
				$commission->commission_type = $commission_type;
				$commission->commission_points = $commission_point;
				$commission->creation_date = date('Y-m-d H:i:s');
				$commission->save();
			}
			else {
				return;
			}
			
		}
 		catch(Exception $e) {
			throw $e;
		}
	}
	
	public function getTotalPoints($user_id) {
		$select = $this->select()->where('user_id = ?', $user_id)->where('approve_stat = ?', 'approved');
		$results = $this->fetchAll($select);
		$total_points = 0;
		foreach ($results as $result) {
			$total_points += $result->commission_points;
		}
		return $total_points;
	}
	
	public function getAvailablePoints($user_id) {
		$total_points = $this->getTotalPoints($user_id);
		$Requests = new Ynaffiliate_Model_DbTable_Requests;
		$requested_points = $Requests->getRequestedPoints($user_id);
		$current_request = $Requests->getCurrentRequestPoints($user_id);
		$available_points = round($total_points - $requested_points - $current_request, 2);
		return $available_points;
	}
	
	public function checkPurchase($rulemap_id, $from_user_id) {
		$select = $this->select()->where('from_user_id = ?', $from_user_id)->where('rulemap_id = ?', $rulemap_id);
		$results = $this->fetchAll($select);
		if (count($results) > 0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function convertPoints($purchase_currency, $exchange_rate) {
		$select = $this->select()->where('purchase_currency = ?', $purchase_currency)->where('commission_points = 0');
		$results = $this->fetchAll($select);
		$point_convert_rate = Engine_Api::_()->getApi('settings', 'core')->getSetting('ynaffiliate.pointrate', 1);
		if ($results) {
			foreach ($results as $result) {
				$new_commission_amount = $result->commission_amount / $exchange_rate;
				$result->commission_points = $point_convert_rate * $new_commission_amount;
				$result->save();
			}
		}
	}
}
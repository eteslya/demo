<?php
class Ynaffiliate_Api_Statistic {
	
	public function getSubscriptions($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id =  1
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$subscriptions = (int)$result;
		return $subscriptions;
	}
	
	public function getPurchases($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id <>  1
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getTotalAffiliates() {
		$Accounts = new Ynaffiliate_Model_DbTable_Accounts;
		$select = $Accounts->select()->where('approved = 1');
		$results = $Accounts->fetchAll($select);
		$totalAffiliates = count($results);
		return $totalAffiliates;
	}
	
	public function getTotalClients() {
		$Assoc = new Ynaffiliate_Model_DbTable_Assoc;
		$select = $Assoc->select()->where('approved = 1');
		$results = $Assoc->fetchAll($select);
		$totalClients = count($results);
		return $totalClients;
	}
	
	public function getDealPurchase($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id = 2
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getDealPublishing($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id = 3
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getStorePublishing($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id = 4
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getProductPublishing($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id = 6
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getProductPurchase($user_id = null) {
		$sql = "select 
				count(com.commission_id) from engine4_ynaffiliate_commissions as com
				where com.rule_id = 5
				and com.approve_stat = 'approved'";
		if ($user_id != null) {
			$add_on = " and com.user_id =  $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$purchases = (int)$result;
		return $purchases;
	}
	
	public function getCommissionInfo($user_id = null) {
		$sql = "SELECT 
				count( com.commission_id ) AS count, com.module AS module, com.rule_id AS rule_id
				FROM engine4_ynaffiliate_commissions AS com
				WHERE com.approve_stat = 'approved'
				GROUP BY com.rule_id";
		if ($user_id != null) {
			$add_on = " and com.user_id = $user_id;";
			$sql .= $add_on;
		}
		$db = Engine_Db_Table::getDefaultAdapter();
		$results = $db -> fetchAll($sql);
		return $results;
	}
	
	public function getTotalCommissions() {
		$sql = "select 
				sum(com.commission_points) from engine4_ynaffiliate_commissions as com
				where com.approve_stat = 'approved'";
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$totalCommissions = floor($result);
		return $totalCommissions;
	}
	
	public function getTotalRequested() {
		$sql = "select 
				sum(req.request_points) from engine4_ynaffiliate_requests as req
				where req.request_status = 'completed'";
		$db = Engine_Db_Table::getDefaultAdapter();
		$result = $db -> fetchOne($sql);
		$totalRequested = floor($result);
		return $totalRequested;		
	}
}
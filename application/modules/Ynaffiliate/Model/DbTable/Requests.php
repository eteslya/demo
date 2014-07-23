<?php
class Ynaffiliate_Model_DbTable_Requests extends Engine_Db_Table
{
 	protected $_rowClass = "Ynaffiliate_Model_Request";
 	
 	public function getRequestedPoints($user_id) {
 		$select = $this->select()->where('user_id = ?', $user_id)->where('request_status = ?', 'completed' );
 		$results = $this->fetchAll($select);
 		$requested_points = 0;
 		foreach ($results as $result) {
 			$requested_points += $result->request_points;
 		}
 		return $requested_points;
 	}
 	
 	public function getCurrentRequestPoints($user_id) {
 		$select = $this->select()->where('user_id = ?', $user_id)->where('request_status in ("waiting", "pending")');
 		$results = $this->fetchAll($select);
 		$current_request = 0;
 		foreach ($results as $result) {
 			$current_request += $result->request_points;
 		}
 		return $current_request;
 	}
}

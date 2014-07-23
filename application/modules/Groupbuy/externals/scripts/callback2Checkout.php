<?php

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))));  
include APPLICATION_PATH . '/application/modules/Groupbuy/cli.php'; 

$logger = new Zend_Log(new Zend_Log_Writer_Stream(APPLICATION_PATH . '/temporary/log/groupbuy-callback.'.date('Y-m-d').'.log'));
$logger->log(var_export($_REQUEST,true),Zend_Log::DEBUG);

ini_set('display_errors',1);
ini_set('error_reporting',-1);
ini_set('display_startup_error',1);

try
{	
    $action = @$_REQUEST['action'];
	$req4 = @$_REQUEST['req4'];
    $req5 = @$_REQUEST['req5'];
    $status = 'COMPLETED';//;@$_REQUEST['status'];
    $payer_status = 'verified';//@$_REQUEST['payer_status'];
    $payment_status = 'Completed';//@$_REQUEST['payment_status'];
	$total = @mysql_escape_string(($_REQUEST['total']));
    $currency = @mysql_escape_string(($_REQUEST['currency']));
    $sid = @mysql_escape_string(($_REQUEST['sid']));

	switch($action){
	       case 'callback2Checkout':
               $Bills  =  new Groupbuy_Model_DbTable_Bills;
               $select =  $Bills->select()->where('sercurity=?', $req4)->where('invoice=?',$req5);
               $bill =  $Bills->fetchRow($select);
               if($bill)
               {
                   if($bill->bill_status == 0 && ($status == 'COMPLETED' || $payment_status =='Completed') && $payer_status =='verified'){
				        $transaction_ID = @$_REQUEST['order_number'];			
					    $gift_id =  @$_REQUEST['gift_id'];
					    
					    if(!is_object($bill)){
						    throw new Exception("there are no bill with secrity: $req4 and invoice: $req5");
					    }
					    if($bill->bill_status == 0 
					    && $bill->amount == $total
					    && $bill->emal_receiver == $sid
					    && $bill->currency == $currency)
					    {
	                    // insert to buy deals table
	                    // @see engine4_groupbuy_buydeals
	                    Zend_Registry::get('Zend_Log')->log(print_r('vao 1',true),Zend_Log::DEBUG);
					    	$buy  =  insertBuy($bill);
					    //	Zend_Registry::get('Zend_Log')->log(print_r('vao 12',true),Zend_Log::DEBUG);
	                    $deal = updateTotalBuy($bill);
	                    //Zend_Registry::get('Zend_Log')->log(print_r('vao 13',true),Zend_Log::DEBUG);
	                    updateTotalAmount($bill, $deal);
					   // Zend_Registry::get('Zend_Log')->log(print_r('vao 14',true),Zend_Log::DEBUG);

	                    $tracking = saveTrackingPayIn($bill,$transaction_ID); 
	                    //Zend_Registry::get('Zend_Log')->log(print_r('vao 15',true),Zend_Log::DEBUG);
	                    updateBillStatus($bill,1,$tracking->getIdentity());
	                    //Zend_Registry::get('Zend_Log')->log(print_r('vao 16',true),Zend_Log::DEBUG);
	                    
	                    
				         //Call Event from Affiliate
				         
				        $module = 'ynaffiliate';
				        $modulesTable = Engine_Api::_()->getDbtable('modules', 'core');
							$mselect = $modulesTable->select()
							->where('enabled = ?', 1)
							->where('name  = ?', $module);
						$module_result = $modulesTable->fetchRow($mselect);
						if(count($module_result) > 0)	{
							$params['module'] = 'groupbuy';
							$params['user_id'] = $bill->user_id;
							$params['rule_name'] = 'buy_deal';
							$params['currency'] = $currency;
							$params['total_amount'] = $bill->amount;
				        	Engine_Hooks_Dispatcher::getInstance()->callEvent('onPaymentAfter', $params);
						}
				        
				        // End Call Event from Affiliate
				        
	                    
	                    
					    // send a bill to user.
					    $billInfo =  $bill->toArray();
					    $billInfo['code'] = $transaction_ID;
					    $billInfo['coupon_codes'] =  $bill->getCoupons(' - ');
					    
					    $buyer = Engine_Api::_()->getItem('user', $bill->user_id);
	                    $seller = Engine_Api::_()->getItem('user', $bill->owner_id);
	                    
	                    // get mail service object
	                    $mailService = Engine_Api::_()->getApi('mail','groupbuy');
					    
					    // always send to seller.
					    $gift =  $bill->getGift($gift_id);									   
					    if(is_object($gift)){						
						    // update gift status
						    
						    $gift->bill_id =  $bill->getIdentity();
						    $gift->save();
						    $mailService->send($buyer->email, 'groupbuy_buygiftbuyer',$billInfo);
						    
						    // send notification to the gift's receiver.
						    $mailService->send($gift->friend_email, 'groupbuy_giftconfirm',$billInfo);
						    
						    // send notification to buyer
						    $mailService->send($seller->email, 'groupbuy_buygiftseller',$billInfo);
						    
					    }else{
						    // send notification to seller.
						    $mailService->send($seller->email, 'groupbuy_buydealseller',$billInfo);
						    // send notification to buyer
						    $mailService->send($buyer->email, 'groupbuy_buydealbuyer',$billInfo);	
					    }
						                    
					       
                   }
               }
			}
             $url = curPageURL();
            $index = strpos($url,"/application/");
            $core_path = substr($url,0,$index);
            header('Location:'.$core_path.'/group-buy/manage-buying');
            exit;  
			// ended.
			break;
		default:
	            throw new Exception("No action request!");
	}
}catch(Exception $e){
	$logger->log($e->getMessage(),Zend_Log::ERR);
	//throw $e;
}

function processRequestMoneyDenied($request){
	if($request->request_status > 0){
		throw new Exception("This request has been processed cussessfully before");
	}
	$request->request_status = -3; // failed.
	$request->save();
	
}

function processRequestMoneyFailed($request){
	if($request->request_status > 0){
		throw new Exception("This request has been processed cussessfully before");
	}
	$request->request_status = -1; // failed.
	$request->save();
	
}

function processRequestMoneyPending($request){
	if($request->request_status > 0){
		throw new Exception("This request has been processed cussessfully before");
	}
	
	$request->request_status = -2; // pending by paypal, check the transaction historycal by admin.
	$request->save();
	
}

/**
 * cong tien vao tai khoan cua nguoi ban
 * @param  Groupbuy_Model_Bill
 * @param  Groupbuy_Model_Deal
 * @return Groupbuy_Model_PaymentAccount
 */
function updateTotalAmount($bill)
{
    $account = getFinanceAccount($bill->owner_id,2);
	$account->total_amount = $account->total_amount + $bill->amount - $bill->commission_fee;
	$account->total_price_amount += $bill->item_price * $bill->number - $bill->commission_fee;
	$account->save();
	return $account;
}

/**
 * cap nhat lai tinh trang cua deal, kiem tra neu deal da bi mua het.
 * @param   Groupbuy_Model_Bill  $bill
 * @return  Groupbuy_Model_Deal
 * 
 */
function updateTotalBuy($bill){
	$Table =  new Groupbuy_Model_DbTable_Deals;
	$deal =  $Table->find($bill->item_id)->current();
	
	if(!is_object($deal)){
		throw new Exception ("the deal does not found!");
	}
	
	$deal->current_sold = $deal->current_sold + $bill->number;
	
	if( $deal->current_sold >= $deal->max_sold ){
		$deal->status = 40;
		$deal->end_time =  date('Y-m-d H:i:s');
	}
	$deal->save();
	return $deal;
}

/**
 * @param  int      $user_id        user id
 * @param  string   $payment_type   check payment type
 * @return Groupbuy_Model_PaymentAccount
 */
function getFinanceAccount($user_id = null,$payment_type = null)
{
	$Table =  new Groupbuy_Model_DbTable_PaymentAccounts;
	$select = $Table->select();
	
    if($user_id)
    {
        $select->where('user_id=?', $user_id);
    }
    if($payment_type)
    {
    	$select->where('payment_type=?', $payment_type);
    }
		
	$account =  $Table->fetchRow($select);
    
	// check is there finnance account
	if(!is_object($account)){
		throw new Exception("payment account does not exists");
	}
    return $account;
}

/**
 * add to transaction tracking.
 * 
 * @param   Groupbuy_Model_Bill   $bill
 * @param   Groupbuy_Model_TransactionTracking
 */
function saveTrackingPayIn($bill, $transaction_ID)
{
    // buyer account
    $account = getFinanceAccount($bill->user_id,2);
	
	// seller account.  
	$accSell = getFinanceAccount($bill->owner_id,2);
	$table  =  new Groupbuy_Model_DbTable_TransactionTrackings;
	$item =    $table->fetchNew();


	// them transaction tracking
	$item->transaction_date =    date('Y-m-d H:i:s');
	$item->user_seller = $bill->owner_id;
	$item->user_buyer  = $bill->user_id;
	$item->item_id     = $bill->item_id;
    $item->amount      = $bill->amount;
    $item->commission_fee      = $bill->commission_fee;
	$item->currency      = $bill->currency;
	$item->number      = $bill->number;
	$item->account_seller_id = $accSell->paymentaccount_id;
	$item->account_buyer_id  = $account->paymentaccount_id;
	$item->transaction_status = 1;
	$item->params   = sprintf('2Checkout #%s',$transaction_ID);
	$item->save();
	return $item;
}

/**
 * @param Groupbuy_Model_Bill $bill
 * @param number   $status    status [0,1]
 * @param string   $transid   transaction id
 * @return null
 */ 
function updateBillStatus($bill , $status, $tranid){
	$bill->bill_status = $status;
	$bill->save();
	for ($i = 1; $i <= $bill->number; $i++) {
     	$coupon_code =  Engine_Api::_()->getDbTable('coupons','groupbuy')->addCoupon($bill->user_id,$bill->item_id,$bill->bill_id, 0, $tranid);
    }
}

/**
 * @param  Groupbuy_Model_Bill $bill
 * @return Groupbuy_Model_BuyDeal
 */
function insertBuy($bill){
	$Buys =  new Groupbuy_Model_DbTable_BuyDeals;
	$buy  = $Buys->fetchNew();
	$buy->setFromArray($bill->toArray());
	$buy->buy_date = date('Y-m-d H:i:s');
	$buy->save();
	return $buy;
}
 function curPageURL() {
         $pageURL = 'http';
     if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
     if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     } else {
         $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
     return $pageURL;
    }
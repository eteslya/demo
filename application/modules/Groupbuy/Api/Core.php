<?php
 /**
 * YouNet
 *
 * @category   Application_Extensions
 * @package    Auction
 * @copyright  Copyright 2011 YouNet Developments
 * @license    http://www.modules2buy.com/
 * @version    $Id: Core.php
 * @author     Minh Nguyen
 */
class Groupbuy_Api_Core extends Core_Api_Abstract
{
  const IMAGE_WIDTH = 720;
  const IMAGE_HEIGHT = 720;
  
  const THUMB_WIDTH = 170;
  const THUMB_HEIGHT = 140;
  
  static public function getDefaultCurrency(){
  	return Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.currency', 'USD');
  }
  
  public function getDealsPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getDealsSelect($params));
   
    if( !empty($params['page']) )
    {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if( !empty($params['limit']) )
    {
      $paginator->setItemCountPerPage($params['limit']);
    }
    return $paginator;
  }
  
  /**
   * XXX: need to implement this to viewer type.
   */
  public function getMaxAllowCategory(){
  	return Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.allowCategory', 3);
  }
  public function getDealsSelect($params = array())
  {
  	$table = Engine_Api::_()->getDbtable('deals', 'groupbuy');
    $rName = $table->info('name');
    $select = $table->select()->from($rName)->setIntegrityCheck(false);
	$select->joinLeft('engine4_groupbuy_categories', "$rName.category_id = engine4_groupbuy_categories.category_id", 'engine4_groupbuy_categories.title as cat_title');
	$select->joinLeft('engine4_groupbuy_locations', "$rName.location_id = engine4_groupbuy_locations.location_id", 'engine4_groupbuy_locations.title as location_title');
	
    // by search
    
    if(@$params['search'] && $search = trim($params['search']))
    {
      $select->where($rName.".title LIKE ? OR ".$rName.".description LIKE ?", '%'.$search.'%');
    }
   if(@$params['title'] && $title = trim($params['title']))
    {
      $select->where($rName.".title LIKE ? ", '%'.$title.'%');
    }
    if( isset($params['featured']) && $params['featured'] != ' ')
    {
      $select->where($rName.".featured = ? ",$params['featured']);
    }
    if( isset($params['stop']) && $params['stop'] != ' ')
    {
      $select->where($rName.".stop = ? ",$params['stop']);
    }
    // by where
    if(isset($params['where']) && $params['where'] != "")
    	$select->where($params['where']);
    // by User
    if(!empty($params['user_id']) && is_numeric($params['user_id']))
    	$select->where("$rName.user_id = ?",$params['user_id']);
    // by Buyer
    if(!empty($params['buyer_id']) && is_numeric($params['buyer_id']))
    {
        $select->joinLeft('engine4_groupbuy_buy_deals', "$rName.deal_id = engine4_groupbuy_buy_deals.item_id", array('engine4_groupbuy_buy_deals.status as status_buy','engine4_groupbuy_buy_deals.buydeal_id as item','engine4_groupbuy_buy_deals.number as number','engine4_groupbuy_buy_deals.amount as total'));
        $select->where("engine4_groupbuy_buy_deals.user_id = ?",$params['buyer_id']);
        $select->where("engine4_groupbuy_buy_deals.status != -1");
    }
    // by Category
    if(!empty($params['category']) && $params['category'] > 0)
    {
    	$ids=  Engine_Api::_()->getDbTable('categories','groupbuy')->getDescendent($params['category']);
		$select->where("$rName.category_id in (?)", $ids);
    }
    if(!empty($params['location']) && $params['location'] > 0)
    {
    	$ids=  Engine_Api::_()->getDbTable('locations','groupbuy')->getDescendent($params['location']);
		$select->where("$rName.location_id in (?)", $ids);
    }
	
    // by status
    $status = 30;
	if(isset($params['status'])){
		$status =  $params['status'];
	}
	
	if(1)
    {
    	
    	$cur_time = Groupbuy_Api_Core::getCurrentServerTime();
		if($status == 20){
			$select->where("$rName.status =? ",20)->where("$rName.published=?",20)->where("$rName.start_time>?", $cur_time)
			->where("$rName.current_sold < $rName.max_sold");
		}else if ($status == 30){
			$select->where("$rName.status in (20,30) ")->where("$rName.published=?",20)->where("$rName.start_time<=?", $cur_time)->where("$rName.end_time>=?", $cur_time)
			->where("$rName.current_sold < $rName.max_sold");
		}else if($status == 40){
			$select->where("(($rName.status in (20,30) and $rName.published=20 and (($rName.end_time< '$cur_time') or ($rName.current_sold >= $rName.max_sold))) or ($rName.status = 40))");			
		}else if($status == -1){
			$select->where("($rName.published=20 and not $rName.status in (50,10))");
		}else if($status == 0){
			$select->where("$rName.status=0 and $rName.end_time > '$cur_time'");
		}else if($status ==  10){
			$select->where("$rName.status=10 and $rName.end_time > '$cur_time'");
		}else if($status == -2 ){
			
		}else if($status == -3){
			
		}else{
			$select->where("$rName.status =  ?", $status);
		}
		//echo $select;
		
    } 
     // by publish
    if(isset($params['published']) && $params['published'] != ' ' && $params['published'] != '')
    {
        $published = $params['published'];
        $select->where("$rName.published = ?",$published);
    } 
     if(isset($params['order']) && $params['order'])
     {
        if($params['order'] == 'cat_title')
        {
            
        }
     if($params['order'] == 'location_title')
        {
            
        }
        if($params['order'] == 'username')
        {
            $select->joinLeft('engine4_users', "$rName.user_id = engine4_users.user_id", 'engine4_users.user_id');
        }  
        $select->order($params['order'].' '.$params['direction']);
     }
     else
     {
        // order
        if(isset($params['orderby']) && $params['orderby'])
     	   	$select->order($params['orderby'].' DESC');
        else
        {
    	    $select->order("$rName.creation_date DESC");
        }
     }
    $select->where("$rName.is_delete = 0");	

	if(getenv('DEVMODE') == 'localdev'){
		print_r($params);
		echo $select;	
	}
    return $select;
  }
  public function getCategories()
  {
    $table = Engine_Api::_()->getDbTable('categories', 'groupbuy');
    return $table->fetchAll($table->select()->order('title ASC'));
  }
  public function getLocations()
  {
    $table = Engine_Api::_()->getDbTable('locations', 'groupbuy');
    return $table->fetchAll($table->select()->order('title ASC'));
  }
  public function getAVGrate($deal_id)
  {
        $rateTable = Engine_Api::_()->getDbtable('rates', 'groupbuy');
        $select = $rateTable->select()
        ->from($rateTable->info('name'), 'AVG(rate_number) as rates')
        ->group("deal_id")
        ->where('deal_id = ?', $deal_id);
        $row = $rateTable->fetchRow($select);
        return ((count($row) > 0)) ? $row->rates : 0;
    }
      public function canRate($row,$user_id)
      {
        if ($row->user_id == $user_id && Engine_Api::_()->getApi('settings', 'core')->getSetting('groupbuy.rate', 0) == 0)
            return 0;
        $rateTable = Engine_Api::_()->getDbtable('rates', 'groupbuy');
        $select = $rateTable->select()
        ->where('deal_id = ?', $row->getIdentity())
        ->where('poster_id = ?', $user_id);

        return (count($rateTable->fetchAll($select)) > 0)?0:1;
    }
    public function createPhoto($params, $file)
  {
    if( $file instanceof Storage_Model_File )
    {
      $params['file_id'] = $file->getIdentity();
    }

    else
    {
      // Get image info and resize
      $name = basename($file['tmp_name']);
      $path = dirname($file['tmp_name']);
      $extension = ltrim(strrchr($file['name'], '.'), '.');

      $mainName = $path.'/m_'.$name . '.' . $extension;
      $profileName = $path.'/p_'.$name . '.' . $extension;
      $thumbName = $path.'/t_'.$name . '.' . $extension;
      $thumbName1 = $path.'/t1_'.$name . '.' . $extension;

      $image = Engine_Image::factory();
      $image->open($file['tmp_name'])
          ->resize(self::IMAGE_WIDTH, self::IMAGE_HEIGHT)
          ->write($mainName)
          ->destroy();
       // Resize image (profile)
       $image = Engine_Image::factory();
       $image->open($file['tmp_name'])
          ->resize(400, 400)
          ->write($profileName)
          ->destroy();
      $image = Engine_Image::factory();
      $image->open($file['tmp_name'])
          ->resize(339,195)
          ->write($thumbName1)
          ->destroy();
      
      $image = Engine_Image::factory();
      $image->open($file['tmp_name'])
          ->resize(self::THUMB_WIDTH, self::THUMB_HEIGHT)
          ->write($thumbName)
          ->destroy();

      // Store photos
      $photo_params = array(
        'parent_id' => $params['deal_id'],
        'parent_type' => 'deal',
      );
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
      $profileFile = Engine_Api::_()->storage()->create($profileName, $photo_params);
      $thumbFile = Engine_Api::_()->storage()->create($thumbName, $photo_params);
      $thumbFile1 = Engine_Api::_()->storage()->create($thumbName1, $photo_params);
      $photoFile->bridge($profileFile, 'thumb.profile');
      $photoFile->bridge($thumbFile, 'thumb.normal');
      $photoFile->bridge($thumbFile1, 'thumb.normal1');
      $params['file_id'] = $photoFile->file_id; // This might be wrong
      $params['photo_id'] = $photoFile->file_id;

      // Remove temp files
      @unlink($mainName);
      @unlink($profileName);
      @unlink($thumbName);
      @unlink($thumbName1);
      
    }
    $row = Engine_Api::_()->getDbtable('photos', 'groupbuy')->createRow();
    $row->setFromArray($params);
    $row->save();
    return $row;
  }
  public function getDealStatistics($status)
  {
     $return = array();
     for($i = 0 ; $i < 5; $i ++)
     {
         $total = $this->getDealBuyStatus($i,$status);
         if(!$total)
            $total = 0;
         $return[$i] = $total;
     }
     return $return; 
  }
  function getDealBuyStatus($time,$status)
  {
      if(!$status)
        $status = 0;
      $table = Engine_Api::_()->getDbtable('deals', 'groupbuy');
      $rName = $table->info('name');
      $select = $table->select()->from($rName,"Count($rName.deal_id) as total");
      if($time == 0)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())")
           ->where("MONTH($rName.modified_date) = MONTH(NOW())") 
           ->where("DAY($rName.modified_date) = DAY(NOW())");
      }
      else if($time == 1)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())") 
          ->where("WEEKOFYEAR($rName.modified_date) = WEEKOFYEAR(NOW())");
      }
      else if($time == 2)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())") 
            ->where("MONTH($rName.modified_date) = MONTH(NOW())");
      }
      else if($time == 3)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())");
      }
      $select ->where("$rName.is_delete = 0")
      ->where("$rName.status = ?",$status);
      $total =  $table->fetchRow($select);
      return $total->total;
  }
  public function getAmounts($status)
  {
     $return = array();
     for($i = 0 ; $i < 5; $i ++)
     {
         $total = $this->getAmountBuyStatus($i,$status);
         if(!$total)
            $total = 0;
         $return[$i] = $total;
     }
     return $return; 
  }
  function getAmountBuyStatus($time,$status)
  {
      if(!$status)
        $status = 0;
      $table = Engine_Api::_()->getDbTable('transactionTrackings', 'groupbuy');
      $rName = $table->info('name');
      $select = $table->select()->from($rName,"Sum($rName.amount) as total");
      if($time == 0)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())")
           ->where("MONTH($rName.transaction_date) = MONTH(NOW())") 
           ->where("DAY($rName.transaction_date) = DAY(NOW())");
      }
      else if($time == 1)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())") 
          ->where("WEEKOFYEAR($rName.transaction_date) = WEEKOFYEAR(NOW())");
      }
      else if($time == 2)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())") 
            ->where("MONTH($rName.transaction_date) = MONTH(NOW())");
      }
      else if($time == 3)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())");
      }
      if($status == "total")
      {
            $select->where("($rName.params = 'Paid amount to Buyer' OR $rName.params = 'Paid amount to Seller')");
      }
      else
      {
          $select->where("$rName.params LIKE '$status%'");
      }
      
      $select->where("$rName.transaction_status = 1");
      $total =  $table->fetchRow($select);
      return $total->total;
  }
  public function getRequests($status)
  {
     $return = array();
     for($i = 0 ; $i < 5; $i ++)
     {
         $total = $this->getRequestBuyStatus($i,$status);
         if(!$total)
            $total = 0;
         $return[$i] = $total;
     }
     return $return; 
  }
  function getRequestBuyStatus($time,$status)
  {
      if(!$status)
        $status = 0;
      $table = Engine_Api::_()->getDbTable('transactionTrackings', 'groupbuy');
      $rName = $table->info('name');
      $select = $table->select()->from($rName,"Count(*) as total");
      if($time == 0)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())")
           ->where("MONTH($rName.transaction_date) = MONTH(NOW())") 
           ->where("DAY($rName.transaction_date) = DAY(NOW())");
      }
      else if($time == 1)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())") 
          ->where("WEEKOFYEAR($rName.transaction_date) = WEEKOFYEAR(NOW())");
      }
      else if($time == 2)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())") 
            ->where("MONTH($rName.transaction_date) = MONTH(NOW())");
      }
      else if($time == 3)
      {
          $select ->where("YEAR($rName.transaction_date) = YEAR(NOW())");
      }
     if($status == "total")
      {
            $select->where("($rName.params = 'Paid amount to Buyer' OR $rName.params = 'Paid amount to Seller')");
      }
      else
      {
          $select->where("$rName.params = ?",$status);
      }
      $select->where("$rName.transaction_status = 1");
      $total =  $table->fetchRow($select);
      return $total->total;
  }
  public function getPublished($published)
  {
     $return = array();
     for($i = 0 ; $i < 5; $i ++)
     {
         $total = $this->getPublishBuyStatus($i,$published);
         if(!$total)
            $total = 0;
         $return[$i] = $total;
     }
     return $return; 
  }
  function getPublishBuyStatus($time,$published)
  {
      if(!$published)
        $published = 0;
      $table = Engine_Api::_()->getDbtable('deals', 'groupbuy');
      $rName = $table->info('name');
      $select = $table->select()->from($rName,"Count($rName.deal_id) as total");
      if($time == 0)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())")
           ->where("MONTH($rName.modified_date) = MONTH(NOW())") 
           ->where("DAY($rName.modified_date) = DAY(NOW())");
      }
      else if($time == 1)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())") 
          ->where("WEEKOFYEAR($rName.modified_date) = WEEKOFYEAR(NOW())");
      }
      else if($time == 2)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())") 
            ->where("MONTH($rName.modified_date) = MONTH(NOW())");
      }
      else if($time == 3)
      {
          $select ->where("YEAR($rName.modified_date) = YEAR(NOW())");
      }
      $select ->where("$rName.is_delete = 0")
      ->where("$rName.published = ?",$published);
      $total =  $table->fetchRow($select);
      return $total->total;
  }

  public function getStatistics($deal,  $codeallow = null)
  {
      //$params['deal_id'] = $deal;
    $params = $deal;  
  	$statistics = Groupbuy_Api_Cart::getTrackingTransaction($params, $codeallow);
     return $statistics;
  }
  
  /**
   * @var string   datetime string
   */
  protected static $_currentServerTime;
  
  /**
   * get current server datetime string
   */
  public static function getCurrentServerTime(){
  	
  	if(self::$_currentServerTime == NULL){
  		$time =  time();
  		self::$_currentServerTime =date('Y-m-d H:i:s', $time);
  	}
	return self::$_currentServerTime;
  	
  }
  public function approveDeal($deal_id)
  {
     $deal = Engine_Api::_()->getItem('deal', $deal_id); 
     $deal->published = 20;
      $deal->status = 20;  
      $deal->modified_date = date('Y-m-d H:i:s');
      $deal->save(); 
      //add activity feed.
       $table = Engine_Api::_()->getItemTable('deal');
        $db = $table->getAdapter();
        $db->beginTransaction();
        try {
          $user =  Engine_Api::_()->getItem('user', $deal->user_id); 
          $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($user, $deal, 'groupbuy_new');
          if( $action != null ) {
            Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $deal);
          }
          $db->commit();
        }

        catch( Exception $e )
        {
          $db->rollBack();
          throw $e;
        }
      $sendTo = $deal->getOwner()->email;
      $params = $deal->toArray();
      //Engine_Api::_()->getApi('mail','groupbuy')->send($sendTo, 'groupbuy_approvedeal',$params);
      }
  
}

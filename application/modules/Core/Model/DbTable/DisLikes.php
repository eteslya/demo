<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: DisLikes.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Core_Model_DbTable_DisLikes extends Engine_Db_Table
{
  protected $_rowClass = 'Core_Model_DisLike';

  protected $_custom = false;

  public function __construct($config = array())
  {
    if( get_class($this) !== 'Core_Model_DbTable_DisLikes' ) {
      $this->_custom = true;
    }

    parent::__construct($config);
  }

  public function getDisLikeTable()
  {
    return $this;
  }

  public function addDisLike(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $row = $this->getDisLike($resource, $poster);
    if( null !== $row )
    {
      throw new Core_Model_Exception('Already liked');
    }

    $table = $this->getDisLikeTable();
    $row = $table->createRow();

    if( isset($row->resource_type) )
    {
      $row->resource_type = $resource->getType();
    }

    $row->resource_id = $resource->getIdentity();
    $row->poster_type = $poster->getType();
    $row->poster_id = $poster->getIdentity();
    $row->save();

    if( isset($resource->like_count) )
    {
      $resource->like_count++;
      $resource->save();
    }

    return $row;
  }

  public function removeDisLike(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $row = $this->getDisLike($resource, $poster);
    if( null === $row )
    {
      throw new Core_Model_Exception('No like to remove');
    }

    $row->delete();

    if( isset($resource->like_count) )
    {
      $resource->like_count--;
      $resource->save();
    }

    return $this;
  }

  public function isDisLike(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    return ( null !== $this->getDisLike($resource, $poster) );
  }

  public function getDisLike(Core_Model_Item_Abstract $resource, Core_Model_Item_Abstract $poster)
  {
    $table = $this->getDisLikeTable();
    $select = $this->getDisLikeSelect($resource)
      ->where('poster_type = ?', $poster->getType())
      ->where('poster_id = ?', $poster->getIdentity())
      ->limit(1);

    return $table->fetchRow($select);
  }

  public function getDisLikeSelect(Core_Model_Item_Abstract $resource)
  {
    $select = $this->getDisLikeTable()->select();

    if( !$this->_custom )
    {
      $select->where('resource_type = ?', $resource->getType());
    }

    $select
      ->where('resource_id = ?', $resource->getIdentity())
      ->order('like_id ASC');

    return $select;
  }

  public function getDisLikePaginator(Core_Model_Item_Abstract $resource)
  {
    $paginator = Zend_Paginator::factory($this->getDisLikeSelect($resource));
    $paginator->setItemCountPerPage(3);
    $paginator->count();
    $pages = $paginator->getPageRange();
    $paginator->setCurrentPageNumber($pages);
    return $paginator;
  }

  public function getDisLikeCount(Core_Model_Item_Abstract $resource)
  {
    if( isset($resource->like_count) )
    {
      return $resource->like_count;
    }

    $select = new Zend_Db_Select($this->getDisLikeTable()->getAdapter());
    $select
      ->from($this->getDisLikeTable()->info('name'), new Zend_Db_Expr('COUNT(1) as count'));

    if( !$this->_custom )
    {
      $select->where('resource_type = ?', $resource->getType());
    }

    $select->where('resource_id = ?', $resource->getIdentity());

    $data = $select->query()->fetchAll();
    return (int) $data[0]['count'];
  }

  public function getAllDisLikes(Core_Model_Item_Abstract $resource)
  {
    return $this->getDisLikeTable()->fetchAll($this->getDisLikeSelect($resource));
  }

  public function getAllDisLikesUsers(Core_Model_Item_Abstract $resource)
  {
    $table = $this->getDisLikeTable();
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), array('poster_type', 'poster_id'));

    if( !$this->_custom )
    {
      $select->where('resource_type = ?', $resource->getType());
    }

    $select->where('resource_id = ?', $resource->getIdentity());

    $users = array();
    foreach( $select->query()->fetchAll() as $data )
    {
      if( $data['poster_type'] == 'user' )
      {
        $users[] = $data['poster_id'];
      }
    }
    $users = array_values(array_unique($users));

    return Engine_Api::_()->getItemMulti('user', $users);
  }
}
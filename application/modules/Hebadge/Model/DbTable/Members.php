<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Hebadge
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 * @version    $Id: Members.php 02.04.12 09:12 michael $
 * @author     Michael
 */

/**
 * @category   Application_Extensions
 * @package    Hebadge
 * @copyright  Copyright Hire-Experts LLC
 * @license    http://www.hire-experts.com
 */



class Hebadge_Model_DbTable_Members extends Engine_Db_Table
{
  protected $_rowClass = 'Hebadge_Model_Member';
  protected $_members = array();

  public function getMembersByOwner(Core_Model_Item_Abstract $owner)
  {
    if (empty($this->_members[$owner->getGuid()])){

      $select = $this->select()
          ->where('object_type = ?', $owner->getType())
          ->where('object_id = ?', $owner->getIdentity());

      $members = $this->fetchAll($select);

      $this->_members[$owner->getGuid()] = $members;
    }
    return $this->_members[$owner->getGuid()];
  }

  public function getBestMembers()
  {
    $select = $this->select()
        ->from($this->info('name'), new Zend_Db_Expr('object_type, object_id, COUNT(badge_id) AS badge_count'))
        ->where('approved = 1')
        ->group(new Zend_Db_Expr('object_type, object_id'))
        ->order('badge_count DESC');

    return Zend_Paginator::factory($select);

  }

  public function getLastMembers($owner = null)
  {
    if (empty($owner)){

      $select = $this->select()
          ->from(array('m' => $this->info('name')), new Zend_Db_Expr('m.object_type, m.object_id, m.badge_id, m.creation_date'))
          ->join(array('b' => Engine_Api::_()->getDbTable('badges', 'hebadge')->info('name')), 'm.badge_id = b.badge_id AND b.enabled = 1 ', array())
          ->where('m.approved = 1')
          ->order('m.creation_date DESC');

    } else {

      $memberTable = Engine_Api::_()->getDbTable('membership', 'user');

      $select = $this->select()
          ->setIntegrityCheck(false)
          ->from(array('m' => $this->info('name')), new Zend_Db_Expr('m.object_type, m.object_id, m.badge_id, m.creation_date, IF(ISNULL(mu.user_id),0,1) AS is_friend'))
          ->join(array('b' => Engine_Api::_()->getDbTable('badges', 'hebadge')->info('name')), 'm.badge_id = b.badge_id AND b.enabled = 1 ', array())
          ->joinLeft(array('mu' => $memberTable->info('name')), '(m.object_type = "user" AND mu.resource_id = m.object_id) AND mu.user_id = ' . $owner->getIdentity() . ' AND mu.active = 1', array())
          ->where('m.approved = 1')
          ->order('is_friend DESC')
          ->order('m.creation_date DESC')
          ;
    }

    return Zend_Paginator::factory($select);

  }


}
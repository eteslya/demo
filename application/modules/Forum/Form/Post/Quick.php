<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Forum
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Quick.php 9802 2012-10-20 16:56:13Z pamela $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Forum
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Forum_Form_Post_Quick extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Quick Reply')
      ->setAttrib('name', 'forum_post_quick')
      ;
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $allowHtml = (bool) $settings->getSetting('forum_html', 0);
    $allowBbcode = (bool) $settings->getSetting('forum_bbcode', 0);

    $filter = new Engine_Filter_Html();
    $allowed_tags = explode(',', Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'forum', 'commentHtml'));

    if( $settings->getSetting('forum_html', 0) == '0' ) {
      $filter->setForbiddenTags();
      $filter->setAllowedTags($allowed_tags);
    }
    
    // Element: body
    if( $allowHtml || $allowBbcode ) {
      $this->addElement('TinyMce', 'body', array(
        'disableLoadDefaultDecorators' => true,
        'required' => true,
        'editorOptions' => array(
          'bbcode' => (bool) $allowBbcode,
          'html' => (bool) $allowHtml,
        ),
        'allowEmpty' => false,
        'decorators' => array('ViewHelper'),
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        )
      ));
    } else {    
    $this->addElement('textarea', 'body', array(
        'label' => 'Quick Reply',
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        ),
      ));
    }

    // Element: photo
    // Need this hack for some reason
    $this->addElement('File', 'photo', array(
      'attribs' => array('style' => 'display:none;')
    ));

    // Element: watch
    $this->addElement('Checkbox', 'watch', array(
      'label' => 'Send me notifications when other members reply to this topic.',
      'value' => '0',
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Reply',
      'type' => 'submit',
    ));
  }
}
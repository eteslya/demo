<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Channels
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: content.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
return array(
  array(
    'title' => 'Profile Channelss',
    'description' => 'Displays a member\'s channelss on their profile.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.profile-channelss',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Channelss',
      'titleCount' => true,
    ),
    'requirements' => array(
      'subject' => 'user',
    ),
  ),
  array(
    'title' => 'Popular Channelss',
    'description' => 'Displays a list of most viewed channelss.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.list-popular-channelss',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Popular Channelss',
    ),
    'requirements' => array(
      'no-subject',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'popularType',
          array(
            'label' => 'Popular Type',
            'multiOptions' => array(
              'view' => 'Views',
              'comment' => 'Comments',
            ),
            'value' => 'view',
          )
        ),
      )
    ),
  ),
  array(
    'title' => 'Recent Channelss',
    'description' => 'Displays a list of recently posted channelss.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.list-recent-channelss',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Recent Channelss',
    ),
    'requirements' => array(
      'no-subject',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Radio',
          'recentType',
          array(
            'label' => 'Recent Type',
            'multiOptions' => array(
              'creation' => 'Creation Date',
              'modified' => 'Modified Date',
            ),
            'value' => 'creation',
          )
        ),
      )
    ),
  ),
  
  array(
    'title' => 'Channels Browse Search',
    'description' => 'Displays a search form in the poll browse page.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.browse-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'Channels Browse Menu',
    'description' => 'Displays a menu in the poll browse page.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.browse-menu',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
    'title' => 'Channels Browse Quick Menu',
    'description' => 'Displays a small menu in the poll browse page.',
    'category' => 'Channelss',
    'type' => 'widget',
    'name' => 'channels.browse-menu-quick',
    'requirements' => array(
      'no-subject',
    ),
  ),
) ?>
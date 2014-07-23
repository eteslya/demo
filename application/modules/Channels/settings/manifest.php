<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Channels
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: manifest.php 10032 2013-03-28 23:21:05Z john $
 * @author     Jung
 */
return array(
  // Package -------------------------------------------------------------------
  'package' => array(
    'type' => 'module',
    'name' => 'channels',
    'version' => '4.5.0',
    'revision' => '$Revision: 10032 $',
    'path' => 'application/modules/Channels',
    'repository' => 'socialengine.com',
    'title' => 'Channelss',
    'description' => 'Channelss',
    'author' => 'Webligo Developments',
    'changeLog' => 'settings/changelog.php',
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'core',
        'minVersion' => '4.2.0',
      ),
    ),
    'actions' => array(
       'install',
       'upgrade',
       'refresh',
       'enable',
       'disable',
     ),
    'callback' => array(
      'path' => 'application/modules/Channels/settings/install.php',
      'class' => 'Channels_Installer',
    ),
    'directories' => array(
      'application/modules/Channels',
    ),
    'files' => array(
      'application/languages/en/channels.csv',
    ),
  ),
  // Hooks ---------------------------------------------------------------------
  'hooks' => array(
    array(
      'event' => 'onStatistics',
      'resource' => 'Channels_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Channels_Plugin_Core',
    ),
  ),
  // Items ---------------------------------------------------------------------
  'items' => array(
    'channels',
    'channels_album',
    'channels_photo'
  ),
  // Routes --------------------------------------------------------------------
  'routes' => array(
    'channels_extended' => array(
      'route' => 'channelss/:controller/:action/*',
      'defaults' => array(
        'module' => 'channels',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'controller' => '\D+',
        'action' => '\D+',
      ),
    ),
    'channels_general' => array(
      'route' => 'channelss/:action/*',
      'defaults' => array(
        'module' => 'channels',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|manage|create)',
      ),
    ),
    'channels_specific' => array(
      'route' => 'channelss/:action/:channels_id/*',
      'defaults' => array(
        'module' => 'channels',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'channels_id' => '\d+',
        'action' => '(delete|edit|close|success)',
      ),
    ),
    'channels_entry_view' => array(
      'route' => 'channelss/:user_id/:channels_id/:slug',
      'defaults' => array(
        'module' => 'channels',
        'controller' => 'index',
        'action' => 'view',
        'slug' => '',
      ),
      'reqs' => array(
        'user_id' => '\d+',
        'channels_id' => '\d+'
      )
    ),
  ),
);

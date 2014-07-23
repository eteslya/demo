<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Chat
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: changelog.php 10033 2013-03-28 23:53:58Z john $
 * @author     John
 */
return array(
  '4.5.0' => array(
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.3.0' => array(
    'externals/images/admin/add.png' => 'Added',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/admin-manage/index.tpl' => 'Improved styles',
  ),
  '4.2.5' => array(
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/admin-manage/index.tpl' => 'Add support links',
  ),
  '4.2.1' => array(
    'controllers/AjaxController.php' => 'Moving garbage collection to task scheduler',
    'Plugin/Task/Cleanup.php' => 'Added',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my-upgrade-4.2.0-4.2.1.sql' => 'Added',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.2.0' => array(
    'controllers/AdminSettingsController.php' => 'Fixed notice',
    'externals/scripts/core.js' => 'Added namespace for Wibiya compatibility',
    'Model/DbTable/Rooms.php' => 'Fixed warning',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my-upgrade-4.1.8p1-4.2.0.sql' => 'Added',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.1.8p1' => array(
    'controllers/IndexController.php' => 'Added room count rebuild',
    'externals/scripts/core.js' => 'Fixed errors caused by null user objects; Fixed issue with CDN/Flash cross-domain',
    'Model/DbTable/Rooms.php' => 'Added room count rebuild',
    'Plugin/Core.php' => 'Added cleanup hooks for deleted users',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.1.8' => array(
    'controllers/IndexController.php' => 'Added pages to the layout editor',
    'externals/.htaccess' => 'Updated with far-future expires headers for static resources',
    'externals/scripts/core.js' => 'Removed contentEditable support; Added static base URL for CDN support',
    'externals/styles/main.css' => 'Removed contentEditable support',
    'Model/DbTable/Users.php' => 'Fixed issue where friends would not appear online immediately',
    'Model/User.php' => 'Fixed issue where friends would not appear online immediately',
    'Plugin/Core.php' => 'Added static base URL for CDN support',
    'settings/changelog.php' => 'Incremented version',
    'settings/install.php' => 'Added pages to the layout editor',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/index/index.tpl' => 'Added static base URL for CDN support',
    'widgets/chat/index.tpl' => 'Added pages to the layout editor',
  ),
  '4.1.7' => array(
    'externals/scripts/core.js' => 'Removed contentEditable for mootools 1.3 compatibility',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.1.4' => array(
    'externals/scripts/core.js' => 'Fixed issue with text input in mobile browsers',
    'externals/styles/main.css' => 'Added svn:keywords Id',
    'externals/styles/mobile.css' => 'Added',
    'Model/RoomUser.php' => 'Fixes issue where IM and chat would not work if the mysql connection timezone could not be changed',
    'Plugin/Core.php' => 'Fixed issue with text input in mobile browsers',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/index/index.tpl' => 'Fixed issue with text input in mobile browsers',
  ),
  '4.1.3' => array(
    'externals/scripts/core.js' => 'Fixed issue with low delays causing excess server load',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.1.2' => array(
    'controllers/AjaxController.php' => 'Fixed error on missing users',
    'controllers/IndexController.php' => 'Widget compatibility',
    'externals/scripts/core.js' => 'Fixed disconnection issue with IE8; fixed issue with system messages',
    'lite.php' => 'Added cache-control headers',
    'settings/changelog.php' => 'Incremented version',
    'settings/content.php' => 'Added',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/index/index.tpl' => 'Widget compatibility',
    'widgets/chat/Controller.php' => 'Added',
    'widgets/chat/index.tpl' => 'Added',
  ),
  '4.1.1' => array(
    'externals/.htaccess' => 'Added keywords; removed deprecated code',
    'externals/styles/main.css' => 'IE formatting fix',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
  ),
  '4.1.0' => array(
    '/application/languages/en/chat.csv' => 'Added phrases',
    'controllers/AdminSettingsController.php' => 'Removed global on/off settings',
    'controllers/AjaxController.php' => 'Rooms are ordered by title',
    'controllers/IndexController.php' => 'Fixes issue with level settings disabling chat',
    'externals/ding.mp3' => 'Added for IM sound, compliments http://soundbible.com/1127-Computer-Error.html',
    'externals/scripts/core.js' => 'Added IM sound; AJAX requests are sent through index.php now to address baseUrl issues with profile address; added translations for site-wide IM chat',
    'Form/Admin/Settings/Global.php' => 'Removed global on/off settings',
    'Model/DbTable/RoomUsers.php' => 'Fixes issue where IM and chat would not work if the mysql connection timezone could not be changed',
    'Model/DbTable/Users.php' => 'Fixes issue where IM and chat would not work if the mysql connection timezone could not be changed',
    'Model/Message.php' => 'Fixes issue with system messages when using mysql adapter',
    'Plugin/Core.php' => 'Added soundmanager for IM sound; fixes issue with level settings disabling chat',
    'settings/changelog.php' => 'Incremented version',
    'settings/manifest.php' => 'Incremented version',
    'settings/my-upgrade-4.0.4-4.1.0.sql' => 'Added',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/index/index.tpl' => 'Fixes issue with level settings disabling chat, IE not seeing list of rooms',
  ),
  '4.0.4' => array(
    'controllers/AdminManageController.php' => 'Added pagination',
    'externals/scripts/core.js' => 'Added missing translation',
    'Plugin/Core.php' => 'Added missing translation',
    'settings/changelog.php' => 'Added',
    'settings/manifest.php' => 'Incremented version',
    'settings/my.sql' => 'Incremented version',
    'views/scripts/admin-manage/index.tpl' => 'Added pagination',
  ),
  '4.0.3' => array(
    'controllers/AdminSettingsController.php' => 'Fixed warning message',
    'controllers/IndexController.php' => 'Removed deprecated code',
    'Bootstrap.php' => 'Removed deprecated code',
    'externals/scripts/core.js' => 'Improved language and localization support',
    'externals/styles/mains.css' => 'Improved RTL support',
    'Plugin/Core.php' => 'Improved language support',
    'views/scripts/index/index.tpl' => 'Improved language support',
    'views/scripts/index/language.tpl' => 'Removed',
    'settings/manifest.php' => 'Incremented version',
    'settings/my-upgrade-4.0.2-4.0.3.sql' => 'Added',
    'settings/my.sql' => 'Incremented version',
    '/application/languages/en/chat.csv' => 'Added missing phrases',
  ),
  '4.0.2' => array(
    'controllers/AdminSettingsController.php' => 'Various level settings fixes and enhancements',
    'Form/Admin/Settings/Level.php' => 'Various level settings fixes and enhancements',
    'settings/manifest.php' => 'Incremented version',
    'settings/my-upgrade-4.0.1-4.0.2.sql' => 'Added',
    'settings/my.sql' => 'Various level settings fixes and enhancements',
  ),
  '4.0.1' => array(
    'controllers/AdminSettingsController.php' => 'Fixed typo',
    'settings/manifest.php' => 'Incremented version',
  ),
) ?>
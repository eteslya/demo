INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('honeypot', 'Honeypot', '', '4.6.0', 1, 'extra') ;

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_honeypot', 'honeypot', 'Honeypot', '', '{"route":"admin_default","module":"honeypot","controller":"settings"}', 'core_admin_main_plugins', '', 999);

INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES
('honeypot.email', SUBSTRING(MD5(RAND()) FROM 1 FOR 6));
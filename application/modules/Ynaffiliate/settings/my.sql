
-- Database: `products_demo_affiliate401`
--
INSERT IGNORE INTO `engine4_core_modules` (`name`, `title`, `description`, `version`, `enabled`, `type`) VALUES  ('ynaffiliate', 'Affiliate System', 'Affiliate System', '4.01', 1, 'extra') ;
-- --------------------------------------------------------

INSERT INTO `engine4_core_menus` (`name`, `type`, `title`, `order`) VALUES
('ynaffiliate_main', 'standard', 'Affiliate Main Navigation Menu', 999);
-- ------

-- Dumping data for table `engine4_core_menuitems`
--

INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES
('ynaffiliate_menu_rule', 'ynaffiliate', 'Commission Rules', '', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "commission-rule"}', 'ynaffiliate_main', '', 1, 0, 1),
('ynaffiliate_menu_faqs', 'ynaffiliate', 'FAQs', 'Ynaffiliate_Plugin_Menus::canView', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "faqs"}', 'ynaffiliate_main', '', 1, 0, 6),
('ynaffiliate_menu_help', 'ynaffiliate', 'Help', 'Ynaffiliate_Plugin_Menus::canView', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "help"}', 'ynaffiliate_main', '', 1, 0, 5),
('ynaffiliate_menu_account', 'ynaffiliate', 'My Account', 'Ynaffiliate_Plugin_Menus::canView', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "my-account"}', 'ynaffiliate_main', '', 1, 0, 3),
('ynaffiliate_menu_manage', 'ynaffiliate', 'My Clients', 'Ynaffiliate_Plugin_Menus::canView', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "my-affiliate"}', 'ynaffiliate_main', '', 1, 0, 2),
('ynaffiliate_menu_sources', 'ynaffiliate', 'Suggest Links', 'Ynaffiliate_Plugin_Menus::canView', '{"module":"ynaffiliate","route":"ynaffiliate_extended", "controller": "sources"}', 'ynaffiliate_main', '', 1, 0, 4),
('core_main_ynaffiliate', 'ynaffiliate', 'Affiliate', '', '{"module":"ynaffiliate","route":"ynaffiliate_general"}', 'core_main', '', 1, 0, 4),
('ynaffiliate_menu_signup', 'ynaffiliate', 'Become Affiliate', 'Ynaffiliate_Plugin_Menus::canSignup', '{"module":"ynaffiliate","route":"ynaffiliate_signup", "action": "index"}', 'ynaffiliate_main', '', 1, 0, 1),
('ynaffiliate_admin_main_client', 'ynaffiliate', 'Affiliate''s Client', '', '{"route":"admin_default","module":"ynaffiliate","controller":"client"}', 'ynaffiliate_admin_main', '', 1, 0, 5),
('ynaffiliate_admin_main_rule', 'ynaffiliate', 'Commission Rules', '', '{"route":"admin_default","module":"ynaffiliate","controller":"commission-rule"}', 'ynaffiliate_admin_main', '', 1, 0, 4),
('ynaffiliate_admin_main_commission', 'ynaffiliate', 'Manage Commission', '', '{"route":"admin_default","module":"ynaffiliate","controller":"commission"}', 'ynaffiliate_admin_main', '', 1, 0, 6),
('ynaffiliate_admin_main_exchangerates', 'ynaffiliate', 'Exchange Rates', '', '{"route":"admin_default","module":"ynaffiliate","controller":"exchangerates"}', 'ynaffiliate_admin_main', NULL, 1, 0, 8),
('ynaffiliate_admin_main_faqs', 'ynaffiliate', 'FAQs', '', '{"route":"admin_default","module":"ynaffiliate","controller":"faqs"}', 'ynaffiliate_admin_main', '', 1, 0, 99),
('ynaffiliate_admin_main_helps', 'ynaffiliate', 'Helps', '', '{"route":"admin_default","module":"ynaffiliate","controller":"helps"}', 'ynaffiliate_admin_main', '', 1, 0, 98),
('ynaffiliate_admin_main_level', 'ynaffiliate', 'Member Level Settings', '', '{"route":"admin_default","module":"ynaffiliate","controller":"level"}', 'ynaffiliate_admin_main', '', 0, 0, 3),
('ynaffiliate_admin_main_manage_affiliate', 'ynaffiliate', 'Manage Affiliate', '', '{"route":"admin_default","module":"ynaffiliate","controller":"manage"}', 'ynaffiliate_admin_main', '', 1, 0, 1),
('ynaffiliate_admin_main_request', 'ynaffiliate', 'Manage Request', '', '{"route":"admin_default","module":"ynaffiliate","controller":"request" }', 'ynaffiliate_admin_main', '', 1, 0, 7),
('ynaffiliate_admin_main_settings', 'ynaffiliate', 'Global Settings', '', '{"route":"admin_default","module":"ynaffiliate","controller":"settings"}', 'ynaffiliate_admin_main', '', 1, 0, 2),
('core_admin_main_plugins_ynaffiliate', 'ynaffiliate', 'Affiliates', '', '{"route":"admin_default","module":"ynaffiliate","controller":"settings"}', 'core_admin_main_plugins', '', 1, 0, 999),
('ynaffiliate_admin_main_statistics', 'ynaffiliate', 'Statistics', '', '{"route":"admin_default","module":"ynaffiliate","controller":"statistic"}', 'ynaffiliate_admin_main', '', 1, 0, 8),
('ynaffiliate_admin_main_terms', 'ynaffiliate', 'Terms', '', '{"route":"admin_default","module":"ynaffiliate","controller":"terms"}', 'ynaffiliate_admin_main', '', 1, 0, 9);

--
-- Table structure for table `engine4_ynaffiliate_accounts`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_accounts` (
  `account_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `approved` tinyint(1) unsigned NOT NULL default '0',
  `contact_name` varchar(128) NOT NULL default '0',
  `contact_address` varchar(128) NOT NULL default '',
  `contact_phone` varchar(128) NOT NULL default '',
  `contact_email` varchar(128) NOT NULL default '',
  `paypal_displayname` varchar(128) NOT NULL default '',
  `paypal_email` varchar(128) NOT NULL default '',
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`account_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_assoc`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_assoc` (
  `assoc_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL,
  `new_user_id` int(11) unsigned NOT NULL,
  `link_id` int(11) unsigned NOT NULL default '0',
  `approved` tinyint(1) unsigned NOT NULL default '1',
  `invite_id` int(11) unsigned NOT NULL default '0',
  `invite_code` varchar(50) NOT NULL default '',
  `invited_date` datetime default NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`assoc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_commissions`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_commissions` (
  `commission_id` bigint(20) unsigned NOT NULL auto_increment,
  `rule_id` int(11) unsigned NOT NULL default '0',
  `rulemap_id` int(11) unsigned NOT NULL default '0',
  `rulemapdetail_id` int(11) unsigned NOT NULL default '0',
  `module` varchar(50) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `from_user_id` int(11) unsigned NOT NULL,
  `purchase_currency` char(3) NOT NULL default 'USD',
  `purchase_total_amount` bigint(20) unsigned NOT NULL,
  `commission_amount` decimal(16,4) unsigned NOT NULL default '0.0000',
  `commission_rate` double unsigned NOT NULL default '0',
  `commission_type` int(11) unsigned NOT NULL default '0',
  `commission_points` double unsigned NOT NULL default '0',
  `transaction_id` varchar(128) default NULL,
  `transaction_url` tinytext,
  `approve_stat` enum('waiting','approved','denied') NOT NULL default 'waiting',
  `creation_date` datetime NOT NULL,
  `approved_date` datetime default NULL,
  PRIMARY KEY  (`commission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_faqs`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_faqs` (
  `faq_id` int(11) unsigned NOT NULL auto_increment,
  `status` enum('show','hide') NOT NULL default 'hide',
  `ordering` int(11) unsigned NOT NULL default '0',
  `owner_id` int(11) unsigned NOT NULL default '0',
  `category_id` int(11) unsigned NOT NULL default '0',
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`faq_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_helppages`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_helppages` (
  `helppage_id` int(11) unsigned NOT NULL auto_increment,
  `status` enum('show','hide') NOT NULL,
  `ordering` smallint(5) unsigned NOT NULL default '999',
  `category_id` int(11) unsigned NOT NULL default '0',
  `owner_id` int(11) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`helppage_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_links`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_links` (
  `link_id` int(11) unsigned NOT NULL auto_increment,
  `link_title` varchar(128) NOT NULL default '',
  `user_id` int(11) unsigned NOT NULL default '0',
  `is_dynamic` tinyint(1) NOT NULL default '0',
  `target_url` mediumtext NOT NULL,
  `affiliate_url` mediumtext NOT NULL,
  `click_count` int(11) unsigned NOT NULL default '0',
  `success_count` int(11) unsigned NOT NULL default '0',
  `last_user_id` int(11) unsigned NOT NULL default '0',
  `last_registered` datetime default NULL,
  `last_click` datetime NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY  (`link_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_requests`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_requests` (
  `request_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(11) unsigned NOT NULL default '0',
  `request_points` double unsigned NOT NULL default '0',
  `request_amount` decimal(16,2) unsigned NOT NULL default '0.00',
  `request_status` enum('completed','denied','pending','waiting') NOT NULL default 'waiting',
  `currency` char(3) NOT NULL,
  `request_message` text,
  `response_message` text,
  `request_date` datetime default NULL,
  `response_date` datetime default NULL,
  PRIMARY KEY  (`request_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_rulemapdetails`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_rulemapdetails` (
  `rulemapdetail_id` int(11) unsigned NOT NULL auto_increment,
  `rule_map` int(11) unsigned NOT NULL,
  `option_id` int(11) unsigned NOT NULL default '0' COMMENT '0: first purchase, 1: future purchase',
  `rule_type` int(11) unsigned NOT NULL default '0' COMMENT '0: percentage, 1: fix price',
  `rule_value` double unsigned NOT NULL default '0' COMMENT 'ex: 0.2 = 20%, 3',
  `rule_unit` int(10) unsigned NOT NULL default '0',
  `rule_currency` char(3) NOT NULL default 'USD',
  PRIMARY KEY  (`rulemapdetail_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_rulemaps`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_rulemaps` (
  `rulemap_id` int(11) unsigned NOT NULL auto_increment,
  `rule_id` int(11) unsigned NOT NULL,
  `profiletype_id` int(11) unsigned NOT NULL,
  PRIMARY KEY  (`rulemap_id`),
  UNIQUE KEY `rule_id_profiletype_id` (`rule_id`,`profiletype_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `engine4_ynaffiliate_rulemaps`
--

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_rules`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_rules` (
  `rule_id` int(11) unsigned NOT NULL auto_increment,
  `enabled` tinyint(1) unsigned NOT NULL default '1',
  `module` varchar(128) NOT NULL,
  `rule_name` varchar(128) NOT NULL,
  `rule_title` varchar(128) NOT NULL,
  PRIMARY KEY  (`rule_id`),
  UNIQUE KEY `rule_name` (`rule_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `engine4_ynaffiliate_rules`
--

INSERT INTO `engine4_ynaffiliate_rules` (`rule_id`, `enabled`, `module`, `rule_name`, `rule_title`) VALUES
(1, 1, 'payment', 'subscription', 'Subscription Fee'),
(2, 1, 'groupbuy', 'buy_deal', 'Buy a deal'),
(3, 1, 'groupbuy', 'publish_deal', 'Publish a deal'),
(4, 1, 'socialstore', 'publish_store', 'Publish a store'),
(5, 1, 'socialstore', 'buy_product', 'Buy products'),
(6, 1, 'socialstore', 'publish_product', 'Publish a product'),
(7, 1, 'ynauction', 'publish_ynauction', 'Publish an auction item'),
(8, 1, 'ynauction', 'buy_ynauction', 'Buy an auction item'),
(9, 1, 'pennyauction', 'publish_pennyauction', 'Publish a penny auction item'),
(10, 1, 'pennyauction', 'buy_pennyauction', 'Buy a penny auction item'),
(11, 1, 'pennyauction', 'buy_bid_pennyauction', 'Bid a penny auction item'),
(12, 1, 'mp3music', 'buy_mp3music', 'Buy mp3 song');

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_statics`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_statics` (
  `static_id` int(11) unsigned NOT NULL auto_increment,
  `static_name` varchar(128) NOT NULL,
  `static_title` tinytext NOT NULL,
  `static_content` longtext NOT NULL,
  PRIMARY KEY  (`static_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `engine4_ynaffiliate_statics`
--

INSERT INTO `engine4_ynaffiliate_statics` (`static_id`, `static_name`, `static_title`, `static_content`) VALUES
(1, 'terms', 'Terms of Service', '[Content Here]');

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynaffiliate_suggests`
--

CREATE TABLE IF NOT EXISTS `engine4_ynaffiliate_suggests` (
  `suggest_id` int(11) unsigned NOT NULL auto_increment,
  `module` varchar(128) NOT NULL,
  `priority` int(11) NOT NULL default '999',
  `enabled` tinyint(1) unsigned NOT NULL default '1',
  `suggest_title` varchar(256) NOT NULL,
  `plugin` varchar(128) default '',
  `href` text NOT NULL,
  PRIMARY KEY  (`suggest_id`),
  KEY `module` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `engine4_ynaffiliate_suggests`
--

INSERT INTO `engine4_ynaffiliate_suggests` (`suggest_id`, `module`, `priority`, `enabled`, `suggest_title`, `plugin`, `href`) VALUES
(1, 'core', 999, 1, 'Home Page', 'Ynaffiliate_Plugin_Suggest::memberHomePage', ''),
(2, 'home', 999, 1, 'Profile Page', 'Ynaffiliate_Plugin_Suggest::memberProfilePage', ''),
(3, 'groupbuy', 999, 1, 'Group Buy Home Page', '', ''),
(4, 'socialstore', 999, 1, 'Store Home Page', '', ''),
(5, 'ynauction', 999, 1, 'Auction Home Page', '', ''),
(6, 'pennyauction', 999, 1, 'Penny Home Page', '', ''),
(7, 'mp3music', 999, 1, 'Mp3 Music Home Page', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynpayment_currencies`
--

CREATE TABLE IF NOT EXISTS `engine4_ynpayment_currencies` (
  `code` varchar(10) NOT NULL,
  `name` varchar(64) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `status` enum('Enable','Disable') NOT NULL default 'Enable',
  `position` enum('Standard','Left','Right') NOT NULL default 'Standard',
  `precision` tinyint(4) unsigned NOT NULL default '2',
  `script` tinyint(64) default NULL,
  `format` varchar(64) default NULL,
  `display` enum('No Symbol','Use Symbol','Use Shortname','Use Name') NOT NULL default 'Use Symbol',
  PRIMARY KEY  (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `engine4_ynpayment_currencies`
--

INSERT INTO `engine4_ynpayment_currencies` (`code`, `name`, `symbol`, `status`, `position`, `precision`, `script`, `format`, `display`) VALUES
('AUD', 'Australian Dollar', 'A$', 'Enable', 'Standard', 2, NULL, NULL, 'No Symbol'),
('BRL', 'Brazilian Real	', 'BRL', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('CAD', 'Canadian Dollar', 'C$', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('CHF', 'Swiss Franc', 'CHF', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('CZK', 'Czech Koruna', 'CZK', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('DKK', 'Danish Krone', 'DKK', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('EUR', 'Euro', '&euro;', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('GBP', 'British Pound', '&pound;', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('HKD', 'Hong Kong Dollar', 'H$', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('HUF', 'Hungarian Forint', 'HUF', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('ILS', 'Israeli New Shekel', 'ILS', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('JPY', 'Japanese Yen', '&yen;', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('MXN', 'Mexican Peso', 'MXN', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('MYR', 'Malaysian Ringgit', 'MYR', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('NOK', 'Norwegian Krone', 'NOK', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('NZD', 'New Zealand Dollar', '$', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('PHP', 'Philippine Peso', 'PHP', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('PLN', 'Polish Zloty', 'PLN', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('SEK', 'Swedish Krona', 'SEK', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('SGD', 'Singapore Dollar', '$', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('THB', 'Thai Baht', 'THB', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('TRY', 'Turkish Lira', 'TRY', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('TWD', 'New Taiwan Dollar', 'TWD', 'Enable', 'Standard', 2, NULL, NULL, 'Use Symbol'),
('USD', 'U.S. Dollar', '$', 'Enable', 'Standard', 1, NULL, NULL, 'Use Symbol');

-- --------------------------------------------------------

--
-- Table structure for table `engine4_ynpayment_exchangerates`
--

CREATE TABLE IF NOT EXISTS `engine4_ynpayment_exchangerates` (
  `exchangerate_id` char(3) NOT NULL,
  `enabled` tinyint(1) NOT NULL default '1',
  `base_currency` char(3) NOT NULL,
  `exchange_rate` double NOT NULL default '1',
  `modified_date` datetime NOT NULL,
  PRIMARY KEY  (`exchangerate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `engine4_ynpayment_exchangerates`
--

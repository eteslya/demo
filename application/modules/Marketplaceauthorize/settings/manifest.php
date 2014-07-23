<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'marketplaceauthorize',
    'version' => '4.3.0',
    'path' => 'application/modules/Marketplaceauthorize',
    'title' => 'Marketplace Authorize.net',
    'description' => '',
    'author' => 'SocialEngineMarket',
    'callback' => 
    array (
      'path' => 'application/modules/Marketplaceauthorize/settings/install.php',
      'class' => 'Marketplaceauthorize_Installer',
    ),
    'dependencies' => array(
      array(
        'type' => 'module',
        'name' => 'marketplace',
        'minVersion' => '4.3.0',
      ),
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Marketplaceauthorize',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/marketplaceauthorize.csv',
    ),
  ),
); ?>
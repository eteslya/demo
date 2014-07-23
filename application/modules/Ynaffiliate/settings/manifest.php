<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'ynaffiliate',
    'version' => '4.01',
    'path' => 'application/modules/Ynaffiliate',
    'title' => 'Affiliate System',
    'description' => 'Affiliate System',
    'author' => 'YouNet Company',
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Module',
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
      0 => 'application/modules/Ynaffiliate',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/ynaffiliate.csv',
    ),
    'dependencies' => 
    array (
      0 => 
      array (
        'type' => 'module',
        'name' => 'younet-core',
        'minVersion' => '4.02p3',
      ),
    ),
  ),
  'hooks' => 
  array (
    0 => 
    array (
      'event' => 'onUserCreateAfter',
      'resource' => 'Ynaffiliate_Plugin_Core',
    ),
    1 => 
    array (
      'event' => 'onPaymentSubscriptionUpdateAfter',
      'resource' => 'Ynaffiliate_Plugin_Core',
    ),
    2 => 
    array (
      'event' => 'onPaymentAfter',
      'resource' => 'Ynaffiliate_Plugin_Core',
    ),
    3 => 
    array (
      'event' => 'onPaymentTransactionCreateAfter',
      'resource' => 'Ynaffiliate_Plugin_Core',
    ),
  ),
  'items' => 
  array (
    0 => 'ynaffiliate_accounts',
  ),
  'routes' => 
  array (
    'ynaffiliate_general' => 
    array (
      'route' => 'affiliate/:action/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'index',
        'action' => 'index',
      ),
    ),
    'ynaffiliate_extended' => 
    array (
      'route' => 'affiliate/:controller/:action/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'index',
        'action' => 'index',
      ),
    ),
    'ynaffiliate_click' => 
    array (
      'route' => 'af/:user_id/:href/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'index',
        'action' => 'click',
        'href' => '',
      ),
      'reqs' => 
      array (
        'user_id' => '(\\d+)',
      ),
    ),
    'ynaffiliate_memberhome' => 
    array (
      'route' => 'affiliate',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'index',
        'action' => 'index',
      ),
    ),
    'ynaffiliate_signup' => 
    array (
      'route' => 'affiliate/signup/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'signup',
        'action' => 'index',
      ),
    ),
    'ynaffiliate_payment_threshold' => 
    array (
      'route' => 'affiliate/my-account/threshold/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'my-account',
        'action' => 'threshold',
      ),
    ),
    'ynaffiliate_account' => 
    array (
      'route' => 'affiliate/my-account/:action/*',
      'defaults' => 
      array (
        'module' => 'ynaffiliate',
        'controller' => 'my-account',
        'action' => 'index',
      ),
    ),
  ),
) ; ?>
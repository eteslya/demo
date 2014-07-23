<?php
/**
 * 
 *
 * @category   Application_Extensions
 * @package    Marketplace
 * @copyright  Copyright 2010 
 * * 
 * @version    $Id: content.php 7244 2010-09-01 01:49:53Z john $
 * @author     John
 */
return array(
  array(
    'title' => 'Profile Marketplace',
    'description' => 'Displays a member\'s marketplace items on their profile.',
    'category' => 'Marketplace',
    'type' => 'widget',
    'name' => 'marketplace.profile-marketplaces',
    'defaultParams' => array(
      'title' => 'Marketplace',
      'titleCount' => true,
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Text',
          'itemCountPerPage',
          array(
            'label' => 'Count (number of items per category to show)'
          )
        ),
      )
    ),
  ),
  array(
    'title' => 'New Listings',
    'description' => 'Displays a member\'s new listings.',
    'category' => 'Marketplace',
    'type' => 'widget',
    'name' => 'marketplace.home-last',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'New Listings',
      'titleCount' => true,
    ),
    'adminForm' => 'Marketplace_Form_Admin_Widget_Cats',
  ),
  array(
    'title' => 'Top Listings',
    'description' => 'Displays a member\'s top listings.',
    'category' => 'Marketplace',
    'type' => 'widget',
    'name' => 'marketplace.home-top',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Top Listings',
      'titleCount' => true,
    ),
    'adminForm' => 'Marketplace_Form_Admin_Widget_Cats',
  ),
  array(
    'title' => 'Featured Listings',
    'description' => 'Displays a member\'s featured listings.',
    'category' => 'Marketplace',
    'type' => 'widget',
    'name' => 'marketplace.home-featured',
    'isPaginated' => true,
    'defaultParams' => array(
      'title' => 'Featured Listings',
      'titleCount' => true,
    ),
    'adminForm' => 'Marketplace_Form_Admin_Widget_Cats',
  ),
) ?>
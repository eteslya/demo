<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: default.tpl 10017 2013-03-27 01:27:56Z jung $
 * @author     John
 */
?>
<?php echo $this->doctype()->__toString() ?>
<?php $locale = $this->locale()->getLocale()->__toString(); $orientation = ( $this->layout()->orientation == 'right-to-left' ? 'rtl' : 'ltr' ); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $locale ?>" lang="<?php echo $locale ?>" dir="<?php echo $orientation ?>">
<head>




  <base href="<?php echo rtrim((constant('_ENGINE_SSL') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $this->baseUrl(), '/'). '/' ?>" />
  <!-- core -->
  
  <?php // ALLOW HOOKS INTO META ?>
  <?php echo $this->hooks('onRenderLayoutDefault', $this) ?>


  <?php // TITLE/META ?>
  <?php
    $counter = (int) $this->layout()->counter;
    $staticBaseUrl = $this->layout()->staticBaseUrl;
    $headIncludes = $this->layout()->headIncludes;
    
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->headTitle()
      ->setSeparator(' - ');
    $pageTitleKey = 'pagetitle-' . $request->getModuleName() . '-' . $request->getActionName()
        . '-' . $request->getControllerName();
    $pageTitle = $this->translate($pageTitleKey);
    if( $pageTitle && $pageTitle != $pageTitleKey ) {
      $this
        ->headTitle($pageTitle, Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
    }
    $this
      ->headTitle($this->translate($this->layout()->siteinfo['title']), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND)
      ;
    $this->headMeta()
      ->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
      ->appendHttpEquiv('Content-Language', $this->locale()->getLocale()->__toString());
    
    // Make description and keywords
    $description = '';
    $keywords = '';
    
    $description .= ' ' .$this->layout()->siteinfo['description'];
    $keywords = $this->layout()->siteinfo['keywords'];

    if( $this->subject() && $this->subject()->getIdentity() ) {
      $this->headTitle($this->subject()->getTitle());
      
      $description .= ' ' .$this->subject()->getDescription();
      if (!empty($keywords)) $keywords .= ',';
      $keywords .= $this->subject()->getKeywords(',');
    }
    
    $this->headMeta()->appendName('description', trim($description));
    $this->headMeta()->appendName('keywords', trim($keywords));

    // Get body identity
    if( isset($this->layout()->siteinfo['identity']) ) {
      $identity = $this->layout()->siteinfo['identity'];
    } else {
      $identity = $request->getModuleName() . '-' .
          $request->getControllerName() . '-' .
          $request->getActionName();
    }
  ?>
  <?php echo $this->headTitle()->toString()."\n" ?>
  <?php echo $this->headMeta()->toString()."\n" ?>


  <?php // LINK/STYLES ?>
  <?php
    $this->headLink(array(
      'rel' => 'favicon',
      'href' => ( isset($this->layout()->favicon)
        ? $staticBaseUrl . $this->layout()->favicon
        : '/favicon.ico' ),
      'type' => 'image/x-icon'),
      'PREPEND');
    $themes = array();
    if( !empty($this->layout()->themes) ) {
      $themes = $this->layout()->themes;
    } else {
      $themes = array('default');
    }
    foreach( $themes as $theme ) {
	//custom Drop-down menu  //et
	//$this->headLink()          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/menu_bar/Code/css/menu/styles/lgray.css');
	$this->headLink()
          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/menu_bar/Code/css/menu/styles/lgray.css');
	$this->headLink()
          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/menu_bar/Code/css/menu/effects/slide.css');  

	  //custom Drop-down menu  //ad moved here
	 /*$this->headLink()
          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/menu_bar/Code/css/menu/core.css'); */
	
	//custom login css  //et
	  $this->headLink()
          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/login/css/custom.css');
		  
		  
      if( APPLICATION_ENV != 'development' ) {
        $this->headLink()
          ->prependStylesheet($staticBaseUrl . 'application/css.php?request=application/themes/' . $theme . '/theme.css');
      } else {
        $this->headLink()
          ->prependStylesheet(rtrim($this->baseUrl(), '/') . '/application/css.php?request=application/themes/' . $theme . '/theme.css');
      }
	  
	  //custom Drop-down menu  //et ad commented
	  //$this->headLink()
          //->prependStylesheet(rtrim($this->baseUrl(), '/') . '/custom/menu_bar/Code/css/menu/core.css');
	  
	  
    }
    // Process
    foreach( $this->headLink()->getContainer() as $dat ) {
      if( !empty($dat->href) ) {
        if( false === strpos($dat->href, '?') ) {
          $dat->href .= '?c=' . $counter;
        } else {
          $dat->href .= '&c=' . $counter;
        }
      }
    }
  ?>
  <?php echo $this->headLink()->toString()."\n" ?>
  <?php echo $this->headStyle()->toString()."\n" ?>

  <?php // TRANSLATE ?>
  <?php $this->headScript()->prependScript($this->headTranslate()->toString()) ?>

  <?php // SCRIPTS ?>
  <script type="text/javascript">if (window.location.hash == '#_=_')window.location.hash = '';</script>
  <script type="text/javascript">
    <?php echo $this->headScript()->captureStart(Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) ?>

    Date.setServerOffset('<?php echo date('D, j M Y G:i:s O', time()) ?>');
    
    en4.orientation = '<?php echo $orientation ?>';
    en4.core.environment = '<?php echo APPLICATION_ENV ?>';
    en4.core.language.setLocale('<?php echo $this->locale()->getLocale()->__toString() ?>');
    en4.core.setBaseUrl('<?php echo $this->url(array(), 'default', true) ?>');
    en4.core.staticBaseUrl = '<?php echo $this->escape($staticBaseUrl) ?>';
    en4.core.loader = new Element('img', {src: en4.core.staticBaseUrl + 'application/modules/Core/externals/images/loading.gif'});
    
    <?php if( $this->subject() ): ?>
      en4.core.subject = {
        type : '<?php echo $this->subject()->getType(); ?>',
        id : <?php echo $this->subject()->getIdentity(); ?>,
        guid : '<?php echo $this->subject()->getGuid(); ?>'
      };
    <?php endif; ?>
    <?php if( $this->viewer()->getIdentity() ): ?>
      en4.user.viewer = {
        type : '<?php echo $this->viewer()->getType(); ?>',
        id : <?php echo $this->viewer()->getIdentity(); ?>,
        guid : '<?php echo $this->viewer()->getGuid(); ?>'
      };
    <?php endif; ?>
    if( <?php echo ( Engine_Api::_()->getDbtable('settings', 'core')->core_dloader_enabled ? 'true' : 'false' ) ?> ) {
      en4.core.runonce.add(function() {
        en4.core.dloader.attach();
      });
    }
    
    <?php echo $this->headScript()->captureEnd(Zend_View_Helper_Placeholder_Container_Abstract::PREPEND) ?>
  </script>
  


  <?php
    $this->headScript()

	  
      ->prependFile($staticBaseUrl . 'externals/smoothbox/smoothbox4.js')
      ->prependFile($staticBaseUrl . 'application/modules/User/externals/scripts/core.js')
      ->prependFile($staticBaseUrl . 'application/modules/Core/externals/scripts/core.js')
      ->prependFile($staticBaseUrl . 'externals/chootools/chootools.js')
      ->prependFile($staticBaseUrl . 'externals/mootools/mootools-more-1.4.0.1-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js')
      ->prependFile($staticBaseUrl . 'externals/mootools/mootools-core-1.4.5-full-compat-' . (APPLICATION_ENV == 'development' ? 'nc' : 'yc') . '.js');
	  
	  /*
	 ->prependFile($staticBaseUrl . 'custom/menu_bar/Code/js/menu.min.js')
	  ->prependFile($staticBaseUrl . 'custom/menu_bar/Code/js/jquery-1.7.1.min.js');
	  
	  ->prependFile($staticBaseUrl . 'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js');
	  
	  */
    // Process
    foreach( $this->headScript()->getContainer() as $dat ) {
      if( !empty($dat->attributes['src']) ) {
        if( false === strpos($dat->attributes['src'], '?') ) {
          $dat->attributes['src'] .= '?c=' . $counter;
        } else {
          $dat->attributes['src'] .= '&c=' . $counter;
        }
      }
    }
  ?>
  <?php echo $this->headScript()->toString()."\n" ?>

  
  
  <?php echo $headIncludes ?>
  
  <script>
  function fRedirect(arg)
{
	document.forms[0].action = arg;
	document.forms[0].target = "_parent";
	document.forms[0].submit();
}
</script>
  <script>
var j$ = jQuery.noConflict();
</script>
   <!--script type="text/javascript" src="/bv/https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js?c=96"></script-->
<!--script type="text/javascript" src="/bv/custom/menu_bar/Code/js/jquery-1.7.1.min.js?c=96"></script-->
<script type="text/javascript" src="/bv/custom/menu_bar/Code/js/menu.min.js?c=96"></script>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41832077-1', 'bio-views.com');
  ga('send', 'pageview');

</script>

</head>
<body id="global_page_<?php echo $identity ?>">
  <script type="javascript/text">
    if(DetectIpad()){
      $$('a.album_main_upload').setStyle('display', 'none');
      $$('a.album_quick_upload').setStyle('display', 'none');
      $$('a.icon_photos_new').setStyle('display', 'none');
    }
  </script>  
  
  <div id="global_header">
    <?php echo $this->content('header') ?>
  </div>
  <div id='global_wrapper'>
    <div id='global_content'>
	<!-- ??? -->
	<?php 
		
		if($pageTitle == "pagetitle-ynaffiliate-index-signup") //affiliate screen
		{
			$myApi =  Engine_Api::_()->getApi('core', 'ynaffiliate'); //->isTestStore(3);

			$x = $myApi->isTestStore(3);
			
			if ($x == 0) //user did not purchase package
			{
			
				echo '<form action=""></form>';
			
				echo '<script>fRedirect("/bv/marketplaces/390/16");</script>';
			}
			else
			{
				//echo '<form action=""></form>';
				//echo '<script>fRedirect("https://bio-views.com/bv/affiliate/commission-rule");</script>';
				echo $this->layout()->content ;  //original page [ET]
			}
			
		}
		else
		{
			echo $this->layout()->content ;
		
		?>
		
      <?php //echo $this->content('global-user', 'after') ?>
	 
	  
    </div>
  </div>
  <div id="global_footer">
    <?php echo $this->content('footer') ?>
  </div>
  <div id="janrainEngageShare" style="display:none">Share</div>
  <?php
  }
		?>
		

</body>
</html>
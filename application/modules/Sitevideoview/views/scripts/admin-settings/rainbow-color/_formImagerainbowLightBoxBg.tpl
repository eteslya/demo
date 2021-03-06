<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitevideoview
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: _formImagerainbowLightBoxBg.tpl 2012-06-028 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<script type="text/javascript">
  window.addEvent('domready', function() {
    var s = new MooRainbow('myRainbow1', {
      id: 'myDemo1',
      'startColor': hexcolorTonumbercolor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sitevideoview.lightbox.bgcolor', '#0A0A0A') ?>"),
      'onChange': function(color) {
        $('sitevideoview_lightbox_bgcolor').value = color.hex;
      }
    });
			
  });
</script>

<?php
echo '
	<div id="sitevideoview_lightbox_bgcolor-wrapper" class="form-wrapper">
		<div id="sitevideoview_lightbox_bgcolor-label" class="form-label">
			<label for="sitevideoview_lightbox_bgcolor" class="optional">
				' . $this->translate('Videos Lightbox Background Color') . '
			</label>
		</div>
		<div id="sitevideoview_lightbox_bgcolor-element" class="form-element">
			<p class="description">' . $this->translate('Select a color for the background of the lightbox displaying videos. (Click on the rainbow below to choose your color.)') . '</p>
			<input name="sitevideoview_lightbox_bgcolor" id="sitevideoview_lightbox_bgcolor" value=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('sitevideoview.lightbox.bgcolor', '#0A0A0A') . ' type="text">
			<input name="myRainbow1" id="myRainbow1" src="'. $this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/images/rainbow.png" link="true" type="image">
		</div>
	</div>
'
?>
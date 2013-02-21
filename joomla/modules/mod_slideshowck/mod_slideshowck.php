<?php

/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';
$items = modSlideshowckHelper::getItems($params);

if ( $params->get('displayorder', 'normal') == 'shuffle' )
    shuffle($items);
// if (!count($items) OR !$items) return false;

//<script src="http://localhost/joomla25dev/modules/mod_slideshowck/assets/jquery.min.js" type="text/javascript"></script>
$js = '';
$document = JFactory::getDocument();
if ($params->get('loadjquery', '1')) {
    $document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.min.js');
    //$js .= '<script src="' . JURI::base() . 'modules/mod_slideshowck/assets/jquery.min.js" type="text/javascript"></script>';
}
if ($params->get('loadjqueryeasing', '1')) {
    $document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.easing.1.3.js');
    //$js .= '<script src="' . JURI::base() . 'modules/mod_slideshowck/assets/jquery.easing.1.3.js" type="text/javascript"></script>';
}
if ($params->get('loadjquerymobile', '1')) {
    $document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/jquery.mobile.customized.min.js');
    //$js .= '<script src="' . JURI::base() . 'modules/mod_slideshowck/assets/jquery.mobile.customized.min.js" type="text/javascript"></script>';
}

$document->addScript(JURI::base(true) . '/modules/mod_slideshowck/assets/camera.min.js');
//$js .= '<script src="' . JURI::base() . 'modules/mod_slideshowck/assets/camera.min.js" type="text/javascript"></script>';

$theme = $params->get('theme', 'default');
$document->addStyleSheet(JURI::base(true) . '/modules/mod_slideshowck/themes/' . $theme . '/css/camera.css');

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css')) {
	echo '
		<!--[if lte IE 7]>
		<link href="'.JURI::base(true) .'/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

if (JFile::exists('modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css')) {
	echo '
		<!--[if IE 8]>
		<link href="'.JURI::base(true) .'/modules/mod_slideshowck/themes/' . $theme . '/css/camera_ie8.css" rel="stylesheet" type="text/css" />
		<![endif]-->';
}

// set the navigation variables
switch ($params->get('navigation', '2')) {
    case 0:
        // aucune
        $navigation = "navigationHover: false,
                navigation: false,
                playPause: false,";
        break;
    case 1:
        // toujours
        $navigation = "navigationHover: false,
                navigation: true,
                playPause: true,";
        break;
    case 2:
    default:
        // on mouseover
        $navigation = "navigationHover: true,
                navigation: true,
                playPause: true,";
        break;
}

// load the slideshow script
$js .= "<script type=\"text/javascript\"> <!--
       jQuery(function(){
        jQuery('#camera_wrap_" . $module->id . "').camera({
                height: '" . $params->get('height', '400') . "',
                minHeight: '',
                pauseOnClick: false,
                hover: " . $params->get('hover', '1') . ",
                fx: '" . implode(",", $params->get('effect', array('linear'))) . "',
                loader: '" . $params->get('loader', 'pie') . "',
                pagination: " . $params->get('pagination', '1') . ",
                thumbnails: " . $params->get('thumbnails', '1') . ",
                time: " . $params->get('time', '7000') . ",
                transPeriod: " . $params->get('transperiod', '1500') . ",
                alignment: '" . $params->get('alignment', 'center') . "',
                autoAdvance: " . $params->get('autoAdvance', '1') . ",
                mobileAutoAdvance: " . $params->get('autoAdvance', '1') . ",
                portrait: " . $params->get('portrait', '0') . ",
                barDirection: '" . $params->get('barDirection', 'leftToRight') . "',
                imagePath: '".JURI::root()."modules/mod_slideshowck/images/',
                fullpage: " . $params->get('fullpage', '0') .",
                " . $navigation . "
                barPosition: '" . $params->get('barPosition', 'bottom') . "'
        });
}); //--> </script>";
//$document->addScriptDeclaration($js);
echo $js;

// load some css
$css = "#camera_wrap_" . $module->id . " .camera_pag_ul li img {width:" . $params->get('thumbnailwidth','100') . "px;height:" . $params->get('thumbnailheight','75') . "px;}";

// load the caption styles
$captioncss = modSlideshowckHelper::createCss($params, 'captionstyles');
$fontfamily = $params->get('captionstylestextgfont', '0') ? "font-family:'".$params->get('captionstylestextgfont', 'Droid Sans') ."';" : '';
if ($fontfamily) {
    $gfonturl = str_replace(" ","+",$params->get('captionstylestextgfont', 'Droid Sans'));
    $document->addStylesheet('http://fonts.googleapis.com/css?family='.$gfonturl);
}

$css .= "
#camera_wrap_" . $module->id . " .camera_caption {
	display: block;
	position: absolute;
}
#camera_wrap_" . $module->id . " .camera_caption > div {
	" . $captioncss['padding'] . $captioncss['margin'] . $captioncss['background'] . $captioncss['gradient'] . $captioncss['borderradius'] . $captioncss['shadow'] . $captioncss['border'] . $captioncss['fontcolor'] . $captioncss['fontsize'] . $fontfamily ."
}
#camera_wrap_" . $module->id . " .camera_caption > div div.slideshowck_description {
	" . $captioncss['descfontcolor'] . $captioncss['descfontsize'] ."
}
";
$document->addStyleDeclaration($css);

// display the module
require JModuleHelper::getLayoutPath('mod_slideshowck', $params->get('layout', 'default'));

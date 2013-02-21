<?php defined('_JEXEC') or die;
/* =====================================================================
Template:	OneWeb for Joomla 2.5
Author: 	Seth Warburton - Internet Inspired! - @nternetinspired
Version: 	2.0
Created: 	May 2012
Copyright:	Seth Warburton - (C) 2012 - All rights reserved
License:	GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
Sources:	http://html5boilerplate.com/
			http://construct-framework.com/
/* ===================================================================== */

// Define shortcuts for template parameters
$loadMoo 				= $this->params->get('loadMoo');
$jQuery 				= $this->params->get('jQuery');
$modernizr				= $this->params->get('modernizr');
$badBrowser				= $this->params->get('badBrowser');
$scripts 				= $this->params->get('scripts');
$frontpage				= $this->params->get('frontpage');
$setGeneratorTag		= $this->params->get('setGeneratorTag');
$analytics 				= $this->params->get('analytics');
$verification			= $this->params->get('verification');
$googleWebFonts			= $this->params->get('googleWebFonts');

// Calculate the number of modules published in a positon 
$aboveModules = ($this->countModules('above1')?1:0)+ ($this->countModules('above2')?1:0)+ ($this->countModules('above3')?1:0)+ ($this->countModules('above4')?1:0);
$bottomModules = ($this->countModules('bottom1')?1:0)+ ($this->countModules('bottom2')?1:0)+ ($this->countModules('bottom3')?1:0)+ ($this->countModules('bottom4')?1:0)+ ($this->countModules('bottom5')?1:0)+ ($this->countModules('bottom6')?1:0);
$footerModules = ($this->countModules('footer1')?1:0)+ ($this->countModules('footer2')?1:0)+ ($this->countModules('footer3')?1:0)+ ($this->countModules('footer4')?1:0);

#-----------------------------See if we are on the homepage-----------------------------#
// from Anthony Olsen of Joomla Bamboo, http://www.joomlabamboo.com

$activeMenu = & JSite::getMenu();
if ($activeMenu->getActive() == $activeMenu->getDefault()) {$siteHome = 'home';}else{$siteHome = 'sub';}

#----------------------------- Construct Code Snippets-----------------------------#
// GPL code taken from Construct template framework by Matt Thomas http://construct-framework.com/

// To enable use of site configuration
$app 					= JFactory::getApplication();
$pageParams             		= $app->getParams();

// Returns a reference to the global document object
$doc 					= JFactory::getDocument();

// Define relative path to the  current template directory
$template 				= 'templates/'.$this->template;

// Change generator tag
$this->setGenerator($setGeneratorTag);

// Remove MooTools if set to no.
if ( !$loadMoo ) {
	unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools-core.js']);
    unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools-more.js']);
    unset($doc->_scripts[$this->baseurl.'/media/system/js/core.js']);
    unset($doc->_scripts[$this->baseurl.'/media/system/js/caption.js']);
    unset($doc->_scripts[$this->baseurl.'/media/system/js/modal.js']);
    unset($doc->_scripts[$this->baseurl.'/media/system/js/mootools.js']);
    unset($doc->_scripts[$this->baseurl.'/plugins/system/mtupgrade/mootools.js']);
}
#----------------------------- End Construct Code -----------------------------#

#----------------------------- Inject extras into the head -----------------------------#
// You can create your own custom Modernizr build http://modernizr.com/ and change the filename here to match
if ($modernizr) {
$doc->addCustomTag('<script src="'.$template.'/js/modernizr-2.5.3.min.js"></script>');
}
// Currently the latest minified version from Google. Change the version no. here if you want
if ($jQuery) {
  $doc->addCustomTag('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>');
}
// Site icons: http://mathiasbynens.be/notes/touch-icons 
// For third-generation iPad with high-resolution Retina display:
$doc->addCustomTag('<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.$template.'/images/large/apple-touch-icon.png">');
//For iPhone with high-resolution Retina display:
$doc->addCustomTag('<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'.$template.'/images/large/apple-touch-icon.png">');
// For first- and second-generation iPad:
$doc->addCustomTag('<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'.$template.'/images/medium/apple-touch-icon.png">');
// For non-Retina iPhone, iPod Touch, and Android 2.1+ devices:
$doc->addCustomTag('<link rel="apple-touch-icon-precomposed" href="'.$template.'/images/small/apple-touch-icon-precomposed.png">');

// Global styles
$doc->addStyleSheet($template.'/css/style-commented.css');
// Google fonts styles
if ($googleWebFonts != "copy the css link from Google here") {
$doc->addStyleSheet(''.$googleWebFonts.'');
}
// Metas
$doc->setMetaData( 'HandheldFriendly', 'True' );
$doc->setMetaData( 'MobileOptimized', '320' );
// This lets mobile devices know we have thought about them
$doc->setMetaData( 'viewport', 'width=device-width, initial-scale=1.0' );
// Apple specific stuff
$doc->setMetaData( 'apple-mobile-web-app-capable', 'True' );
$doc->setMetaData( 'apple-mobile-web-app-status-bar-style', 'black' );
// For Win mobile
$doc->setMetaData( 'cleartype', 'on');

// CSS3 pseudo selector and media query support for IE8 and below
if ($badBrowser) {
$doc->addCustomTag('<!--[if (lt IE 9) & (!IEMobile)]>');
$doc->addCustomTag('<script src="'.$template.'/js/respond.min.js"></script>');
$doc->addCustomTag('<script src="'.$template.'/js/selectivizr-min.js"></script>');
$doc->addCustomTag('<![endif]-->');
}

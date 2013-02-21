<?php

/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.joomla-monster.com/license.html Joomla-Monster Proprietary Use License
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

if(JRequest::getVar('direction')=='rtl'){
	setcookie("djdirection", "rtl");
	$direction='rtl';
} else if(JRequest::getVar('direction')=='ltr'){
	setcookie("djdirection", "ltr");
	$direction='ltr';
} else {
	$direction=JRequest::getVar('djdirection','ltr');
}

$mosConfig_live_site = $this->baseurl;
$app = JFactory::getApplication();

// setting variable for template base url
$dj_name = $app->getTemplate();
$dj_path = $mosConfig_live_site . '/templates/' . $dj_name . '/';

// getting information about current scheme (the number of columns)
$showLeft  = ($this->countModules('left') or $this->countModules('position-7'));
$showRight  = ($this->countModules('right') or $this->countModules('position-3') or $this->countModules('position-4'));
$scheme = 1;
if($showLeft) $scheme++;
if($showRight) $scheme++;

//getting information template parameters
	$templateparams	= $app->getTemplate(true)->params;
// getting information about font switcher
	$fontswitcher = ($this->params->get("fontswitcher", 1) == 0) ? false : true;
// getting information about style switcher
	$stylearea = ($this->params->get("stylearea", 1) == 0) ? false : true;
// getting information about width switcher
	$widtharea = ($this->params->get("widtharea", 1) == 0) ? false : true;
// getting information about font size
	$fontsize = ($this->params->get("fontsize", 12));
// getting information about basic template color
	$template_color = $this->params->get("template_color", 1);
// getting information about basic template width
	$page_width = $this->params->get("page_width", 960 );
//getting information about logo
	$logo = $this->params->get('logo');
//getting information about sitedescription
	$sitedescription = $this->params->get('sitedescription');
	
	$template_width="defaultwidth";
	
	
if (($this->countModules('user1') == 0) || ($this->countModules('user2') == 0)) {
	$user12="_oneuser";
} else {
	$user12="";
}

$firstbottommodule = $this->countModules('bottom1');
$secondbottommodule = $this->countModules('bottom2');
$thirdbottommodule = $this->countModules('bottom3'); 
$fourthbottommodule = $this->countModules('bottom4');

$bottommodule1 = ($firstbottommodule ? 1 : 0);
$bottommodule2 = ($secondbottommodule ? 1 : 0);
$bottommodule3 = ($thirdbottommodule ? 1 : 0);
$bottommodule4 = ($fourthbottommodule ? 1 : 0);

$bottom_total = ($bottommodule1 + $bottommodule2 + $bottommodule3 + $bottommodule4);

?> 
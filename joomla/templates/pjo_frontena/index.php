<?php
defined('_JEXEC') or die;
include_once (dirname(__FILE__).DS.'/at_tools.php');
$this->at_color_themes = array('default','color1','color2','color3');
$tempTools = new at_Tools($this);
$ATconfig = $tempTools->getUserSetting();
$at_left = $this->countModules('left');
$at_right = $this->countModules('right');
if ( $at_left && $at_right ) 
{
$divid = '';
} 
elseif ( $at_left ) 
{
$divid = '-fr';
}
elseif ( $at_right ) 
{
$divid = '-fl';
}
else 
{
$divid = '-f';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<!--[if lte IE 6]><P>
<style type="text/css">
#logo, h3, #at-wrapfooter, #at-search { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
.clearfix {height: 1%;}
div.module h3, div.module_menu h3, div.module-blank h3, div.module_text h3 { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
#at-pathway { behavior: url("<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/iepngfix.htc"); }
</style>
<![endif]-->
<!--[if IE]>
<style type="text/css">
.clearfix {display: inline-block;}
</style>
<![endif]--> 
<jdoc:include type="head" />
<?php $tempTools->genMenuHead(); ?>
<link href="<?php echo $this->baseurl ?>/templates/system/css/system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl ?>/templates/system/css/general.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/colors/<?php echo $ATconfig->at_color; ?>.css" type="text/css" />

<script type="text/javascript" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/scripts/at.script.js"></script>

</head>
<body class="<?php echo $ATconfig->at_width." zupa".$ATconfig->at_font_size;?>" id="bd">
<a name="up" id="up"></a>
<div id="at-wrapper">
<div id="at-wrapheader" class="clearfix">
<a href="<?php echo $this->baseurl ?>"><span id="logo"></span></a>
<?php if($this->countModules('user3')) : ?>
<div id="at-user3">
<jdoc:include type="modules" name="user3" style="notitle" />
</div>
<?php endif; ?>
<div id="at-wrapmainnavigation" class="clearfix">
<div id="at-mainnavigation">
<?php
switch ($ATconfig->at_menutype) {
case 2:
case 4:
include(dirname(__FILE__).DS."/at_menu.php");
$atmenu->genMenu (0);
break;
}
?>
</div>
</div>
<div id="at-usertools">
<?php  if($ATconfig->at_tool & 2) $tempTools->genToolMenu(2); ?>
</div>
<div id="at-usercolors" class="clearfix">
<?php if($ATconfig->at_tool & 4) $tempTools->genToolMenu(4); ?>
</div>
<?php if($this->countModules('position-0')) : ?>
<div id="at-search">
<jdoc:include type="modules" name="position-0" style="notitle" />
</div>
<?php endif; ?>
</div>
<div id="at-containerwrap<?php echo $divid; ?>">
<div id="at-container">
<div id="at-mainbody<?php echo $divid; ?>">
<div id="javascript-flash-header">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="712" height="283">
<param name="movie" value="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.swf?xml_path=<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.xml" />
<param name="quality" value="high" />
<param name="wmode" value="transparent" />
<embed wmode="transparent" src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.swf?xml_path=<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/header/header.xml" width="712" height="283" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
</object>
</div>

<div id="at-contentwrap">
<jdoc:include type="message" />
<div id="at-content">
<jdoc:include type="component" /></div>
</div>
<?php if ( $at_right ) { ?>
<div id="at-col2">
<div class="at-innerpad">
<jdoc:include type="modules" name="right" style="rounded" />
</div>
</div><br />
<?php } ?>
</div>
<?php if ( $at_left ) { ?>
<div id="at-col1">
<div class="at-innerpad">
<jdoc:include type="modules" name="left" style="rounded" />
</div>
</div>
<?php } ?>
<div id="at-bottomwrap">
<div id="at-bottom">
<table cellspacing="10" border="0" cellpadding="0">
<tr valign="top">
<?php if( $this->countModules('user7') ) {?>
<td>
<jdoc:include type="modules" name="user7" style="rounded" />
</td>
<?php } ?>
<?php if( $this->countModules('user8') ) {?>
<td>
<jdoc:include type="modules" name="user8" style="rounded" />
</td>
<?php } ?>
<?php if( $this->countModules('user9') ) {?>
<td>
<jdoc:include type="modules" name="user9" style="rounded" />
</td>
<?php } ?>
</table>
</div>
</div>
</div>
</div>
<div id="at-footerwrap">
<div id="at-footer">
<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
global $_VERSION;
require_once('libraries/joomla/utilities/date.php');
$date  = new JDate();
$config = new JConfig();
?>
Copyright &copy; <?php echo $date->toFormat( '%Y' ) . ' ' . $config->sitename;?>. Designed by <a href="http://www.pickjoomla.com/" title="Visit pickjoomla.com!" target="blank">pickjoomla</a>
<div id= "goup-image">
<a href="#up" title="Go up" style="text-decoration: none;"><img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/images/go-up.gif" title="Go up" alt="Go up" /></a>
</div>
</div>
</div>
</div>
</body>
</html>

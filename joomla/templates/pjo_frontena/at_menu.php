<?php
jimport( 'joomla.html.parameter' ); // updated  
defined('_JEXEC') or die;
/**
/* Loads main class file
*/
$menu = "CSSmenu";

$atparams = new JParameter('');
$atparams->set( 'menu_images', 1 );                    //    Source of menu
$atparams->set( 'menu_images_align', 'left' );
$atparams->set( 'menutype', 'mainmenu' );

include_once( dirname(__FILE__).DS.'at_menu/'.$menu.'.class.php' );

$menuclass = "at_$menu";
$atmenu = new $menuclass ($atparams);
?>
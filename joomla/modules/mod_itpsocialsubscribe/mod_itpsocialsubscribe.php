<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPSocialSubscribe
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPSocialSubscribe is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined('_JEXEC') or die;

JLoader::register('ItpSocialSubscribeHelper', dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

$doc = JFactory::getDocument();
/** $doc JDocumentHTML **/

if($params->get("loadCss")) {
    $doc->addStyleSheet("modules/mod_itpsocialsubscribe/style.css");
}

require JModuleHelper::getLayoutPath('mod_itpsocialsubscribe', $params->get('layout', 'default'));
<?php

/**
 * @copyright	Copyright (C) 2011 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die;
$com_path = JPATH_SITE.'/components/com_content/';
require_once $com_path.'router.php';
require_once $com_path.'helpers/route.php';
JModelLegacy::addIncludePath($com_path . '/models', 'ContentModel');

class modSlideshowckHelper {

    /**
     * Get a list of the items.
     *
     * @param	JRegistry	$params	The module options.
     *
     * @return	array
     */
    static function getItems(&$params) {
        // Initialise variables.
        $db = JFactory::getDbo();
        $document = JFactory::getDocument();

        // Access filter
        $access = !JComponentHelper::getParams('com_content')->get('show_noauth');
        $authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));

        // load the libraries
        //jimport('joomla.application.module.helper');
        $items = json_decode(str_replace("|qq|", "\"", $params->get('slides')));
        foreach ($items as $i => $item) {
            if (!$item->imgname) {
                unset($items[$i]);
                continue;
            }

            if (isset($item->slidearticleid) && $item->slidearticleid) {
                // Get an instance of the generic articles model
                $articles = JModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));
                // Set application parameters in model
                $app = JFactory::getApplication();
                $appParams = $app->getParams();
                $articles->setState('params', $appParams);
                $articles->setState('filter.published', 1);
                $articles->setState('filter.article_id', $item->slidearticleid);
                $items2 = $articles->getItems();
                // var_dump($items2);die();
                // check if we need to load an article content
                // $item->article = ($item->slidearticleid) ? self::loadArticleFromId($item->slidearticleid) : '';
                $item->article = $items2[0];
                $item->article->text = JHTML::_('content.prepare', $item->article->introtext);
                $item->article->text = self::truncate($item->article->text, $params->get('articlelength','150'));
                // $item->article->text = JHTML::_('string.truncate',$item->article->introtext,'150');
                // set the item link to the article depending on the user rights
                if ($access || in_array($item->article->access, $authorised)) {
                    // We know that user has the privilege to view the article
                    $item->slug = $item->article->id . ':' . $item->article->alias;
                    $item->catslug = $item->article->catid ? $item->article->catid . ':' . $item->article->category_alias : $item->article->catid;
                    $item->article->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
                } else {
                    // Angie Fixed Routing
                    $app = JFactory::getApplication();
                    $menu = $app->getMenu();
                    $menuitems = $menu->getItems('link', 'index.php?option=com_users&view=login');
                    if (isset($menuitems[0])) {
                        $Itemid = $menuitems[0]->id;
                    } elseif (JRequest::getInt('Itemid') > 0) { //use Itemid from requesting page only if there is no existing menu
                        $Itemid = JRequest::getInt('Itemid');
                    }

                    $item->article->link = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $Itemid);
                }
            } else {
                $item->article = null;
            }

            if (stristr($item->imgname, "http")) {
                $item->imgthumb = $item->imgname;
            } else {
                // crée la miniature
                if ($params->get('thumbnails', '1') == '1') self::resizeImage($item->imgname, $params->get('thumbnailwidth', '100'), $params->get('thumbnailheight', '75'));
                // renomme le fichier
                $thumbext = explode(".", $item->imgname);
                $thumbext = end($thumbext);
                // set the variables
                $item->imgname = JURI::base() . $item->imgname;
                $item->imgthumb = str_replace("." . $thumbext, "_th." . $thumbext, $item->imgname);
            }

            // set the videolink
            if ($item->imgvideo)
                $item->imgvideo = self::setVideolink($item->imgvideo);

            // manage the title and description
            if (stristr($item->imgcaption, "||")) {
                $splitcaption = explode("||", $item->imgcaption);
                $item->imgcaption = '<div class="slideshowck_title">' . $splitcaption[0] . '</div><div class="slideshowck_description">' . $splitcaption[1] . '</div>';
            }
        }
        //shuffle($items);
        return $items;
    }

    /**
     * Set the correct video link
     *
     * $videolink string the video path
     *
     * @return string the new video path
     */
    static function setVideolink($videolink) {
        // youtube
        if (stristr($videolink, 'youtu.be')) {
            $videolink = str_replace('youtu.be', 'www.youtube.com/embed', $videolink);
        } else if (stristr($videolink, 'www.youtube.com') AND !stristr($videolink, 'embed')) {
            $videolink = str_replace('youtube.com', 'youtube.com/embed', $videolink);
        }

        $videolink .= ( stristr($videolink, '?')) ? '&wmode=transparent' : '?wmode=transparent';

        return $videolink;
    }

    /**
     * Create the list of all modules published as Object
     *
     * $file string the image path
     * $x integer the new image width
     * $y integer the new image height
     *
     * @return Boolean True on Success
     */
    static function resizeImage($file, $x, $y) {

        // $file = 'image.jpg' ; # L'emplacement de l'image à redimensionner. L'image peut être de type jpeg, gif ou png
        if (!$file)
            return;
        $file = JPATH_ROOT . '/' . $file;
        //$x = 100;
        //$y = $x*3/4; # Taille en pixel de l'image redimensionnée

        $size = getimagesize($file);

        if ($size) {
            //echo 'Image en cours de redimensionnement...';
            // renomme le fichier
            $thumbext = explode(".", $file);
            $thumbext = end($thumbext);
            $thumbfile = str_replace("." . $thumbext, "_th." . $thumbext, $file);
            // var_dump($thumbfile);

            if (JFile::exists($thumbfile)) {
                $thumbsize = getimagesize($thumbfile);
                if ($thumbsize[0] == $x AND $thumbsize[1] == $y) {
                    //echo 'miniature existante';
                    return;
                }
            }


            if ($size['mime'] == 'image/jpeg') {
                $img_big = imagecreatefromjpeg($file); # On ouvre l'image d'origine
                $img_new = imagecreate($x, $y);
                # création de la miniature
                $img_mini = imagecreatetruecolor($x, $y)
                        or $img_mini = imagecreate($x, $y);

                // copie de l'image, avec le redimensionnement.
                imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

                imagejpeg($img_mini, $thumbfile);
            } elseif ($size['mime'] == 'image/png') {
                $img_big = imagecreatefrompng($file); # On ouvre l'image d'origine
                $img_new = imagecreate($x, $y);
                # création de la miniature
                $img_mini = imagecreatetruecolor($x, $y)
                        or $img_mini = imagecreate($x, $y);

                // copie de l'image, avec le redimensionnement.
                imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

                imagepng($img_mini, $thumbfile);
            } elseif ($size['mime'] == 'image/gif') {
                $img_big = imagecreatefromgif($file); # On ouvre l'image d'origine
                $img_new = imagecreate($x, $y);
                # création de la miniature
                $img_mini = imagecreatetruecolor($x, $y)
                        or $img_mini = imagecreate($x, $y);

                // copie de l'image, avec le redimensionnement.
                imagecopyresized($img_mini, $img_big, 0, 0, 0, 0, $x, $y, $size[0], $size[1]);

                imagegif($img_mini, $thumbfile);
            }
            //echo 'Image redimensionnée !';
        }
    }

    /**
     * Create the css
     *
     * $params JRegistry the module params
     * $prefix integer the prefix of the params
     *
     * @return Array of css
     */
    static function createCss($params, $prefix = 'menu') {
        $css = Array();
        $csspaddingtop = ($params->get($prefix . 'paddingtop') AND $params->get($prefix . 'usemargin')) ? 'padding-top: ' . $params->get($prefix . 'paddingtop', '0') . 'px;' : '';
        $csspaddingright = ($params->get($prefix . 'paddingright') AND $params->get($prefix . 'usemargin')) ? 'padding-right: ' . $params->get($prefix . 'paddingright', '0') . 'px;' : '';
        $csspaddingbottom = ($params->get($prefix . 'paddingbottom') AND $params->get($prefix . 'usemargin') ) ? 'padding-bottom: ' . $params->get($prefix . 'paddingbottom', '0') . 'px;' : '';
        $csspaddingleft = ($params->get($prefix . 'paddingleft') AND $params->get($prefix . 'usemargin')) ? 'padding-left: ' . $params->get($prefix . 'paddingleft', '0') . 'px;' : '';
        $css['padding'] = $csspaddingtop . $csspaddingright . $csspaddingbottom . $csspaddingleft;
        $cssmargintop = ($params->get($prefix . 'margintop') AND $params->get($prefix . 'usemargin')) ? 'margin-top: ' . $params->get($prefix . 'margintop', '0') . 'px;' : '';
        $cssmarginright = ($params->get($prefix . 'marginright') AND $params->get($prefix . 'usemargin')) ? 'margin-right: ' . $params->get($prefix . 'marginright', '0') . 'px;' : '';
        $cssmarginbottom = ($params->get($prefix . 'marginbottom') AND $params->get($prefix . 'usemargin')) ? 'margin-bottom: ' . $params->get($prefix . 'marginbottom', '0') . 'px;' : '';
        $cssmarginleft = ($params->get($prefix . 'marginleft') AND $params->get($prefix . 'usemargin')) ? 'margin-left: ' . $params->get($prefix . 'marginleft', '0') . 'px;' : '';
        $css['margin'] = $cssmargintop . $cssmarginright . $cssmarginbottom . $cssmarginleft;
        $css['background'] = ($params->get($prefix . 'bgcolor1') AND $params->get($prefix . 'usebackground')) ? 'background: ' . $params->get($prefix . 'bgcolor1') . ';' : '';
        $css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-image: url("' . JURI::ROOT() . $params->get($prefix . 'bgimage') . '");' : '';
        $css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-repeat: ' . $params->get($prefix . 'bgimagerepeat') . ';' : '';
        $css['background'] .= ( $params->get($prefix . 'bgimage') AND $params->get($prefix . 'usebackground')) ? 'background-position: ' . $params->get($prefix . 'bgpositionx') . ' ' . $params->get($prefix . 'bgpositiony') . ';' : '';
        $css['gradient'] = ($css['background'] AND $params->get($prefix . 'bgcolor2') AND $params->get($prefix . 'usegradient')) ?
                "background: -moz-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%, " . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
                . "background: -webkit-gradient(linear, left top, left bottom, color-stop(0%," . $params->get($prefix . 'bgcolor1', '#f0f0f0') . "), color-stop(100%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . ")); "
                . "background: -webkit-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
                . "background: -o-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
                . "background: -ms-linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%);"
                . "background: linear-gradient(top,  " . $params->get($prefix . 'bgcolor1', '#f0f0f0') . " 0%," . $params->get($prefix . 'bgcolor2', '#e3e3e3') . " 100%); "
                . "filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $params->get($prefix . 'bgcolor1', '#f0f0f0') . "', endColorstr='" . $params->get($prefix . 'bgcolor2', '#e3e3e3') . "',GradientType=0 );" : '';
        $css['borderradius'] = ($params->get($prefix . 'useroundedcorners')) ?
                '-moz-border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;'
                . '-webkit-border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;'
                . 'border-radius: ' . $params->get($prefix . 'roundedcornerstl', '0') . 'px ' . $params->get($prefix . 'roundedcornerstr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbr', '0') . 'px ' . $params->get($prefix . 'roundedcornersbl', '0') . 'px;' : '';
        $shadowinset = $params->get($prefix . 'shadowinset', 0) ? 'inset ' : '';
        $css['shadow'] = ($params->get($prefix . 'shadowcolor') AND $params->get($prefix . 'shadowblur') AND $params->get($prefix . 'useshadow')) ?
                '-moz-box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';'
                . '-webkit-box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';'
                . 'box-shadow: ' . $shadowinset . $params->get($prefix . 'shadowoffsetx', '0') . 'px ' . $params->get($prefix . 'shadowoffsety', '0') . 'px ' . $params->get($prefix . 'shadowblur', '') . 'px ' . $params->get($prefix . 'shadowspread', '0') . 'px ' . $params->get($prefix . 'shadowcolor', '') . ';' : '';
        $css['border'] = ($params->get($prefix . 'bordercolor') AND $params->get($prefix . 'borderwidth') AND $params->get($prefix . 'useborders')) ?
                'border: ' . $params->get($prefix . 'bordercolor', '#efefef') . ' ' . $params->get($prefix . 'borderwidth', '1') . 'px solid;' : '';
        $css['fontsize'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontsize')) ?
                'font-size: ' . $params->get($prefix . 'fontsize') . ';' : '';
        $css['fontcolor'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontcolor')) ?
                'color: ' . $params->get($prefix . 'fontcolor') . ';' : '';
        $css['fontweight'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontweight')) ?
                'font-weight: ' . $params->get($prefix . 'fontweight') . ';' : '';
        /* $css['fontcolorhover'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'fontcolorhover')) ?
          'color: ' . $params->get($prefix . 'fontcolorhover') . ';' : ''; */
        $css['descfontsize'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'descfontsize')) ?
                'font-size: ' . $params->get($prefix . 'descfontsize') . ';' : '';
        $css['descfontcolor'] = ($params->get($prefix . 'usefont') AND $params->get($prefix . 'descfontcolor')) ?
                'color: ' . $params->get($prefix . 'descfontcolor') . ';' : '';
        return $css;
    }

    /**
     * Truncates text blocks over the specified character limit and closes
     * all open HTML tags. The method will optionally not truncate an individual
     * word, it will find the first space that is within the limit and
     * truncate at that point. This method is UTF-8 safe.
     *
     * @param   string   $text       The text to truncate.
     * @param   integer  $length     The maximum length of the text.
     * @param   boolean  $noSplit    Don't split a word if that is where the cutoff occurs (default: true).
     * @param   boolean  $allowHtml  Allow HTML tags in the output, and close any open tags (default: true).
     *
     * @return  string   The truncated text.
     *
     * @since   11.1
     */
    public static function truncate($text, $length = 0, $noSplit = true, $allowHtml = true) {
        // Check if HTML tags are allowed.
        if (!$allowHtml) {
            // Deal with spacing issues in the input.
            $text = str_replace('>', '> ', $text);
            $text = str_replace(array('&nbsp;', '&#160;'), ' ', $text);
            $text = JString::trim(preg_replace('#\s+#mui', ' ', $text));

            // Strip the tags from the input and decode entities.
            $text = strip_tags($text);
            $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');

            // Remove remaining extra spaces.
            $text = str_replace('&nbsp;', ' ', $text);
            $text = JString::trim(preg_replace('#\s+#mui', ' ', $text));
        }

        // Truncate the item text if it is too long.
        if ($length > 0 && JString::strlen($text) > $length) {
            // Find the first space within the allowed length.
            $tmp = JString::substr($text, 0, $length);

            if ($noSplit) {
                $offset = JString::strrpos($tmp, ' ');
                if (JString::strrpos($tmp, '<') > JString::strrpos($tmp, '>')) {
                    $offset = JString::strrpos($tmp, '<');
                }
                $tmp = JString::substr($tmp, 0, $offset);

                // If we don't have 3 characters of room, go to the second space within the limit.
                if (JString::strlen($tmp) > $length - 3) {
                    $tmp = JString::substr($tmp, 0, JString::strrpos($tmp, ' '));
                }
            }

            if ($allowHtml) {
                // Put all opened tags into an array
                preg_match_all("#<([a-z][a-z0-9]*)\b.*?(?!/)>#i", $tmp, $result);
                $openedTags = $result[1];
                $openedTags = array_diff($openedTags, array("img", "hr", "br"));
                $openedTags = array_values($openedTags);

                // Put all closed tags into an array
                preg_match_all("#</([a-z]+)>#iU", $tmp, $result);
                $closedTags = $result[1];

                $numOpened = count($openedTags);

                // All tags are closed
                if (count($closedTags) == $numOpened) {
                    return $tmp . '...';
                }
                $tmp .= '...';
                $openedTags = array_reverse($openedTags);

                // Close tags
                for ($i = 0; $i < $numOpened; $i++) {
                    if (!in_array($openedTags[$i], $closedTags)) {
                        $tmp .= "</" . $openedTags[$i] . ">";
                    } else {
                        unset($closedTags[array_search($openedTags[$i], $closedTags)]);
                    }
                }
            }

            $text = $tmp;
        }

        return $text;
    }

}

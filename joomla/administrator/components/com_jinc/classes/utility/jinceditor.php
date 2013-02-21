<?php

/**
 * @package		JINC
 * @subpackage          Utility
 * @copyright           Copyright (C) 2010 - Lhacky
 * @license		GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
 *   This file is part of JINC.
 *
 *   JINC is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   JINC is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with JINC.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php

class JINCEditor {
    var $width = '90%';
    var $height = '500';
    var $cols = 80;
    var $rows = 30;
    var $editor = null;
    var $name = '';
    var $content = '';
    var $editorConfig = array();
    var $editorContent = '';

    function JINCEditor($name) {
        $this->name = $name;
        $this->myEditor = JFactory::getEditor();
        $this->myEditor->initialise();
    }

    function setTemplate($id) {
        if (empty($id))
            return;
        $app = JFactory::getApplication();
        $cssurl = rtrim(JURI::root(), '/') . '/' . 'administrator/index.php?option=com_jinc&task=templatecss.loadcss&format=css&id=' . $id . '&time=' . time();
        $filepath = JPATH_COMPONENT_ADMINISTRATOR . DS . 'assets' . DS . 'templates' . DS . $id . '.css';
        $filepath = str_replace('/', DS, $filepath);
        $name = $this->myEditor->get('_name');
        if ($name == 'tinymce') {
            $this->editorConfig = array('content_css_custom' => $cssurl, 'content_css' => '0');
        } elseif ($name == 'jckeditor' || $name == 'fckeditor') {
            $this->editorConfig = array('content_css_custom' => $filepath, 'content_css' => '0', 'editor_css' => '0');
        } else {
            $fileurl = 'administrator/components/com_jinc/assets/templates/' . $id . '.css';
            $this->editorConfig = array('custom_css_url' => $cssurl, 'custom_css_file' => $fileurl, 'custom_css_path' => $filepath);
            JRequest::setVar('jinc_cssfile', $fileurl);
            if ($name == 'jce') {
                $jcepath = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_jce' . DS . 'models' . DS;
                if (file_exists($jcepath . 'editor.php')) {
                    jimport('joomla.filesystem.file');
                    $content = JFile::read($jcepath . 'editor.php');
                    if (!strpos($content, 'jinc_cssfile')) {
                        $jinccode = '
			if(JRequest::getCmd(\'option\') == \'com_jinc\'){
				$jinc_cssfile = JRequest::getString(\'jinc_cssfile\');
				if(!empty($jinc_cssfile)) $settings[\'content_css\'] = $jinc_cssfile;
			}
			';
                        $content = preg_replace('#(\$settings\[\'content_css\'\][^=]*= *\$this->getStyleSheets\(\);)#', '$1' . $jinccode, $content);
                        jincimport('utility.servicelocator');
                        $servicelocator = ServiceLocator::getInstance();
                        $logger = $servicelocator->getLogger();

                        if (strpos($content, 'jinc_cssfile')) {
                            if (!file_exists($jcepath . 'editor_jbackup.php')) {
                                if (JFile::copy($jcepath . 'editor.php', $jcepath . 'editor_jbackup.php') !== true) {
                                    $logger->info('JINCEditor - Could not copy the file from ' . $jcepath . 'editor.php to ' . $jcepath . 'editor_jbackup.php', 'error');
                                }
                            }
                            if (JFile::write($jcepath . 'editor.php', $content) !== true) {
                                $logger->info('Could not write in ' . $jcepath . 'editor.php <br/> Please make sure this folder is writable', 'error');
                            }
                        }
                    }
                }
            }
        }
    }

    function prepareDisplay() {
        $this->content = htmlspecialchars($this->content, ENT_COMPAT, 'UTF-8');
        ob_start();
        echo $this->myEditor->display($this->name, $this->content, $this->width, $this->height, $this->cols, $this->rows, array('pagebreak', 'readmore'), null, 'com_content', null, $this->editorConfig);
        $this->editorContent = ob_get_clean();
    }

    function setContent($var) {
        $name = $this->myEditor->get('_name');
        $function = "try{" . $this->myEditor->setContent($this->name, $var) . " }catch(err){alert('Error using the setContent function of the wysiwyg editor')}";
        if (!empty($name)) {
            if ($name == 'jce') {
                return " try{JContentEditor.setContent('" . $this->name . "', $var ); }catch(err){try{WFEditor.setContent('" . $this->name . "', $var )}catch(err){" . $function . "} }";
            }
            if ($name == 'fckeditor') {
                return " try{FCKeditorAPI.GetInstance('" . $this->name . "').SetHTML( $var ); }catch(err){" . $function . "} ";
            }
            if ($name == 'jckeditor') {
                return " try{oEditor.setData(" . $var . ");}catch(err){(!oEditor) ? CKEDITOR.instances." . $this->name . ".setData($var) : oEditor.insertHtml = " . $var . '}';
            }
            if ($name == 'ckeditor') {
                return " try{CKEDITOR.instances." . $this->name . ".setData( $var ); }catch(err){" . $function . "} ";
            }
            if ($name == 'artofeditor') {
                return " try{CKEDITOR.instances." . $this->name . ".setData( $var ); }catch(err){" . $function . "} ";
            }
        }
        return $function;
    }

    function getContent() {
        return $this->myEditor->getContent($this->name);
    }

    function display() {
        if (empty($this->editorContent))
            $this->prepareDisplay();
        return $this->editorContent;
    }

    function jsCode() {
        return $this->myEditor->save($this->name);
    }

}
?>
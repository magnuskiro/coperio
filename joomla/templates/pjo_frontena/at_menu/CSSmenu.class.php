<?php

defined( '_VALID_MOS' ) or defined('_JEXEC') or die('Restricted access');
if (!defined ('_AT_CSS_MENU_CLASS')) {
	define ('_AT_CSS_MENU_CLASS', 1);
	require_once (dirname(__FILE__).DS."Base.class.php");
	
	class AT_CSSmenu extends AT_Base{
		function beginMenu($startlevel=0, $endlevel = 10){
		}
  
  		function beginMenuItems($pid=0, $level=0){
			if($level==0) echo "<ul id=\"at-cssmenu\" class=\"clearfix\">\n";
			else echo "<ul>";
		}
      
		function endMenu($startlevel=0, $endlevel = 10){
		}
        
        function hasSubMenu($level) {
            return false;
        }
        
        function beginMenuItem($row=null, $level = 0, $pos = '') {
        	/*
        	$active = $this->genClass ($tmp, $level, $pos);
            $active = in_array($row->id, $this->open);
			$active = ($level?"":"menu-item{$row->_idx}"). ($active?" active":"").($pos?" $pos-item":"");
			*/
        	$active = $this->genClass ($row, $level, $pos);
        	if ($level == 0) {
        		$active = preg_replace ('/haschild/', 'havechild', $active);
        	} else {
        		$active = preg_replace ('/haschild/', 'havesubchild', $active);
        	}
            if ($level == 0 && $level < $this->getParam ('endlevel') && @$this->children[$row->id]) echo "<li class=\"havechild {$active}\">";
            else if ($level > 0 && $level < $this->getParam ('endlevel') && @$this->children[$row->id]) echo "<li class=\"havesubchild {$active}\">";
            else echo "<li ".(($active) ? "class=\"$active\"" : "").">";
        }
        function endMenuItem($mitem=null, $level = 0, $pos = ''){
            echo "</li> \n";
        }
		
		function genMenuItem($item, $level = 0, $pos = '', $ret = 0) {
			//if ($level) return parent::genMenuItem($item, $level, '', $ret);
			//else 
			return parent::genMenuItem($item, $level, $pos, $ret);
		}
	}
}
?>
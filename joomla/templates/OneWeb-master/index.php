<?php defined('_JEXEC') or die;
/* =====================================================================
Template:	OneWeb for Joomla 2.5						            
Author: 	Seth Warburton - Internet Inspired! - @nternetinspired 				            
Version: 	2.0 											             
Created: 	June 2012                                                    
Copyright:	Seth Warburton - (C) 2012 - All rights reserved		
Licenses:	GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html DBAD License http://philsturgeon.co.uk/code/dbad-license							             
Sources:	http://html5boilerplate.com/ http://construct-framework.com/					
/* ===================================================================== */

// Load template logic
include_once JPATH_THEMES . '/' . $this->template . '/logic.php';  
?>
<!doctype html>
<!-- HTML5 Boilerplate -->
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<jdoc:include type="head" />

</head>
<body class="<?php echo $pageParams->get('pageclass_sfx'); ?> clearfix">

<!-- coperio addition -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- coperio addition -->

<div id="buttonRow" class="mobile clearfix">
  <?php if($this->countModules('search')) : ?>
		<a id="mobileSearch" href="#search" title="Jump to search">Search</a>
  <?php endif; ?>
  <a id="mobileMenu" href="#menu" title="Jump to navigation">Menu</a>
</div>
<div id="logoRow" class="row clearfix">
	<a href="<?php echo $this->baseurl ?>/" title="<?php echo htmlspecialchars($app->getCfg('sitename'));?>">        		
<!-- 
Sitename out commented its the part in the top left. Changed to logo. 
        <header id="logo"><?php #echo htmlspecialchars($app->getCfg('sitename'));?></header>
-->
        <header id="logo">
            <img src="images/logo/coperio_logo.png">
        </header>
    </a>                     	
</div>
<div id="container">
	<?php if($this->countModules('banner')) : ?>
    <div id="bannerRow" class="row clearfix">           
        <header role="banner" id="banner">
            <jdoc:include type="modules" name="banner" style="html5" headerLevel="4"/>
        </header>	
    </div>
    <?php endif; ?>
    <?php if ($aboveModules > 0) : ?>
	<div id="aboveRow" class="row clearfix">   
		<?php if($this->countModules('above1')) : ?>
        <div id="above1"> 
                <jdoc:include type="modules" name="above1" style="html5" headerLevel="4"/>
        </div>
        <?php endif; ?>     
        <?php if($this->countModules('above2')) : ?>
        <div id="above2">
                <jdoc:include type="modules" name="above2" style="html5" headerLevel="4"/>
        </div>
        <?php endif; ?>                       
        <?php if($this->countModules('above3')) : ?>
        <div id="above3">
                <jdoc:include type="modules" name="above3" style="html5" headerLevel="4"/>
        </div>
        <?php endif; ?>                    
        <?php if($this->countModules('above4')) : ?>
        <div id="above4">
                <jdoc:include type="modules" name="above4" style="html5" headerLevel="4"/>
        </div>
        <?php endif; ?>  
        </div>
	<?php endif; ?>
    <?php if($this->countModules('breadcrumbs')) : ?>
    <div id="breadcrumbRow" class="row clearfix">          
        <nav id="breadcrumbs" role="navigation">
            <jdoc:include type="modules" name="breadcrumbs" style="html5" headerLevel="4"/>
        </nav>
    </div>
    <?php endif; ?>
    <?php if($siteHome == 'sub' or ($frontpage == 0)) : ?>
    <div id="mainRow" class="row clearfix">                                     
        <!-- Copero addition START-->                			
        <?php if($this->countModules('left') or $this->countModules('search') 
        or $this->countModules('right') ) : ?>
        <aside id="sidebar" class="clearfix" role="complementary">
		  <?php if($this->countModules('left')) : ?>
          <div id="left" class="clearfix">         
                  <jdoc:include type="modules" name="left" style="html5"/>
          </div>
          <?php endif; ?>
          <?php if($this->countModules('search')) : ?>
            <div id="search" role="search">
                  <jdoc:include type="modules" name="search" style="html5" />
            </div>
          <?php endif; ?>
        </aside>  
        <div id="main" role="main" class="mainLeft last clearfix">
            <jdoc:include type="message" />
            <jdoc:include type="component" />
        </div>
        <aside id="rightbar" class="clearfix" role="complementary">
		  <?php if($this->countModules('right')) : ?>
          <div id="right" class="clearfix">         
                  <jdoc:include type="modules" name="right" style="html5"/>
          </div>
          <?php endif; ?>
        </aside>

        <!-- Copero edited section END-->  
        <?php else : ?> 
        <div id="main" role="main" class="main last clearfix">
        <jdoc:include type="message" />
        <jdoc:include type="component" />
        </div>   
        <?php endif; ?> 
    </div>
    <?php endif; ?>
    <nav id="menu" role="navigation" class="row clearfix"> <!-- main nav is here for usability and SEO reasons -->
    	<jdoc:include type="modules" name="menu" style="html5" />
    </nav> 
    <?php if ($bottomModules > 0) : ?>
    <div id="bottomRow" class="row clearfix">     
        <?php if($this->countModules('bottom1')) : ?>
        <div id="bottom1"> 
              <jdoc:include type="modules" name="bottom1" style="html5" />
        </div>
        <?php endif; ?>                    
        <?php if($this->countModules('bottom2')) : ?>
        <div id="bottom2">
              <jdoc:include type="modules" name="bottom2" style="html5" />
        </div>
        <?php endif; ?>                    
        <?php if($this->countModules('bottom3')) : ?>
        <div id="bottom3">
              <jdoc:include type="modules" name="bottom3" style="html5" />
        </div>
        <?php endif; ?>                 
        <?php if($this->countModules('bottom4')) : ?>
        <div id="bottom4">
              <jdoc:include type="modules" name="bottom4" style="html5" />
        </div>
        <?php endif; ?>
            <?php if($this->countModules('bottom5')) : ?>
        <div id="bottom5">
              <jdoc:include type="modules" name="bottom5" style="html5" />
        </div>
        <?php endif; ?>
        <?php if($this->countModules('bottom6')) : ?>
        <div id="bottom6">
              <jdoc:include type="modules" name="bottom6" style="html5" />
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <?php if ($footerModules > 0) : ?>
    <footer role="contentinfo" class="row clearfix">        
        <?php if($this->countModules('footer1')) : ?>
        <div id="footer1"> 
            <jdoc:include type="modules" name="footer1" style="html5" headerLevel="4" />
        </div>
        <?php endif; ?>                         
        <?php if($this->countModules('footer2')) : ?>
        <div id="footer2">
            <jdoc:include type="modules" name="footer2" style="html5" headerLevel="4" />
        </div>
        <?php endif; ?>	    
        <?php if($this->countModules('footer3')) : ?>
        <div id="footer3">
            <jdoc:include type="modules" name="footer3" style="html5" headerLevel="4" />
        </div>
        <?php endif; ?>		  
        <?php if($this->countModules('footer4')) : ?>
        <div id="footer4">
            <jdoc:include type="modules" name="footer4" style="html5" headerLevel="4"/>
        </div>
        <?php endif; ?>						
    </footer>
	<?php endif; ?>
</div>                                      
<footer id="creditRow" class="row clearfix">      
    <div id="creditRight"><a href="http://joomlafuture.com" title="OneWeb, a free, responsive, html5 template for Joomla! 2.5+">OneWeb</a>, a free Joomla! template from <a href="http://internet-inspired.com" title="Internet Inspired - Professional Joomla! Websmithing">Internet Inspired!</a> &copy; <?php echo date("Y"); ?></div>				
</footer>
<jdoc:include type="modules" name="debug"/>
<?php if ($scripts > 0) : ?>
<!-- Custom template scripts. Place your plugin code and script calls in the following two file and enable custom script loading in the template settings -->
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/scripts.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/plugins.js"></script>
<?php endif; ?>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/helper.js"></script>
<!-- iOS scale bug fix -->
<script>
MBP.scaleFix();
</script>
<?php if ($analytics != "UA-XXXXX-X") : ?>
<!-- http://mths.be/aab -->
<script>
var _gaq=[['_setAccount','<?php echo htmlspecialchars($analytics); ?>'],["_trackPageview"]];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
s.parentNode.insertBefore(g,s)}(document,"script"));
</script>
<?php endif; ?>
<noscript>JavaScript is unavailable or disabled; so you are probably going to miss out on a few things. Everything should still work, but with a little less pzazz!</noscript>
</body>
</html>

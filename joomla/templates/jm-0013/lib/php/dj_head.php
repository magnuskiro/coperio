<?php

/*--------------------------------------------------------------
# Copyright (C) joomla-monster.com
# License: http://www.joomla-monster.com/license.html Joomla-Monster Proprietary Use License
# Website: http://www.joomla-monster.com
# Support: info@joomla-monster.com
---------------------------------------------------------------*/

?>
<link href="<?php echo $dj_path;?>css/editor.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/modules.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/normal.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/menus.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $dj_path;?>css/menu-default.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo $jm_path;?>images/favicon.ico" />
<?php if($stylearea) { ?>
<link href="<?php echo $dj_path; ?>css/style<?php echo (isset($_COOKIE['jm_style_0013']) ? $_COOKIE['jm_style_0013'] : $template_color); ?>.css" rel="stylesheet" media="all" type="text/css" />
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="<?php echo $dj_path;?>css/style<?php echo $template_color ?>.css" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo $dj_path;?>css/<?php echo $template_width ?>.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="narrow" href="<?php echo $dj_path;?>css/narrow.css" />
<link rel="alternate stylesheet" type="text/css" media="screen" title="wide" href="<?php echo $dj_path;?>css/wide.css" />
<?php if($direction == 'rtl') { ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />
<?php } else { ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_ltr.css" type="text/css" />
<?php } ?>
<link rel="shortcut icon" href="<?php echo $dj_path;?>images/favicon.ico" />
<!--[if IE]>
	<link href="<?php echo $dj_path;?>css/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--[if IE 7]>
    <?php if($direction == 'rtl'): ?>
		<link href="<?php echo $dj_path;?>css/ie7_rtl.css" rel="stylesheet" type="text/css" />
	<?php endif; ?>
<![endif]-->
<script type="text/javascript">
	$template_path = '<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>';
</script>
<script language="javascript" type="text/javascript" src="<?php echo $dj_path;?>lib/js/template_scripts.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $dj_path;?>lib/js/doctextsizer.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $dj_path;?>lib/js/styleswitch.js"></script>
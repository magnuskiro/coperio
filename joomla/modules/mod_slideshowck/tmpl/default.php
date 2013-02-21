<?php
/**
 * @copyright	Copyright (C) 2012 Cedric KEIFLIN alias ced1870
 * http://www.joomlack.fr
 * Module Slideshow CK
 * @license		GNU/GPL
 * */
// no direct access
defined('_JEXEC') or die('Restricted access');

// définit la largeur du slideshow
$width = ($params->get('width') AND $params->get('width') != 'auto') ? ' style="width:'.$params->get('width').'px;"' : '';
?>
<!-- debut Slideshow CK -->
<div class="slideshowck<?php echo $params->get('moduleclass_sfx'); ?> camera_wrap <?php echo $params->get('skin'); ?>" id="camera_wrap_<?php echo $module->id; ?>"<?php echo $width; ?>>
	<?php foreach ($items as $item) {
       
        if ($item->imgalignment != 'default')  {
           $dataalignment = ' data-alignment="'.$item->imgalignment.'"';
        } else {
            $dataalignment = '';
        }
        $datarel = ($item->imgtarget == 'lightbox') ? 'data-rel="lightbox" ' : '';
        $datatime = ($item->imgtime) ? ' data-time="'.$item->imgtime.'"' : '';
        ?>
	<div <?php echo $datarel; ?>data-thumb="<?php echo $item->imgthumb; ?>" data-src="<?php echo $item->imgname; ?>" <?php if($item->imglink) echo 'data-link="'.$item->imglink.'" data-target="'.$item->imgtarget.'"'; echo $dataalignment . $datatime; ?>>
		<?php if ($item->imgvideo AND $item->slideselect == 'video') { ?>
                    <iframe src="<?php echo $item->imgvideo; ?>" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                <?php } 
                    if ($item->imgcaption || $item->article){
                    ?>
                <div class="camera_caption <?php echo $params->get('captioneffect','moveFromBottom'); ?>">
			<?php echo str_replace("|dq|","\"", $item->imgcaption); ?>
                        <?php if ($item->article) { 
                                 $articletitletag = $params->get('articletitle','h3');
                                 $articlelink = $params->get('articlelink','readmore');
                                 ?>
                                <<?php echo $articletitletag; ?> class="camera_caption_articletitle">
                                    <?php echo ($articlelink == 'title') ? '<a href="'.$item->article->link.'">'.$item->article->title.'</a>' : $item->article->title; ?>
                                </<?php echo $articletitletag; ?>>
                                <div class="camera_caption_articlecontent"><?php echo $item->article->text ?>
                                    <?php if ($articlelink == 'readmore') { ?>
                                    <a href="<?php echo $item->article->link ?>"><?php echo JText::_('COM_CONTENT_READ_MORE_TITLE') ?></a>
                                    <?php } ?>
                                </div>
                        <?php } ?>
		</div>
                <?php 
                    }
                ?>
	</div>
	<?php } ?>
</div>
<div style="clear:both;"></div>
<!-- fin Slideshow CK -->

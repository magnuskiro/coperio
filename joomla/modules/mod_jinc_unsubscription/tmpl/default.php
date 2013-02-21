<?php
isset($newsletter) || die('Newsletter not found');
isset($input_style) || die('Input Style not defined');

$front_theme = $newsletter->get('front_theme') . '.css';

$news_type = $newsletter->getType();

echo JHTML::stylesheet($front_theme, 'components/com_jinc/assets/themes/');
echo JHTML::script('components/com_jinc/assets/js/jinc.js');
echo JHTML::_('behavior.modal');
?>
<?php if ($params->get('pretext')): ?>
    <div class="jinc_mod_pretext">
        <p><?php echo $params->get('pretext'); ?></p>
    </div>
<?php endif; ?>

<form action="<?php echo JRoute::_('index.php'); ?>" method="post" onsubmit="return mod_checkForm(this);" id="jinc_form_<?php echo $id; ?>" name="jinc_form_<?php echo $id; ?>">
    <div class="jinc_mod_frm_subscription">
        <table width="100%" border="0">
            <?php
            jincimport('frontend.jincinputstandard');
            jincimport('frontend.jincinputminimal');

            $renderer = ($input_style == INPUT_STYLE_MINIMAL) ?
                    new JINCInputMinimal() : new JINCInputStandard();

            $renderer->preRender();
            if ($news_type == NEWSLETTER_PUBLIC_NEWS) {
                $attribute = new Attribute(-1);
                $attribute->set('name', 'user_mail');
                $attribute->set('type', ATTRIBUTE_TYPE_EMAIL);
                $attribute->set('name_i18n', 'COM_JINC_USERMAIL');

                $renderer->modRender($attribute, TRUE);
            }
            ?>

            <?php
            if ($newsletter->get('captcha') > CAPTCHA_NO) {
                $renderer->modCaptchaRender();
            }
            ?>


        </table>
        <br><br>
        <input type="submit" class="btn" value="<?php echo JText::_('COM_JINC_UNSUBSCRIBE'); ?>">
        <input type="hidden" name="option" value="com_jinc">
        <input type="hidden" name="task" value="newsletter.unsubscribe">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="mod_jinc" value="true">
        <?php echo JHTML::_('form.token'); ?>
    </div>
</form>
<?php if ($params->get('posttext')): ?>
    <div class="jinc_mod_posttext">
        <p><?php echo $params->get('posttext'); ?></p>
    </div>
<?php endif; ?>

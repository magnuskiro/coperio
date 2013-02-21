<?php
/**
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
isset($this->item) or die('Items not defined');
echo JHTML::_('behavior.modal');
echo JHTML::_('behavior.tooltip');

$item = $this->item;
$id = $item->id;
?>

<?php
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('SENDING_PREVIEW', 'SENDING_PREVIEW_TITLE');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jinc'); ?>" method="post" name="adminForm" id="preview-form" class="form-validate">
    <div class="width-100 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_JINC_PREVIEW_TO'); ?></legend>
            <ul class="adminformlist">
                <li>
                    <label id="to_yourself-lbl" for="to_yourself" class="hasTip" title="<?php echo JText::_('COM_JINC_PREVIEW_TO_YOURSELF'); ?>"><?php echo JText::_('COM_JINC_PREVIEW_TO_YOURSELF_DESC'); ?></label>
                    <input type="checkbox" name="to_yourself" id="to_yourself" checked />
                </li>
                <li>
                    <label id="to_addresses-lbl" for="to_addresses" class="hasTip" title="<?php echo JText::_('COM_JINC_PREVIEW_TO_ADDRESSES_DESC'); ?>"><?php echo JText::_('COM_JINC_PREVIEW_TO_ADDRESSES'); ?></label>
                    <input type="text" value="" id="to_addresses" name="to_addresses" maxlength="256" size="64" />
                </li>
                <br><br><br><br>
                <li>
                    <input type="submit" value="<?php echo JText::_('COM_JINC_PREVIEW_BTN'); ?>" />
                </li>            
            </ul>
        </fieldset>

        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="task" value="message.preview" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>


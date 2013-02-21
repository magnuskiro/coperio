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
?>
<?php
jincimport('utility.jinchtmlhelper');
$csv_format = isset($this->csv_format) ? $this->csv_format : array();
$csv_string = '<br><strong>' . implode(', ', $csv_format) . '<strong>';
JINCHTMLHelper::hint('ADD_SUBSCRIBER', 'ADD_SUBSCRIBER_TITLE');
$news_id = isset($this->news_id) ? $this->news_id : 0;
?>



<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <form action="index.php" method="GET" name="adminForm">
            <table cellspacing="5px" align="center" width="60%">
                <tr>
                    <td width="50%">
                        <strong>
                            <?php echo $this->form->getLabel('id'); ?>
                        </strong>
                    </td>
                    <td width="50%" align="right">
                        <?php echo $this->form->getInput('id'); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="<?php echo JText::_('COM_JINC_LOAD_FIELDS'); ?>">
                    </td>
                </tr>
            </table>
            <input type="hidden" name="option" value="com_jinc">
            <input type="hidden" name="view" value="newsletter">
            <input type="hidden" name="tmpl" value="component">
            <input type="hidden" name="layout" value="addsubscriber">
        </form>

    </div>

    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>
<br>
<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>
    <div class="m">
        <div id="editcell">
            <?php
            if (count($csv_format) > 0) {
                ?>

                <form action="index.php" method="post" name="addSubscriberForm" id="testForm">
                    <table cellspacing="5px" align="center" width="60%">
                        <?php
                        foreach ($csv_format as $key => $value) {
                            echo '<tr>';
                            echo '<td width="50%">' . $value . '</td>';
                            echo '<td>';
                            echo '<input type="text" name="csvtemp[' . $value . ']" id="csvtemp[' . $value . ']" size="50" />';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="2" align="center">                
                                <input type="submit" value="<?php echo JText::_('COM_JINC_BTN_ADDSUBSCRIBER'); ?>">
                            </td>
                        </tr>

                    </table>
                    <input type="hidden" name="type" value="manual">
                    <input type="hidden" name="option" value="com_jinc" />
                    <input type="hidden" name="task" value="newsletter.import">
                    <input type="hidden" name="id" value="<?php echo $news_id; ?>">
                </form>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="b">
        <div class="b">
            <div class="b"></div>
        </div>
    </div>
</div>







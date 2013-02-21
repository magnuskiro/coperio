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
echo JHTML::_('behavior.modal');
?>
<?php
isset($this->report) or die('Report not defined');
$report = $this->report;

jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('TAGS_REPORT', 'TAGS_REPORT_TITLE');

JHTML::stylesheet('administrator/components/com_jinc/assets/css/jinc_admin.css');
?>
<div id="element-box">
    <div class="t">
        <div class="t">
            <div class="t"></div>
        </div>
    </div>

    <div id="element-box">
        <div class="t">
            <div class="t">
                <div class="t"></div>
            </div>
        </div>
        <div class="m">
            <div id="editcell">
                <table class="adminlist" id="attrTable">
                    <thead>
                        <tr>
                            <th width="40%">
                                <?php echo JText::_('COM_JINC_MAIL_ADDRESS'); ?>
                            </th>
                            <th width="20%">
                                <?php echo JText::_('COM_JINC_ERROR_CODE'); ?>
                            </th>
                            <th width="40%">
                                <?php echo JText::_('COM_JINC_ERROR_MSG'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($report as $srep) {
                            echo '<tr>';
                            foreach ($srep as $key => $value) {
                                $error_code = 'COM_JINC_REP' . str_pad($value, 3, "0", STR_PAD_LEFT);
                                echo '<td>';
                                echo $key;
                                echo '</td>';
                                echo '<td>';
                                if (intval($value) != 0)
                                    echo $error_code;
                                echo '</td>';
                                echo '<td>';
                                echo JText::_($error_code);
                                echo '</td>';
                            }
                            echo '</tr>';

                            echo '<br>';
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="b">
            <div class="b">
                <div class="b"></div>
            </div>
        </div>
    </div>
</div>

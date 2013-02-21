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
JHTML::script('administrator/components/com_jinc/assets/js/phplivex.js');
jincimport('utility.PHPLiveX');
?>

<script type="text/javascript">
    var client_id = '0';

    function deleteReport(proc_id) {
        var plx = new PHPLiveX();
        return plx.ExternalRequest({
            'content_type': 'json',
            'url': 'index.php?option=com_jinc&task=messagejson.deleteReport&format=json',
            'onFinish': function(response){
                var status = response.status;

                if (status >= 0) {
                    var btnShowReport   = document.getElementById("btnShowReport_" + proc_id);
                    var btnDeleteReport = document.getElementById("btnDeleteReport_" + proc_id);
                    btnShowReport.disabled = true;
                    btnDeleteReport.disabled = true;
                    alert('<?php echo JText::_('COM_JINC_DELETE_REPORT_JS'); ?>');
                } else {
                    alert('<?php echo JText::_('COM_JINC_ERROR_DELETE_REPORT_JS'); ?>');
                }
            },
            'params':{'proc_id': proc_id}
        });
    }

</script>

<?php
isset($this->history) or die('History not defined');
$history = $this->history;

jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('MESSAGE_HISTORY', 'MESSAGE_HISTORY_TITLE');

$nhist = count($history);
if ($nhist == 0) {
    echo '<strong>' . JText::_('COM_JINC_NO_HISTORY') . '</strong>';
}

for ($i = 0; $i < $nhist; $i++) {
    $process = $history[$i];
    ?>
    <div class="sending">
        <table align="center" width="55%" border=0 class="adminlist">
            <thead>
                <tr>
                    <td width="100%" colspan="4" align="center">
                        <strong><?php echo JText::_('COM_JINC_REPORT_DATA') . ' (' . ($nhist - $i) . ')'; ?></strong>
                    </td>
                </tr>
            </thead>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_START_TIME'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <?php echo date('r', $process->get('start_time')); ?>
                    </strong>
                </td>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_END_TIME'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <?php echo date('r', $process->get('last_update_time')); ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_TOT_RECIPIENTS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <?php echo $process->get('sent_messages'); ?>
                    </strong>
                </td>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_SENT_SUCCESS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <?php echo $process->get('sent_success'); ?>
                    </strong>
                </td>
            </tr>
            <tr>
                <?php
                $disabled = ($process->get('has_report')) ? '' : 'disabled';
                ?>
                <td width="50%" align="right" colspan="2">
                    <a class="modal" href="<?php echo JRoute::_('index.php?option=com_jinc&view=message&tmpl=component&layout=report&proc_id=' . $process->get('id')); ?>" 
                       rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
                        <button <?php echo $disabled; ?> type="button" onclick="" id="btnShowReport_<?php echo $process->get('id'); ?>"><?php echo JText::_('COM_JINC_SHOW_REPORT'); ?></button>
                    </a> 
                </td>
                <td width="50%" align="rigth" colspan="2">
                    <button <?php echo $disabled; ?> type="button" id="btnDeleteReport_<?php echo $process->get('id'); ?>" onClick="deleteReport(<?php echo $process->get('id'); ?>);">Discard</button>
                </td>
            </tr>
        </table>
    </div>
    <br><br>
    <?php
}
?>
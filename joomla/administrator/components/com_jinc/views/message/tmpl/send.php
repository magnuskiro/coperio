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

$background = JURI::base() . 'components/com_jinc/assets/images/progress/violet_back.gif';
$foreground = JURI::base() . 'components/com_jinc/assets/images/progress/violet.gif';
// PHPLiveX including files
JHTML::script('administrator/components/com_jinc/assets/js/phplivex.js');
jincimport('utility.PHPLiveX');
?>

<script type="text/javascript">
    var client_id = '0';

    function getStatusString(status) {
        switch(status) {
            case "<?php echo PROCESS_STATUS_RUNNING; ?>":
                    return "<?php echo JText::_('COM_JINC_RUNNING'); ?>";
                break;
            case "<?php echo PROCESS_STATUS_PAUSED; ?>":
                    return "<?php echo JText::_('COM_JINC_PAUSED'); ?>";
                break;
            case "<?php echo PROCESS_STATUS_FINISHED; ?>":
                    return "<?php echo JText::_('COM_JINC_FINISHED'); ?>";
                break;
            case "<?php echo PROCESS_STATUS_STOPPED; ?>":
                    return "<?php echo JText::_('COM_JINC_STOPPED'); ?>";
                break;
            default:
                return "";
            }
        }

        function clearBar() {
            var progressBarField = document.getElementById('progressBar');
            progressBarField.innerHTML = "0%";
            for (i = 0; i < 100; i++)
                eval("document.img" + i + ".src=dots[0].src");
        }

        function updateBar(progress) {
            clearBar();
            var progressBarField = document.getElementById('progressBar');
            progressBarField.innerHTML = progress + "%";
            for (i = 0; i < progress && i < 100; i++)
                eval("document.img" + i + ".src=dots[1].src");
        }

        function setError(errcode, errmsg, mailsyserrmsg) {           
            if (typeof(errcode) != "undefined") {                
                errorCodeField = document.getElementById('errorCode');
                errorCodeField.innerHTML = "<strong>";
                errorCodeField.innerHTML += errcode;
                errorCodeField.innerHTML += "<strong>";
                
                errorMsgField = document.getElementById('errorMsg');
                errorMsgField.innerHTML = "<strong>";
                errorMsgField.innerHTML += errmsg;
                errorMsgField.innerHTML += "<strong>";
                
                if (typeof(mailsyserrmsg) != "undefined") {
                    if (mailsyserrmsg != "") {
                        mailSysErrorMsgField = document.getElementById('mailSysErrorMsg');
                        mailSysErrorMsgField.innerHTML = "<strong>";
                        mailSysErrorMsgField.innerHTML += mailsyserrmsg;
                        mailSysErrorMsgField.innerHTML += "<strong>";
                    }
                }            
            }
        }

        function updateClientId () {
            var nowdate = new Date();
            client_id = nowdate.getTime() + "_" + Math.ceil(Math.random() * 10000);
        }

        function inProgress() {
            alert('<?php echo JText::_('COM_JINC_JS_INPROGRESS'); ?>');
        }

        function sendMessage() {
            id = '<?php echo isset($this->id) ? $this->id : ''; ?>';
            var nowdate = new Date();
            var rand_num = Math.ceil(Math.random() * 10000);
            var cache_id = nowdate.getTime() + "_" + rand_num;            
            var continue_on_error = document.getElementById('continue_on_error').checked;
            var btnShowReport = document.getElementById("btnShowReport");
            btnShowReport.disabled = true;
            
            var plx = new PHPLiveX();
            document.getElementById('btnPlay').onClick = '';
            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play_disabled.png';
            return plx.ExternalRequest({
                'content_type': 'json',
                'url': 'index.php?option=com_jinc&task=messagejson.send&format=json',
                'onFinish': function(response){
                    var status            = response.status;

                    if (status >= 0) {
                        var tot_recipients       = response.tot_recipients;
                        var sent_messages        = response.sent_messages;
                        var sent_success         = response.sent_success;
                        var last_subscriber_time = response.sent_messages;
                        var server_time          = response.server_time;
                        var start_time           = response.start_time;
                        var mail_system_error    = response.mail_system_error;                       
                        var proc_id              = response.proc_id;
                        
                        setError('', '', mail_system_error);
                        statusField    = document.getElementById('status');
                        startTimeField = document.getElementById('startTime');
                        statusField.innerHTML    = getStatusString(status);
                        startTimeField.innerHTML = start_time;

                        if (status == <?php echo PROCESS_STATUS_RUNNING; ?>) {
                            progress = 0;
                            if (tot_recipients > 0) progress = Math.round(sent_messages/tot_recipients * 100);
                            updateBar(progress);
                            lastResponseField = document.getElementById('lastResponse');
                            lastResponseField.innerHTML = server_time;

                            sentMessagesField = document.getElementById('sentMessages');
                            sentSuccessField = document.getElementById('sentSuccess');
                            totRecipientsField = document.getElementById('totRecipients');

                            sentMessagesField.innerHTML = sent_messages;
                            sentSuccessField.innerHTML = sent_success;
                            totRecipientsField.innerHTML = tot_recipients;

                            sendMessage();
                        } else {
                            document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';
                            var lnkShowReport = document.getElementById("lnkShowReport");                            
                            lnkShowReport.href = 'index.php?option=com_jinc&view=message&tmpl=component&layout=report&proc_id=';
                            lnkShowReport.href += proc_id;
                            btnShowReport.disabled = false;
                        }

                    } else {
                        setError(response.errcode, response.errmsg, response.mail_system_error);
                        document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                        document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';
                        if (continue_on_error) sendMessage();
                    }
                },
                'params':{'id': id, 'cache_id': cache_id, 'client_id': client_id, 'continue_on_error': continue_on_error}
            });
        }

        function pause() {
            setError('', '');
            id = '<?php echo isset($this->id) ? $this->id : ''; ?>';
            var nowdate = new Date();
            var rand_num = Math.ceil(Math.random() * 10000);
            var cache_id = nowdate.getTime() + "_" + rand_num;
            var plx = new PHPLiveX();
            return plx.ExternalRequest({
                'content_type': 'json',
                'url': 'index.php?option=com_jinc&task=messagejson.pause&format=json',
                'onFinish': function(response){
                    var status            = response.status;

                    statusField    = document.getElementById('status');
                    if (typeof(status) != "undefined")
                        statusField.innerHTML    = getStatusString(status);

                    if (status >= 0) {
                        if (status == <?php echo PROCESS_STATUS_RUNNING; ?>) {
                            document.getElementById('btnPlay').onClick = '';
                            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play_disabled.png';
                        } else {
                            document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';
                        }

                    } else {
                        setError(response.errcode, response.errmsg);
                        document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                        document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';

                    }
                },
                'params':{'id': id, 'cache_id': cache_id}
            });
        }

        function stop() {
            setError('', '');
            id = '<?php echo isset($this->id) ? $this->id : ''; ?>';
            var nowdate = new Date();
            var rand_num = Math.ceil(Math.random() * 10000);
            var cache_id = nowdate.getTime() + "_" + rand_num;
            var plx = new PHPLiveX();
            return plx.ExternalRequest({
                'content_type': 'json',
                'url': 'index.php?option=com_jinc&task=messagejson.stop&format=json',
                'onFinish': function(response){
                    var status            = response.status;

                    statusField    = document.getElementById('status');
                    if (typeof(status) != "undefined")
                        statusField.innerHTML    = getStatusString(status);

                    if (status >= 0) {
                        if (status == <?php echo PROCESS_STATUS_RUNNING; ?>) {
                            document.getElementById('btnPlay').onClick = '';
                            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play_disabled.png';
                        } else {
                            document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                            document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';
                            clearBar();
                        }
                    } else {
                        setError(response.errcode, response.errmsg);
                        document.getElementById('btnPlay').onClick = "javascript:updateClientId();sendMessage();";
                        document.getElementById('btnPlay').src = 'components/com_jinc/assets/images/icons/play.png';

                    }
                },
                'params':{'id': id, 'cache_id': cache_id}
            });
        }

        function back() {
            pause();
            window.location = "index.php?option=com_jinc&controller=message&view=messages";
        }
</script>
<?php
jincimport('utility.jinchtmlhelper');
JINCHTMLHelper::hint('SENDING_PROCESS', 'SENDING_PROCESS_TITLE');
?>
<br>
<div class="sending">
    <center>
        <table align="center" width="35%" border=0 class="adminlist">
            <thead>
                <tr>
                    <td width="100%" colspan="4" align="center">
                        <strong><?php echo JText::_('COM_JINC_LAST_RESPONSE_TIME'); ?></strong>
                    </td>
                </tr>
            </thead>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_STATUS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='status'>
                            <?php
                            if (isset($this->proc_status)) {
                                switch ($this->proc_status) {
                                    case PROCESS_STATUS_FINISHED:
                                        echo JText::_('COM_JINC_FINISHED');
                                        break;

                                    case PROCESS_STATUS_PAUSED:
                                        echo JText::_('COM_JINC_PAUSED');
                                        break;

                                    case PROCESS_STATUS_RUNNING:
                                        echo JText::_('COM_JINC_RUNNING');
                                        break;

                                    case PROCESS_STATUS_STOPPED:
                                        echo JText::_('COM_JINC_STOPPED');
                                        break;

                                    default:
                                        break;
                                }
                            }
                            ?>
                        </span>
                    </strong>
                </td>

                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_SENT_MESSAGES'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='sentMessages'>
                            <?php echo isset($this->proc_sent_messages) ? $this->proc_sent_messages : ''; ?>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_LAST_RESPONSE'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='lastResponse'>
                        </span>
                    </strong>
                </td>

                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_SENT_SUCCESS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='sentSuccess'>
                            <?php echo isset($this->proc_sent_success) ? $this->proc_sent_success : ''; ?>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_START_TIME'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='startTime'>
                            <?php echo isset($this->proc_start_time) ? $this->proc_start_time : ''; ?>
                        </span>
                    </strong>
                </td>

                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_TOT_RECIPIENTS'); ?>
                </td>
                <td width="25%" align="right">
                    <strong>
                        <span id='totRecipients'>
                            <?php echo isset($this->proc_tot_recipients) ? $this->proc_tot_recipients : ''; ?>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_ERROR_CODE'); ?>
                </td>
                <td align="left" colspan="3">
                    <strong>
                        <span id='errorCode'>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_ERROR_MSG'); ?>
                </td>
                <td align="left" colspan="3">
                    <strong>
                        <span id='errorMsg'>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_ERROR_MAIL_SYSTEM'); ?>
                </td>
                <td align="left" colspan="3">
                    <strong>
                        <span id='mailSysErrorMsg'>
                        </span>
                    </strong>
                </td>
            </tr>

            <tr>
                <td width="25%" align="left">
                    <?php echo JText::_('COM_JINC_SENDING_OPTIONS'); ?>
                </td>
                <td align="left">
                    <input type="checkbox" name="continue_on_error" id="continue_on_error">
                    <?php echo JText::_('COM_JINC_SENDING_CONTINUE_ON_ERROR'); ?>
                    </input>
                </td>
                <td align="left" colspan="2">
                    <a id="lnkShowReport" class="modal" href="index.php" 
                       rel="{handler: 'iframe', size: {x: 875, y: 550}, onClose: function() {}}">
                        <button disabled type="button" id="btnShowReport"><?php echo JText::_('COM_JINC_SHOW_REPORT'); ?></button>
                    </a>
                </td>
            </tr>                
        </table>

        <br><br>

        <?php echo JText::_('COM_JINC_PROGRESS'); ?> <span id='progressBar'>0%</span><br>

        <script language="JavaScript1.1" type="text/javascript">

                var lengthOfPreloadBar = 750;
                var heightOfPreloadBar = 20;
                var nimages = 100;

                if (document.images) {
                    var dots = new Array();
                    dots[0] = new Image(1,1);
                    dots[0].src = "<?php echo $background; ?>";
                    dots[1] = new Image(1,1);
                    dots[1].src = "<?php echo $foreground; ?>";
                    var coverage = Math.floor(lengthOfPreloadBar/nimages);
                    var currCount = 0;
                    var timerID, leftOverWidth = lengthOfPreloadBar%coverage;

                    var preloadBar = '';
                    for (i = 0; i < nimages - 1; i++) {
                        preloadBar += '<img src="' + dots[0].src + '" width="' + coverage + '" height="' + heightOfPreloadBar + '" name="img' + i + '" align="absmiddle">';
                    }
                    preloadBar += '<img src="' + dots[0].src + '" width="' + (leftOverWidth+coverage) + '" height="' + heightOfPreloadBar + '" name="img' + (nimages - 1) + '" align="absmiddle">';
                    document.write(preloadBar);
                }
        </script>
        <br><br>

        <table align="center" width="50%" cellspacing="15px">
            <tr>
                <td align="center">
                    <div class="jinc_send">
                        <img title="<?php echo JText::_('COM_JINC_PLAY'); ?>" id="btnPlay" width="48px" src="components/com_jinc/assets/images/icons/play.png" alt="play" onClick="updateClientId(); sendMessage();">
                    </div>
                </td>
                <td align="center">
                    <div class="jinc_send">
                        <img title="<?php echo JText::_('COM_JINC_PAUSE'); ?>" id="btnPause" width="48px" src="components/com_jinc/assets/images/icons/pause.png" alt="play" onClick="pause();">
                    </div>
                </td>
                <td align="center">
                    <div class="jinc_send">
                        <img title="<?php echo JText::_('COM_JINC_STOP'); ?>" id="btnStop" width="48px" src="components/com_jinc/assets/images/icons/stop.png" alt="play" onClick="stop();">
                    </div>
                </td>
                <td align="center">
                    <div class="jinc_send">
                        <img title="<?php echo JText::_('COM_JINC_BACK'); ?>" id="btnBack" width="48px" src="components/com_jinc/assets/images/icons/back.png" alt="play" onClick="back();">
                    </div>
                </td>
            </tr>
        </table>
    </center>
</div>
<script type="text/javascript">
        clearBar();

        tot_recipients = <?php echo isset($this->proc_tot_recipients) ? $this->proc_tot_recipients : 0; ?>;
        sent_messages = <?php echo isset($this->proc_sent_messages) ? $this->proc_sent_messages : 0; ?>;

        if (tot_recipients > 0) updateBar( Math.round(sent_messages/tot_recipients * 100) );
</script>

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
defined('_JEXEC') or die();

jimport('joomla.application.component.controllerform');

class JINCControllerMessage extends JControllerForm {

    function __construct() {
        parent::__construct();
    }

    protected function allowSend($data = array(), $key = 'news_id') {
        // Initialise variables.
        $recordId = (int) isset($data->$key) ? $data->$key : 0;
        $user = JFactory::getUser();
        $userId = $user->get('id');

        // Check general edit permission first.
        if ($user->authorise('jinc.send', 'com_jinc.newsletter.' . $recordId)) {
            return true;
        }

        return false;
    }

    function previewPage($key = null, $urlVar = null) {
        $cid = JRequest::getVar('cid', array(), 'post', 'array');

        if (count($cid) < 1) {
            $this->setError(JText::_('COM_JINC_ERR002'));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect('index.php?option=com_jinc&controller=message&view=messages', $msg);
            return false;
        }

        $id = (int) $cid[0];
        $this->setRedirect('index.php?option=com_jinc&view=message&layout=preview&id=' . $id, $msg);
        return true;
    }

    function preview($key = null, $urlVar = null) {
        $model = $this->getModel();
        $table = $model->getTable();
        $id = JRequest::getInt('id', 0);
        $to_yourself = JRequest::getString('to_yourself', 'off');
        $yourself = (strtolower($to_yourself) == 'on');
        $to_addresses = JRequest::getString('to_addresses', '');
        $to_addresses = str_replace(' ', '', $to_addresses);

        jincimport('utility.inputchecker');
        $addresses = explode(',', $to_addresses);
        foreach (array_reverse($addresses, true) as $key => $email) {
            if (!InputChecker::checkMail($email)) {
                unset($addresses[$key]);
            }
        }
        if (empty($key))
            $key = $table->getKeyName();
        if (empty($urlVar))
            $urlVar = $key;

        $result = $model->preview($id, $yourself, $addresses);
        if ($result === false) {
            $this->setError(JText::sprintf('COM_JINC_ERR001', JText::_($model->getError())));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect('index.php?option=com_jinc&view=message&layout=preview&tmpl=component&id=' . $id, $msg);
            return false;
        }

        $tostring = (count($result) > 0) ? implode(',', $result) : JText::_('COM_JINC_ANYONE');
        $msg = JText::sprintf('COM_JINC_INF002', $tostring);

        $this->setRedirect('index.php?option=com_jinc&view=message&layout=preview&id=' . $id, $msg);
        return true;
    }

    function sendPage($key = null, $urlVar = null) {
        $model = $this->getModel();
        $table = $model->getTable();
        $cid = JRequest::getVar('cid', array(), 'post', 'array');

        if (empty($key))
            $key = $table->getKeyName();
        if (empty($urlVar))
            $urlVar = $key;

        if (count($cid) < 1) {
            $this->setError(JText::_('COM_JINC_ERR002'));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect('index.php?option=com_jinc&controller=message&view=messages', $msg);
            return false;
        }

        $recordId = (int) $cid[0];
        $data = $model->getItem($recordId);
        if ($this->allowSend($data) === false) {
            $this->setError(JText::_('COM_JINC_ERR003'));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect('index.php?option=com_jinc&controller=message&view=messages', $msg);
            return false;
        }

        $this->setRedirect('index.php?option=com_jinc&view=message&layout=send&id=' . $recordId);
        return true;
    }

    function history($key = null, $urlVar = null) {
        $model = $this->getModel();
        $table = $model->getTable();
        $cid = JRequest::getVar('cid', array(), 'post', 'array');

        if (empty($key))
            $key = $table->getKeyName();
        if (empty($urlVar))
            $urlVar = $key;

        if (count($cid) < 1) {
            $this->setError(JText::_('COM_JINC_ERR002'));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect('index.php?option=com_jinc&controller=message&view=messages', $msg);
            return false;
        }

        $recordId = (int) $cid[0];
        $this->setRedirect('index.php?option=com_jinc&view=message&layout=history&id=' . $recordId);
    }

}

?>

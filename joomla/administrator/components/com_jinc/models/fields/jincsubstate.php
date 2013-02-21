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

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldJINCSubState extends JFormField {

    protected $type = 'JINCSubState';

    protected function getInput() {
        return "";
    }

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    public function getOptions() {
        // Initialize variables.
        $options = array();
        $option1 = new stdClass();
        $option1->value = 0;
        $option1->text = JText::_('COM_JINC_SUBSCRIBED');

        $option2 = new stdClass();
        $option2->value = 1;
        $option2->text = JText::_('COM_JINC_WAITING_OPTIN');

        $options[] = $option1;
        $options[] = $option2;

        return $options;
    }

}

?>
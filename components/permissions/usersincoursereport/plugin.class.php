<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Configurable Reports
 * A Moodle block for creating customizable reports
 *
 * @package  block_configurablereports
 * @author   Juan leyva <http://www.twitter.com/jleyvadelgado>
 * @date     2009
 */
defined('MOODLE_INTERNAL') || die;
require_once($CFG->dirroot . '/blocks/configurable_reports/plugin.class.php');

/**
 * Class plugin_usersincoursereport
 *
 * @package  block_configurablereports
 * @author   Juan leyva <http://www.twitter.com/jleyvadelgado>
 * @date     2009
 */
class plugin_usersincoursereport extends plugin_base {

    /**
     * Init
     *
     * @return void
     */
    public function init(): void {
        $this->form = false;
        $this->unique = true;
        $this->fullname = get_string('usersincoursereport', 'block_configurable_reports');
        $this->reporttypes = ['courses', 'sql', 'users', 'timeline', 'categories'];
    }

    /**
     * Summary
     *
     * @param object $data
     * @return string
     */
    public function summary(object $data): string {
        return get_string('usersincoursereport_summary', 'block_configurable_reports');
    }

    /**
     * execute
     *
     * @param int $userid
     * @param $context
     * @param $data
     * @return bool
     */
    public function execute(int $userid, $context, $data) {

        // Everyone should be enrolled at the system level.
        if ($context === context_system::instance()) {
            return true;
        }

        return is_enrolled($context, $userid);
    }

}

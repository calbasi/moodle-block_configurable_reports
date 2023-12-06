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
 * Class plugin_categoryfield
 *
 * @package  block_configurablereports
 * @author   Juan leyva <http://www.twitter.com/jleyvadelgado>
 * @date     2009
 */
class plugin_categoryfield extends plugin_base {

    /**
     * @return void
     */
    public function init(): void {
        $this->fullname = get_string('categoryfield', 'block_configurable_reports');
        $this->type = 'undefined';
        $this->form = true;
        $this->reporttypes = ['categories'];
    }

    /**
     * Summary
     *
     * @param object $data
     * @return string
     */
    public function summary(object $data): string {
        return format_string($data->columname);
    }

    public function colformat($data) {
        $align = $data->align ?? '';
        $size = $data->size ?? '';
        $wrap = $data->wrap ?? '';

        return [$align, $size, $wrap];
    }

    // Data -> Plugin configuration data.
    // Row -> Complet course row c->id, c->fullname, etc...
    public function execute($data, $row, $user, $courseid, $starttime = 0, $endtime = 0) {
        global $DB;

        if (isset($row->{$data->column})) {
            switch ($data->column) {
                case 'timemodified':
                    $row->{$data->column} = ($row->{$data->column}) ? userdate($row->{$data->column}) : '--';
                    break;
                case 'visible':
                    $row->{$data->column} = ($row->{$data->column}) ? get_string('yes') : get_string('no');
                    break;

                case 'parent':
                    $row->{$data->column} = $DB->get_field('course_categories', 'name', ['id' => $row->{$data->column}]);
                    break;
            }
        }

        return (isset($row->{$data->column})) ? $row->{$data->column} : '';
    }

}

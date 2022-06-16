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
 * Form for editing HTML block instances.
 *
 * @package   block_updata_info
 * @copyright 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
//require_once($CFG->dirroot . '/user/profile/lib.php');

use Kily\Tools1C\OData\Client;

require __DIR__.'/vendor/autoload.php';
include_once(dirname(dirname(dirname(__FILE__))) . '/user/profile/lib.php');

class block_updata_info extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_updata_info');

    }

    function get_content()
    {
        global $DB, $USER, $OUTPUT, $CFG;

        if ($this->content !== NULL) {
            return $this->content;
        }


        $this->content = new stdClass;
    //     $this->content->text = '<table>
    //     <colgroup>
    //       <col span="2">
    //       <col style="background-color:#97DB9A;">
    //       <col style="width:42px;">
    //       <col style="background-color:#97DB9A;">
    //       <col style="background-color:#DCC48E; border:4px solid #C1437A;">
    //       <col span="2" style="width:42px;">
    //     </colgroup>
    //     <tr>
    //       <td>Предмет/семестр</td>
    //       <th>1 </th>
    //       <th>2 </th>
    //       <th>3 </th>
    //       <th>4 </th>
    //       <th>5 </th>
    //       <th>6 </th>
    //       <th>7 </th>
    //       <th>8 </th>
    //     </tr>
    //     <tr>
    //       <th>Матанализ</th>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>German</td>
    //       <td>Dutch</td>
    //       <td>English</td>
    //       <td>English</td>
    //     </tr>
    //     <tr>
    //       <th>Диффуры</th>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>English;</td>
    //       <td>German</td>
    //       <td>Dutch</td>
    //       <td>English</td>
    //       <td>English</td>
    //     </tr>
    //     <tr>
    //       <th>Теория вероятноси</th>
    //       <td>English</td>
    //       <td>German</td>
    //       <td>English</td>
    //       <td>German</td>
    //       <td>Dutch</td>
    //       <td>English</td>
    //       <td>English</td>
    //     </tr>
    //     <tr>
    //       <th>Экономика</th>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>English</td>
    //       <td>Dutch</td>
    //       <td>English</td>
    //       <td>English</td>
    //     </tr>
    //   </table>';

        $id = $USER->id;
        $firstname = $USER->firstname;
        $lastname = $USER->lastname;
        $profile_field_educationlevel = $USER->profile_field_educationlevel;
        $profile_field_kodnapravleniya = $USER->profile_field_kodnapravleniya;
        $profile_field_napravleniepodgotovki = $USER->profile_field_napravleniepodgotovki; 
        $profile_field_napravlennost = $USER->profile_field_napravlennost;
        $profile_field_educationform = $USER->profile_field_educationform;
        $profile_field_faculty = $USER->profile_field_faculty;
        $profile_field_course = $USER->profile_field_course;
        $profile_field_gruppa = $USER->profile_field_gruppa;
        $profile_field_zachetka = $USER->profile_field_zachetka;
        $profile_field_yearofenter = $USER->profile_field_yearofenter;   

        $this->content->text = 
        $id . "<br>" . $firstname . "<br>" . $lastname . "<br>" . $profile_field_educationlevel . "<br>" . $profile_field_kodnapravleniya . "<br>" . 
        $profile_field_napravleniepodgotovki . "<br>" . $profile_field_napravlennost . "<br>" . 
        $profile_field_educationform . "<br>" . $profile_field_faculty . "<br>" . 
        $profile_field_course . "<br>" . $profile_field_gruppa . "<br>" . 
        $profile_field_zachetka . "<br>" . $profile_field_yearofenter . "<br>" ;

    // foreach ($USER as $key){
    //     $this->content->text .="<li>";
    //     $this->content->text .=$USER->id;
    //     $this->content->text .=" - ";
    //     // $this->content->text .=$value;
    //     $this->content->text .="</li>";            
    // } 

        return $this->content;
    }



}

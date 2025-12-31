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
 * This file defines settingpages and externalpages under the "courses" category
 *
 * @package core
 * @copyright 2002 onwards Martin Dougiamas (http://dougiamas.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/pdflib.php');

use core_admin\local\settings\filesize;

$capabilities = array(
    'moodle/backup:backupcourse',
    'moodle/category:manage',
    'moodle/course:create',
    'moodle/site:approvecourse',
    'moodle/restore:restorecourse'
);
if ($hassiteconfig or has_any_capability($capabilities, $systemcontext)) {
    // Speedup for non-admins, add all caps used on this page.
    $ADMIN->add('courses',
        new admin_externalpage('coursemgmt', new lang_string('coursemgmt', 'admin'),
            $CFG->wwwroot . '/course/management.php',
            array('moodle/category:manage', 'moodle/course:create')
        )
    );
    $ADMIN->add('courses',
        new admin_externalpage('addcategory', new lang_string('addcategory', 'admin'),
            new moodle_url('/course/editcategory.php', array('parent' => 0)),
            array('moodle/category:manage')
        )
    );
    $ADMIN->add('courses',
        new admin_externalpage('addnewcourse', new lang_string('addnewcourse'),
            new moodle_url('/course/edit.php', array('category' => 0)),
            array('moodle/category:manage')
        )
    );

    // Required includes
    require_once($CFG->dirroot.'/course/lib.php');

    // =====================================================
    // DISABLED SECTIONS - Commented out as requested
    // =====================================================

    // Restore course - DISABLED
    // $ADMIN->add('courses',
    //     new admin_externalpage('restorecourse', new lang_string('restorecourse', 'admin'),
    //         new moodle_url('/backup/restorefile.php', array('contextid' => context_system::instance()->id)),
    //         array('moodle/restore:restorecourse')
    //     )
    // );

    // Download course content - DISABLED
    // $downloadcoursedefaulturl = new moodle_url('/admin/settings.php', ['section' => 'coursesettings']);
    // $temp = new admin_settingpage('downloadcoursecontent', new lang_string('downloadcoursecontent', 'course'));
    // $temp->add(new admin_setting_configcheckbox('downloadcoursecontentallowed',
    //         new lang_string('downloadcoursecontentallowed', 'admin'),
    //         new lang_string('downloadcoursecontentallowed_desc', 'admin', $downloadcoursedefaulturl->out()), 0));
    // $defaultmaxdownloadsize = 50 * filesize::UNIT_MB;
    // $temp->add(new filesize('maxsizeperdownloadcoursefile', new lang_string('maxsizeperdownloadcoursefile', 'admin'),
    //         new lang_string('maxsizeperdownloadcoursefile_desc', 'admin'), $defaultmaxdownloadsize, filesize::UNIT_MB));
    // $temp->hide_if('maxsizeperdownloadcoursefile', 'downloadcoursecontentallowed');
    // $ADMIN->add('courses', $temp);

    // Course request - DISABLED
    // $temp = new admin_settingpage('courserequest', new lang_string('courserequest'));
    // $temp->add(new admin_setting_configcheckbox('enablecourserequests',
    //     new lang_string('enablecourserequests', 'admin'),
    //     new lang_string('configenablecourserequests', 'admin'), 1));
    // $temp->add(new admin_settings_coursecat_select('defaultrequestcategory',
    //     new lang_string('defaultrequestcategory', 'admin'),
    //     new lang_string('configdefaultrequestcategory', 'admin'), 1));
    // $temp->add(new admin_setting_configcheckbox('lockrequestcategory',
    //     new lang_string('lockrequestcategory', 'admin'),
    //     new lang_string('configlockrequestcategory', 'admin'), 0));
    // $temp->add(new admin_setting_users_with_capability(
    //     'courserequestnotify',
    //     new lang_string('courserequestnotify', 'admin'),
    //     new lang_string('configcourserequestnotify2', 'admin'),
    //     [],
    //     'moodle/site:approvecourse'
    // ));
    // $ADMIN->add('courses', $temp);

    // Pending course requests - DISABLED
    // if (!empty($CFG->enablecourserequests)) {
    //     $ADMIN->add('courses', new admin_externalpage('coursespending', new lang_string('pendingrequests'),
    //             $CFG->wwwroot . '/course/pending.php', array('moodle/site:approvecourse')));
    // }

    // Default settings category - DISABLED
    $ADMIN->add('courses', new admin_category('coursedefaultsettings', new lang_string('defaultsettingscategory', 'course')));

    // Groups category - DISABLED loi: this is tab Courses ở site administration > Courses
    $ADMIN->add('courses', new admin_category('groups', new lang_string('groups')));
    // $ADMIN->add('groups', new admin_externalpage('group_customfield', new lang_string('group_customfield', 'admin'),
    //     $CFG->wwwroot . '/group/customfield.php', ['moodle/group:configurecustomfields']));
    // - DISABLED
    // $ADMIN->add('groups', new admin_externalpage('grouping_customfield', new lang_string('grouping_customfield', 'admin'),
    //     $CFG->wwwroot . '/group/grouping_customfield.php', ['moodle/group:configurecustomfields']));

    // Activity chooser category - DISABLED
    $ADMIN->add('courses', new admin_category('activitychooser', new lang_string('activitychoosercategory', 'course')));

    // Backups category - DISABLED
    $ADMIN->add('courses', new admin_category('backups', new lang_string('backups','admin')));

}

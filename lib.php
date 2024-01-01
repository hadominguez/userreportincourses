<?php

defined('MOODLE_INTERNAL') || die;

function local_userreportincourses_extend_navigation(navigation_node $nav) {
    global $CFG;

    if (!isloggedin()) {
        return;
    }

    if (has_capability('local/userreportincourses:view', context_system::instance())) {
        $url = new moodle_url($CFG->wwwroot . '/local/userreportincourses/index.php');
        $node = navigation_node::create(get_string('pluginname', 'local_userreportincourses'), $url, navigation_node::TYPE_CUSTOM, null, null, new pix_icon('i/report', ''));

        $nav->add_node($node);
        if (stripos($CFG->custommenuitems, "/local/userreportincourses/index.php") === false) {
            $nodes = explode("\n", $CFG->custommenuitems);
            $node = get_string('pluginname', 'local_userreportincourses');
            $node .= "|";
            $node .= "/local/userreportincourses/index.php";
            array_unshift($nodes, $node);
            $CFG->custommenuitems = implode("\n", $nodes);
        }

    }

}
<?php

require_once('../../config.php');
require_once(__DIR__ . '/classes/Report.php');

require_capability('local/userreportincourses:view', context_system::instance());

$url = new moodle_url('/local/userreportincourses/index.php');
$dataformat = optional_param('dataformat', null, PARAM_ALPHANUMEXT);
$page = optional_param('page', 0, PARAM_INT);
if ($page !== 0) {
    $url->param('page', $page);
}


$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);

$PAGE->set_title(get_string('pluginname', 'local_userreportincourses'));
$PAGE->set_heading(get_string('pluginname', 'local_userreportincourses'));

$report = new \local_userreportincourses\Report();
$data = $report->get_list_all_users_and_courses();
$perpage = 10;
$datapage = $report->get_list_users_and_courses_on_the_page($data, $perpage);
$columns = $report->get_columns_table();

if ($dataformat) {
    $extrafields = [];
    \core\dataformat::download_data(
        date("dmY"),
        $dataformat,
        $columns[0],
        $data,
        null
    );
    exit;
}

echo $OUTPUT->header();

print $OUTPUT->paging_bar(sizeof($data), $page, $perpage, $url);
echo $OUTPUT->download_dataformat_selector("Download", '/local/userreportincourses/index.php', 'dataformat');


require_once($CFG->libdir . '/mustache/src/Mustache/Autoloader.php');
Mustache_Autoloader::register();
$tpl = file_get_contents('templates/template.mustache');
$mustache = new Mustache_Engine;
echo $mustache->render($tpl, array('users' => $datapage, 'columns' => $columns));


echo $OUTPUT->footer();

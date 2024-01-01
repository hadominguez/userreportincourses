<?php
namespace local_userreportincourses;
class report {
    public function get_list_all_users_and_courses() {
        $users = get_users();
        $data = array();

        foreach ($users as $user) {
            $enrolled_courses = enrol_get_users_courses($user->id, true);
            foreach ($enrolled_courses as $course) {
                $data[] = array(
                    'username' => $user->username,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'course' => $course->fullname
                );
            }
        }
        return $data;
    }

    public function get_list_users_and_courses_on_the_page($users) {
        $page = optional_param('page', 0, PARAM_INT);
        $perpage = 10;
        $data = array_slice($users, $page * $perpage, $perpage);
        return $data;
    }


    public function get_columns_table() {
        $columns[] = array(
            'username' => get_string('username', 'local_userreportincourses'),
            'firstname' => get_string('firstname', 'local_userreportincourses'),
            'lastname' => get_string('lastname', 'local_userreportincourses'),
            'course' => get_string('course', 'local_userreportincourses')
        );
        return $columns;
    }
    
}

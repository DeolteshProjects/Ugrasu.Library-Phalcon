<?php

use Phalcon\Acl\Resource;

$highSchoolLeaderResourсes = [];

$highSchoolLeaderResourсes['mfai'] = [
    'staffschedules' => ['index', 'get_edu_year', 'get_schedule_version', 'set_schedule_version', 'get_pps_tarif', 'set_duplicate_version_schedule', 'get_valid_rate', 'change_pps_on_version_schedule', 'get_appointment_type', 'set_initial_data', 'get_autocomplete_lecturer', 'get_high_school', 'filter_schedule_version', 'remove_schedule_version', 'copy_schedule_version', 'get_selected_version_schedule', 'print_schedule', 'remove_pps_from_version_schedule', 'update_schedule_version_name',  'get_main_report_schedule', 'get_report_schedule', 'get_report_hours'],
];

//Модуль составления библиографических справок по направлению обучения
$highSchoolLeaderResourсes['libraryreport'] = [
    'index' => ['index'],
    'compiler' => ['index', 'search'],
    'libraryreport' => [
        'saveNew',                              //Сохранение БС
        'getEmpty',                             //Получение не составленных БС
        'getNew', 'getNewByCompiler',           //Получение (всех/по составителю) новых БС
        'getSuccess', 'getSuccessByCompiler',   //Получение (всех/по составителю) принятых БС
        'getDanger', 'getDangerByCompiler',     //Получение (всех/по составителю) отклоненных БС
        'getAll', 'getAllByCompiler',           //Получение (всех/по составителю) всех БС
        'getReport', 'getReports',              //Получение (одной/всех) БС по UCD_FNREC
        'getStarted', 'getNoStarted',           //Получение всех направлений с (начатыми/не начатыми) БС
        'getStartedByCompiler',                 //Получение всех направлений с (начатыми/не начатыми) БС по составителю
        'getStartedNew',                        //Получение всех направлений с (непроверенными) БС
        'successReport', 'dangerReport',        //Изменение статуса БС на (принята/отклонена)
        'printReport', 'printReports'           //Печать (одной дисциплины/всего направления) БС
    ],
    'libraryer' => ['index'],
    'instruction' => ['index'],
    'workprogram' => ['getSpeciality', 'getForm', 'getDiscipline', 'getStudCount', 'getFNRec']
];

// $highSchoolLeaderResourse['mfai'] = ['admin'=>['index'],
//                              'managerworkloads' => ['index', 'get_filter_data', 'get_data', 'get_course_leaders', 'approve_course_leader', 'solidify_course_leader',
//                                                    'get_autocomplete_course_leader', 'add_course_leader_to_discipline'],
//                             'fasteningofstudents' => ['index', 'get_direction', 'get_data', 'save_data', 'get_info_about_group'],
//                             'loadforming' => ['index', 'get_data', 'access', 'refuse'],
//                             'incomeexpenses' => ['index'],
//                             'incomes' => ['index', 'get_data']];

foreach ($highSchoolLeaderResourсes as $modules => $controllers) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules), $controller . $action);
            $acl->allow('Supervisor', $modules, $controller . $action);
            $acl->allow('Administrator', $modules, $controller . $action);
            $acl->allow('Rector', $modules, $controller . $action);
            $acl->allow('Director', $modules, $controller . $action);
            $acl->allow('HighSchoolLeader', $modules, $controller . $action);
        }
    }
}

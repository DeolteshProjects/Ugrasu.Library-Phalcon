<?php

use Phalcon\Acl\Resource;

$employeeResources = [];

/* $employeeResources['main']  = ['index'   => ['index'],
'signup'  => ['index',
'auth',
'close',
'change']];
$employeeResources['auth']  = ['index'   => ['index'],
'signup'  => ['index',
'auth',
'close',
'change']];

$employeeResources['portfolio'] = ['index' => ['index', 'show', 'find', 'findByQuery'],
'files' => ['index', 'categories', 'document', 'types', 'getDocuments', 'deleteDocument']];

$employeeResources['canteen'] = ['index' => ['index', 'getAllDishes']];

$employeeResources['lir'] = ['index'=>['index']];

$employeeResources['dogs'] = ['index'=>['index', 'save_click']];

$employeeResources['news'] = ['index'=>['index']];

$employeeResources['settings'] = ['index'=>['index', 'saveSettings']];

$employeeResources['personal'] = ['index'=>['index']];

$employeeResources['mfai'] = ['index'=>['index']];

$employeeResources['library'] = ['index'=>['index']]; */

$employeeResources['library'] = ['index' => ['index']];

$employeeResources['mfai'] = [
    'index' => ['index'],
    'workload' => ['index'],
    'courseleaderships' => ['index', 'get_filter_data', 'get_data', 'subscribe_course_leader', 'unsubscribe_course_leader'],
    'educationloads' => [
        'index', 'get_filter_data', 'get_data', 'get_autocomplete_lecturer',
        'set_person_on_discipline', 'remove_person_from_discipline',
        'set_division_hours', 'remove_division_hours', 'get_list_requests', 'get_user'
    ],
    //'fasteningofstudents' => ['index', 'get_direction', 'get_data', 'save_data', 'get_info_about_group'],
    'loadforming' => ['index', 'get_data', 'access', 'refuse', 'print_instr_card', 'get_edu_year'],
    'subjectarea' => [
        'index', 'get_departments', 'get_discipline', 'get_subject_area', 'get_employee_fio',
        'create_subject_area', 'bind_discipline', 'unbind_discipline',
        'bind_course_leader', 'delete_subject_area', 'edit_subject_area', 'print_word', 'print_registry'
    ],
    'loadapplications' => ['index', 'get_all_data_filters', 'get_all_data', 'set_on_discipline', 'remove_from_discipline'],
    'fasteningsubjectarea' => ['index', 'get_all_data', 'get_user_data', 'delete_user_area', 'get_filter_data'],
    'consolidatedhours' => ['index', 'get_all_data', 'get_edu_year']
];

// 'loadapplications' => ['index', 'get_all_institutes', 'get_all_subject_areas']

$employeeResources['workprogram'] = [
    'index' => ['index'],
    'workprogram' => ['index', 'get_speciality', 'get_disc', 'get_fgos', 'get_hours', 'get_developer_data', 'save_rpd', 'get_all_saved_rpd', 'get_saved_rpd', 'get_competences', 'get_list_disc', 'save_document']
];

$employeeResources['quiz'] = [
    'index' => ['index'],
    'educatorinner' => ['index', 'get_data', 'set_data']
];



//Модуль составления библиографических справок по направлению обучения
$employeeResources['libraryreport'] = [
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



foreach ($employeeResources as $modules => $controllers) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules), $controller . $action);
            $acl->allow('Supervisor', $modules, $controller . $action);
            $acl->allow('Administrator', $modules, $controller . $action);
            $acl->allow('Rector', $modules, $controller . $action);
            $acl->allow('Director', $modules, $controller . $action);
            $acl->allow('HighSchoolLeader', $modules, $controller . $action);
            $acl->allow('Manager', $modules, $controller . $action);
            $acl->allow('Tutor', $modules, $controller . $action);
            $acl->allow('PartEP', $modules, $controller . $action);
            $acl->allow('Employee', $modules, $controller . $action);
        }
    }
}

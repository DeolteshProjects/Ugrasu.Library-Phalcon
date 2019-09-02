<?php

use Phalcon\Acl\Resource;

$directorResources['mfai'] = [
    'adminpanel' => ['index'],
    'staffschedules' => ['index', 'get_edu_year', 'get_schedule_version', 'set_schedule_version', 'get_chair', 'get_pps_tarif', 'get_valid_rate', 'set_duplicate_version_schedule', 'change_pps_on_version_schedule', 'get_appointment_type', 'set_initial_data', 'get_autocomplete_lecturer', 'get_high_school', 'filter_schedule_version', 'remove_schedule_version', 'copy_schedule_version', 'get_selected_version_schedule', 'print_schedule', 'remove_pps_from_version_schedule', 'update_schedule_version_name', 'get_main_report_schedule', 'get_report_schedule', 'get_report_hours'],
    'groupofdirections' => ['index', 'get_all_data', 'save_data', 'delete_data'],
    'direction' => ['index', 'get_all_direction', 'save_direction', 'delete_direction', 'get_modal_data', 'get_edu_year'],
    'bindingprograms' => [
        'index', 'get_all_binded_program', 'bind_program', 'unbind_program', 'get_modal_data',
        'get_fio_employee', 'attach_manager', 'unbind_manager', 'get_exist_manager',
        'get_exist_high_school', 'attach_high_school', 'get_co_payment', 'get_session_data', 'get_exist_tutor', 'get_fio_tutor', 'attach_tutor', 'unbind_tutor'
    ],
    'ratespps' => ['index', 'get_rate', 'update_rate', 'get_exist_date', 'get_min_date', 'copy_tariff_scale'],
    'lecturer' => ['index', 'get_all_lecturer', 'combine_lecturer', 'add_lecturer', 'edit_lecturer'],
    'subjectarea' => [
        'index', 'get_departments', 'get_discipline', 'get_subject_area', 'get_employee_fio',
        'create_subject_area', 'bind_discipline', 'unbind_discipline',
        'bind_course_leader', 'delete_subject_area', 'edit_subject_area', 'print_word'
    ],
    'expenses' => [
        'index', 'get_properties', 'get_semester',
        'get_properties_val', 'save_properties_data', 'get_institute',
        'get_expenditures', 'get_expenditures_val', 'save_expenditures_val'
    ],
    'reportfcl' => ['index', 'get_data'],
];

$directorResources['reportfcl'] = ['index' => ['index', 'get_data']];

//Индивидуальный план первый index  - это название контроллера, в массиве методы контроллера
$directorResources['individplan'] = ['index' => ['index', 'get_general_data', 'get_edu_year', 'get_edu_card_data']];

//Модуль составления библиографических справок по направлению обучения
$directorResources['libraryreport'] = [
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

foreach ($directorResources as $modules => $controllers) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules), $controller . $action);
            $acl->allow('Supervisor', $modules, $controller . $action);
            $acl->allow('Director', $modules, $controller . $action);
            $acl->allow('Administrator', $modules, $controller . $action);
            $acl->allow('Rector', $modules, $controller . $action);
        }
    }
}

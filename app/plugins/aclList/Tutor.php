<?php

use Phalcon\Acl\Resource;

$tutorResources = [];

$tutorResources['mfai'] = ['controldisciplinechoices' => [
    'index',
    'get_data',
    'get_filters',
    'print_word',
    'get_admin_filter',
    'print_word_for_admin',
    'get_course'
]];

$tutorResources['callreference'] = [
    'index' => ['index'],
    'tutor' => ['index', 'getData', 'print']
];

$tutorResources['hotlinks'] = ['index' => ['index', 'get_all_hot_links']];

$tutorResources['reportfcl'] = ['index' => ['index', 'get_data']];


//Модуль составления библиографических справок по направлению обучения
$tutorResources['libraryreport'] = [
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


// подключение методов для индивидуального плана
$tutorResources['individplan'] = ['index' => ['index', 'get_general_data', 'get_edu_year', 'get_edu_card_data', 'get_type_work', 'get_characteristic', 'get_data_time_norm', 'sent_data_two_section', 'get_training_plan', 'get_type_workS3', 'get_training_planS3', 'delete_str', 'get_type_workS4', 'get_training_planS4', 'get_type_workS5', 'get_training_planS5', 'get_volume_load_data']];

foreach ($tutorResources as $modules => $controllers) {
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
            $acl->allow('Employee', $modules, $controller . $action);
        }
    }
}

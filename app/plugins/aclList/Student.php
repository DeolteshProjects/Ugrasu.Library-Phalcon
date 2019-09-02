 <?php
use Phalcon\Acl\Resource;


$studentResources = [];

$studentResources['main']  = ['index'   => ['index'],
                               'signup'  => ['index',
                                              'auth',
                                             'close',
                                             'change']];



$studentResources['auth']  = ['index'   => ['index'],
                                'signup'  => ['index',
                                              'auth',
                                              'close',
                                              'change']];

$studentResources['portfolio'] = ['index' => ['index', 'show', 'find', 'findByQuery'],
                                    'files' => ['index', 'categories', 'document', 'types', 'getDocuments', 'deleteDocument']];

$studentResources['canteen'] = ['index' => ['index', 'getAllDishes']];

$studentResources['group'] = ['index'=>['index']];

$studentResources['lir'] = ['index'=>['index']];

$studentResources['dogs'] = ['index'=>['index', 'save_click']];

$studentResources['news'] = ['index'=>['index']];

$studentResources['settings'] = ['index'=>['index', 'saveSettings']];

$studentResources['personal'] = ['index'=>['index']];

$studentResources['library'] = ['index'=>['index']];

$studentResources['mfai'] = ['index' => ['index'],
        'electivedisciplines' => ['index'],
        'disciplinechoices' => ['index', 'get_data', 'get_lecturer_data', 'save_data', 'get_selected_disc'],
        'lk' => ['index', 'get_courses', 'get_data'],
        'fcl' => ['index', 'get_init_data', 'get_data', 'get_filter_day', 'get_filter_pair', 'reject_choice', 'submit_choice', 'reject_group']
        ];

$studentResources['printforms'] = ['index' => ['index'],
                                    'ordersref' => ['index', 'get_data', 'get_history', 'order_ref', 'get_group_name', 'cancel_ref', 'get_st_available_ref']];

$studentResources['feedback'] = ['index' => ['index', 'save', 'success']];

$studentResources['timetable'] = ['index' => ['index']];

$studentResources['studhotlinks'] = ['index' => ['index', 'get_all_stud_hot_links']];

$studentResources['quiz'] = ['index' => ['index'], 
    'studinner' => ['index', 'get_data', 'set_data']];

//Было закоментировано Алексеем Чернавским
$studentResources['fcl'] = ['index' => ['index', 'get_init_data', 'get_data', 'get_filter_day', 'get_filter_pair', 'reject_choice', 'submit_choice', 'reject_group']];


$studentResources['fair'] = ['index' => ['index'],
    
    'list' => ['index', 'get_data', 'get_selected_prj', 'get_roles', 'get_projects_with_me', 'sumbit_prj_offer']];


foreach ($studentResources as $modules => $controllers ) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
           $acl->addResource(new Resource($modules),$controller.$action);
           $acl->allow('Supervisor', $modules, $controller.$action);
           $acl->allow('Administrator', $modules, $controller.$action);
           $acl->allow('Rector', $modules, $controller.$action);
           $acl->allow('Director', $modules, $controller.$action);
           $acl->allow('HighSchoolLeader', $modules, $controller.$action);
           $acl->allow('Manager', $modules, $controller.$action);
           $acl->allow('Tutor', $modules, $controller . $action);
           $acl->allow('PartEP', $modules, $controller.$action);
           $acl->allow('Employee', $modules, $controller.$action);
           $acl->allow('Student', $modules, $controller.$action);
        }
    }
}

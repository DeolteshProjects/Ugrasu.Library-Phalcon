 <?php

    use Phalcon\Acl\Resource;

    $administratorResources['portfolio'] = ['admin' => ['index', 'get_line_graph_data']];

    $administratorResources['printforms'] = [
        'index' => ['index'],
        'registryref' => [
            'index', 'get_references', 'print_doc', 'get_st_fio', 'order_ref',
            'print_all_docs', 'get_filtered_ref_data', 'get_st_group', 'get_st_available_ref', 'refresh',
            'print_all_registry', 'update_ref', 'get_certificate_data', 'save_certificate_data'
        ]
    ];

    $administratorResources['mfai'] = [
        'staffschedules' => ['index', 'get_edu_year', 'get_schedule_version', 'set_schedule_version', 'get_pps_tarif', 'get_valid_rate', 'set_duplicate_version_schedule', 'change_pps_on_version_schedule', 'get_appointment_type', 'set_initial_data', 'get_autocomplete_lecturer', 'get_high_school', 'filter_schedule_version', 'remove_schedule_version', 'copy_schedule_version', 'get_selected_version_schedule', 'print_schedule', 'remove_pps_from_version_schedule', 'update_schedule_version_name', 'get_main_report_schedule', 'get_report_schedule', 'get_report_hours'],
        'expenses' => ['insert_property', 'insert_expenditures', 'get_properties_by_level'],
        // 'controldisciplinechoices' => ['index', 'get_data', 'get_filters']
        'controldisciplinechoices' => [
            'index',
            'get_data',
            'get_filters',
            'print_word',
            'get_admin_filter',
            'print_word_for_admin',
            'get_course'
        ],
        'subjectarea' => ['index', 'print_word', 'print_document', 'get_filters'],
        'bindingprograms' => [
            'index', 'get_all_binded_program', 'bind_program', 'unbind_program', 'get_modal_data',
            'get_fio_employee', 'attach_manager', 'unbind_manager', 'get_exist_manager',
            'get_exist_high_school', 'attach_high_school', 'get_co_payment', 'get_session_data'
        ],
    ];



    //Модуль составления библиографических справок по направлению обучения
    $supervisorResources['libraryreport'] = [
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


    // $administratorResources['mfai'] = ['adminpanel' => ['index'], 
    //     'groupofdirections' => ['index', 'get_all_data', 'save_data', 'delete_data'],
    //     'direction' => ['index', 'get_all_direction', 'save_direction', 'delete_direction', 'get_modal_data'],
    //     'bindingprograms' => ['index', 'get_all_binded_program', 'bind_program', 'unbind_program', 'get_modal_data',
    //         'get_fio_employee', 'attach_manager', 'unbind_manager', 'get_exist_manager'],
    //     'ratespps' => ['index', 'get_rate', 'update_rate', 'get_exist_date'],
    //     'lecturer' => ['index', 'get_all_lecturer', 'combine_lecturer', 'add_lecturer', 'edit_lecturer']];

    foreach ($administratorResources as $modules => $controllers) {
        foreach ($controllers as $controller => $actions) {
            foreach ($actions as $action) {
                $acl->addResource(new Resource($modules), $controller . $action);
                $acl->allow('Administrator', $modules, $controller . $action);
                $acl->allow('Supervisor', $modules, $controller . $action);
            }
        }
    }

 <?php
use Phalcon\Acl\Resource;

//Модуль составления библиографических справок по направлению обучения
$supervisorResources['libraryreport'] = ['index' => ['index'],
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
    'workprogram' => ['getSpeciality', 'getForm', 'getDiscipline', 'getStudCount', 'getFNRec']];

foreach ($supervisorResources as $modules => $controllers) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules), $controller . $action);
            $acl->allow('Supervisor', $modules, $controller . $action);
        }
    }
}

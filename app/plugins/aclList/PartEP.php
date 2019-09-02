<?php
use Phalcon\Acl\Resource;

$particiantEPResources = [];

$particiantEPResources['diploma'] = ['index' => ['index', 'print']];

foreach ($particiantEPResources as $modules => $controllers) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules), $controller . $action);
            $acl->allow('Supervisor', $modules, $controller . $action);
            $acl->allow('Administrator', $modules, $controller . $action);
            $acl->allow('Director', $modules, $controller . $action);
            $acl->allow('HighSchoolLeader', $modules, $controller . $action);
            $acl->allow('Manager', $modules, $controller . $action);
            $acl->allow('Tutor', $modules, $controller . $action);
            $acl->allow('PartEP', $modules, $controller . $action);
        }
    }
}

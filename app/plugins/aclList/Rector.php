<?php

use Phalcon\Acl\Resource;

$rectorResources['mfai'] = ['admin'=>['index']];

foreach ($rectorResources as $modules => $controllers ) {
    foreach ($controllers as $controller => $actions) {
        foreach ($actions as $action) {
            $acl->addResource(new Resource($modules),$controller.$action);
            $acl->allow('Supervisor', $modules, $controller.$action);
            $acl->allow('Administrator', $modules, $controller.$action);
            $acl->allow('Rector', $modules, $controller.$action);
        }
    }
}

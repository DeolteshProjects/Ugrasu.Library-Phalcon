<?php

//Аккуратно с регистром, рабочий сервер Linux привередливый
namespace Elios\Libraryreport;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{
    /**
     * Регистрация автозагрузчика, специфичного для текущего модуля
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            array(
                'Elios\Libraryreport\Controllers' => __DIR__ . '/controllers/',
                'Elios\Libraryreport\Models'      => __DIR__ . '/models/',
                'Elios\Admin\Models'    => '../app/modules/admin/models/',
                'Phalcon'              => '../../incubator/Library/Phalcon'
            )
        );
        $loader->register();
    }

    /**
     * Регистрация специфичных сервисов для модуля
     */
     public function registerServices(DiInterface $di)
     {
         //Регистрация компонента представлений
         $di->set('view', function () {
             $view = new View();
             $view->setViewsDir(__DIR__ . '/views/');
             $view->setLayoutsDir('../../../common/views/');
             $view->setTemplateAfter('main');
             $view->registerEngines(
                 array(
                     ".volt" => 'Phalcon\Mvc\View\Engine\Volt'
                 )
             );
             return $view;
         });
     }
}

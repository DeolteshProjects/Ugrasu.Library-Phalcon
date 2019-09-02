<?php

use Phalcon\Mvc\Router;

/**
  * Глобальные роуты для приложения
  *
*/

 $router = new Router();
        

        //Шаблон для маршрутов модуля "Библиографические справки"
        $router->add('/libraryreport/:controller/:action/:params', array(
            'namespace'  => 'Elios\Libraryreport\Controllers',
            'module'     => 'libraryreport',
            'controller' => 1,
            'action'     => 2,
            'params'     => 3
        ));

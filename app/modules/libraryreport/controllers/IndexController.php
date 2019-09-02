<?php
namespace Elios\Libraryreport\Controllers; //Переименовал Example на Education #name: Yusuf

use Phalcon\Mvc\Controller;
use Elios\Admin\Models\Services;

class IndexController extends Controller
{

    public function indexAction()
    {
    	$this->tag::setTitle('Библиографические справки'); // Переименовал Модуль пример на тренировочный модуль
    	$this->breadcrumbs->setSeparator('');
        $this->breadcrumbs->add('Главная страница', '/');
        $this->breadcrumbs->add('Библиографические справки', '/allreport/index/index', ['linked' => false]); // Переименовал модуль пример на Тренировочный модуль, example на education
        // ['linked' => false] - это значит, что данный путь не ссылочный.

        //Выводим все дочерние сервисы для модуля
        $url = ['URL' => ('/'.$this->router->getModuleName().'/'.$this->router->getControllerName().'/'.$this->router->getActionName()) ];
        $services = (new Services())->getServicesByUrl($url);
        //Разбираем строку с доступными ролями в массив

        for ($i = 0; $i < count($services); $i++) {
            $services[$i]['FCROLE_LIST'] = explode(",",$services[$i]['FCROLE_LIST']);
        }
        
        $this->view->services = $services;
    }
}
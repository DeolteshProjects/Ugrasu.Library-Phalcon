<?php

namespace Elios\Libraryreport\Controllers;


use Phalcon\Mvc\Controller;
use Elios\Admin\Models\Services;
use Elios\Libraryreport\Controllers\library\irbis\irbis;
use Elios\Libraryreport\Controllers\library\sintAnal\sintAnal;
use Elios\Libraryreport\Controllers\library\filter\filter;
use Elios\Libraryreport\Models\checkAccess;

class InstructionController extends Controller
{

    public function indexAction()
    {
        //Получаем ФИО составителя
        $this->view->access = true;
        $this->breadcrumbs->setSeparator('');
        $this->breadcrumbs->add('Главная страница', '/');
        $this->breadcrumbs->add('Библиографические справки', '/libraryreport/index/index');
        $this->breadcrumbs->add('Инструкция', '/libraryreport/compiler/index', ['linked' => false]);

        $this->tag::setTitle('Инструкция');

        //Стили
        $this->assets->addCss('css/libraryreport/style.css');
        //$this->assets->addCss('css/libraryreport/mybootstrap.css');


        //Vue
        $this->assets->addJs("js/vendors/vue/vue_2.5.16/vue.js");
        //Script
        $this->assets->addJs('js/libraryreport/instruction.min.js');

        //Toastr
        $this->assets->addJs("js/vendors/toast/toastr.min.js");
        $this->assets->addCss("js/vendors/toast/toastr.min.css");
    }
}

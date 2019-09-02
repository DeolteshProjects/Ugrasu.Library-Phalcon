<?php

namespace Elios\Libraryreport\Controllers;


use Phalcon\Mvc\Controller;
use Elios\Admin\Models\Services;
use Elios\Libraryreport\Controllers\Library\Irbis\Irbis;
use Elios\Libraryreport\Controllers\Library\SintAnal\SintAnal;
use Elios\Libraryreport\Controllers\Library\Filter\Filter;
use Elios\Libraryreport\Models\CheckAccess;

class LibraryerController extends Controller
{

    public function indexAction()
    {
        //Получаем ФИО составителя
        $librarian = ($this->session->get('user_info'))[0]["FFULLNAME"];

        if (((new CheckAccess())->checkLibrarian($librarian)) == 0) {
            $this->view->access = false;
        } else {
            $this->view->access = true;
        }
        $this->breadcrumbs->setSeparator('');
        $this->breadcrumbs->add('Главная страница', '/');
        $this->breadcrumbs->add('Библиографические справки', '/libraryreport/index/index');
        $this->breadcrumbs->add('Проверка библиографических справок', '/libraryreport/libraryer/index', ['linked' => false]);

        $this->tag::setTitle('Проверка библиографических справок');

        //Стили
        $this->assets->addCss('css/libraryreport/style.css');

        //Toastr
        $this->assets->addJs("js/vendors/toast/toastr.min.js");
        $this->assets->addCss("js/vendors/toast/toastr.min.css");

        //Vue
        $this->assets->addJs("js/vendors/vue/vue_2.5.16/vue.js");
        //Script
        $this->assets->addJs('js/libraryreport/libraryer.js');
    }
}

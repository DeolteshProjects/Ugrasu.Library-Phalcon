<?php

namespace Elios\Libraryreport\Controllers;


use Phalcon\Mvc\Controller;
use Elios\Admin\Models\Services;
use Elios\Libraryreport\Controllers\Library\Irbis\Irbis;
use Elios\Libraryreport\Controllers\Library\SintAnal\SintAnal;
use Elios\Libraryreport\Controllers\Library\Filter\Filter;
use Elios\Libraryreport\Models\CheckAccess;

class CompilerController extends Controller
{

    public function indexAction()
    {
        
        //Получаем ФИО составителя
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        if (((new CheckAccess())->checkPPS($compiler)) == 0) {
            $this->view->access = false;
        } else {
            $this->view->access = true;
        }
        $this->breadcrumbs->setSeparator('');
        $this->breadcrumbs->add('Главная страница', '/');
        $this->breadcrumbs->add('Библиографические справки', '/libraryreport/index/index');
        $this->breadcrumbs->add('Составление новых библиографических справок', '/libraryreport/compiler/index', ['linked' => false]);

        $this->tag::setTitle('Составление новых библиографических справок');

        //Стили
        $this->assets->addCss('css/libraryreport/style.css');
        //$this->assets->addCss('css/libraryreport/mybootstrap.css');
        
        //Toastr
        $this->assets->addJs("js/vendors/toast/toastr.min.js");
        $this->assets->addCss("js/vendors/toast/toastr.min.css");
        //Vue
        $this->assets->addJs("js/vendors/vue/vue_2.5.16/vue.js");
        //Script
        $this->assets->addJs('js/libraryreport/compiler.js');

    }

    public function searchAction()
    {
        //Создаем экземпляр класса Irbis
        $Irbis = new Irbis();
        //Выполняем попытку подключения к серверу
        if ($Irbis->login()) {
            //Составляем поисковый запрос
            $Query = $Irbis->getQuery($_POST);
            //Выполняем поиск литературы в системе библиотеки
            $result = $Irbis->recordsSearch(($Query), null, 1, "@");
            //Если копученный код ошибки равен 0 продолжаем работу
            if ($result['error_code'] == 0) {
                $AllAnswer = array_merge_recursive($result['FOND'], $result['ZNANIUM'], $result['URAIT'], $result['LAN']);
                //Проверяем что литература была найденна
                if ((isset($result['searchNumber'])) && ($result['searchNumber'] > 0)) {
                    //Подключаем синтаксический анализатор
                    $SintAnal = new SintAnal();
                    //Сливаем все результаты в единый массив    
                    $Answer = [];
                    //Прогоняем все результаты поиска через синтаксический анализатор
                    for ($i = 0; $i < ($result['searchNumber'] - 1); $i++) {
                        $Answer[$i] = $SintAnal->getSmallParse($AllAnswer['records'][$i + 1]);
                    }
                    //Выполняем фильтрацию результатов если это необходимо
                    if ($_POST['filters'] == 'true') {
                        $Filter = new Filter();
                        /*
                        *  Фильтры
                        *  filterByOldYearOfPublication - Очистка литературы старше 20 лет
                        *  filterByStock   - Очистка печатной литературы имеющейся в наличии менее 3 штук
                        *  filterByAuthor - Очистка литературы, где автор не соответствует запрошенному или отсутствует
                        *  filterByStopWord - Очистка литературы, где описание содержит стоп слова
                        */
                        //Фильтруем литературу изданную более 20 лет назад
                        $Answer = ((new Filter())->filterByOldYearOfPublication($Answer));
                        //Фильтруем литературу по количеству остатков в наличии менее 3 штук
                        $Answer = ((new Filter())->filterByStock($Answer));
                        //Фильтруем литературу по количеству остатков в наличии по количеству студентов
                        $Answer = ((new Filter())->filterByCountStudents($Answer, (round(($_POST['studCount']) * ($_POST['studCoef'])))));
                        //Если был введен автор, фильтруем по автору
                        if (!empty($_POST['author'])) $Answer = (new Filter())->filterByAuthor($_POST['author'], $Answer);
                        //Если были введены стоп слова, фильтруем по стоп словам
                        if (!empty($_POST['stopWords'])) $Answer = (new Filter())->filterByStopWord($_POST['stopWords'], $Answer);
                    }
                    return json_encode($Answer);
                } else {
                    return json_encode(0);
                }
            } else {
                return json_encode(0);
            }
        } else {
            return json_encode(0);
        }
    }
}

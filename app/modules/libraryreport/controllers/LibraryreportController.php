<?php

namespace Elios\Libraryreport\Controllers;


use Phalcon\Mvc\Controller;
use Elios\Libraryreport\Models\LibraryReport;


class LibraryreportController extends Controller
{
    //Сохранение новой библиографической справки
    public function saveNewAction()
    {
        $year = $this->request->getPost('year');
        $speccode = $this->request->getPost('speccode');
        $speciality = $this->request->getPost('speciality');
        $discode = $this->request->getPost('discode');
        $discipline = $this->request->getPost('discipline');
        $forma = $this->request->getPost('forma');
        $fgos = $this->request->getPost('fgos');
        $fnrec = $this->request->getPost('fnrec');
        $studCount = $this->request->getPost('studCount');
        $studCoef = $this->request->getPost('studCoef');
        $countAllBook = $this->request->getPost('countAllBook');
        $countTBook = $this->request->getPost('countTBook');
        $countEBook = $this->request->getPost('countEBook');
        $countABook = $this->request->getPost('countABook');
        $countBBook = $this->request->getPost('countBBook');
        $tBooks = $this->request->getPost('tBooks');
        $eBooks = $this->request->getPost('eBooks');
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        $edit = $this->request->getPost('edit');
        if ($edit == 0) {
            (new LibraryReport())->saveNew(
                $year,
                $speccode,
                $speciality,
                $discode,
                $discipline,
                $forma,
                $fgos,
                $fnrec,
                $studCount,
                $studCoef,
                $countAllBook,
                $countTBook,
                $countEBook,
                $countABook,
                $countBBook,
                $tBooks,
                $eBooks,
                $compiler
            );
        } else {
            (new LibraryReport())->editReport(
                $compiler,
                $fnrec,
                $countAllBook,
                $countTBook,
                $countEBook,
                $countABook,
                $countBBook,
                $tBooks,
                $eBooks
            );
        }
        
        return json_encode(0);
    }

    //Получение новых библиографических справок
    public function getNewAction()
    {
        return json_encode((new LibraryReport())->getNew());
    }

    //Получение новых библиографических справок по составителю
    public function getNewByCompilerAction()
    {
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->getNewByCompiler($compiler));
    }

    //Получение принятых библиографических справок
    public function getSuccessAction()
    {
        return json_encode((new LibraryReport())->getSuccess());
    }

    //Получение принятых библиографических справок по составителю
    public function getSuccessByCompilerAction()
    {
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->getSuccessByCompiler($compiler));
    }

    //Получение отклоненных библиографических справок
    public function getDangerAction()
    {
        return json_encode((new LibraryReport())->getDanger());
    }

    //Получение отклоненных библиографических справок по составителю
    public function getDangerByCompilerAction()
    {
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->getDangerByCompiler($compiler));
    }

    //Получение всех библиографических справок
    public function getAllAction()
    {
        return json_encode((new LibraryReport())->getAll());
    }

    //Получение всех библиографических справок
    public function getEmptyAction()
    {
        $speccode = $this->request->getPost('speccode');
        $year = $this->request->getPost('year');
        $forma = $this->request->getPost('forma');
        return json_encode((new LibraryReport())->getEmpty($year, $speccode, $forma));
    }

    //Получение всех библиографических справок по составителю
    public function getAllByCompilerAction()
    {
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->getAllByCompiler($compiler));
    }

    //Получение библиографических справок по UCD_FNREC
    public function getReportAction()
    {
        $ucd_fnrec = $this->request->getPost('ucd_fnrec');
        return json_encode((new LibraryReport())->getReport($ucd_fnrec));
    }

    //Получение начатых библиографических справок по направлениям
    public function getStartedAction()
    {
        return json_encode((new LibraryReport())->getStarted());
    }

    //Получение начатых библиографических справок по направлениям
    public function getStartedNewAction()
    {
        return json_encode((new LibraryReport())->getStartedNew());
    }

    //Получение начатых библиографических справок по направлениям
    public function getStartedByCompilerAction()
    {
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->getStartedByCompiler($compiler));
    }

    //Получение не начатых библиографических справок по направлениям
    public function getNoStartedAction()
    {
        return json_encode((new LibraryReport())->getNoStarted());
    }

    //Получение начатых библиографических справок по направлениям
    public function getReportsAction()
    {
        $speccode = $this->request->getPost('speccode');
        $year = $this->request->getPost('year');
        $forma = $this->request->getPost('forma');
        return json_encode((new LibraryReport())->getReports($year, $speccode, $forma));
    }

    //Изменение статусa библиографической справки на принято
    public function successReportAction()
    {
        $ucd_fnrec = $this->request->getPost('ucd_fnrec');
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        return json_encode((new LibraryReport())->successReport($ucd_fnrec, $compiler));
    }

    //Изменение статусa библиографической справки на отклонено
    public function dangerReportAction()
    {
        $ucd_fnrec = $this->request->getPost('ucd_fnrec');
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        $message = $this->request->getPost('message');
        return json_encode((new LibraryReport())->dangerReport($ucd_fnrec, $compiler, $message));
    }


    //Запись только одного вида литературы
    public function printOnlyOneViewBooks($template, $view, $Literature, $amount, $row, $forma)
    {
        $amount = $amount - 1;
        $T_TEXT = "Печатные учебные издания";
        $E_TEXT = "Электронные учебные издания, имеющиеся в электронном каталоге электронно-библиотечной системы";
        //Если есть только печатная литература
        //1. Удаляем поле для второго вида литературы
        $template->cloneRow("two_literature_#" . $row, 0);
        //2. Записываем вид литературы
        ($view == 0) ? $template->setValue("one_literature_#" . $row, $T_TEXT) : $template->setValue("one_literature_#" . $row, $E_TEXT);
        //3.Записываем первую литературу и ее количество
        $template->setValue("one_books_#" . $row, "1. " . $Literature[0]['author'] . ' ' . $Literature[0]['description']);
        ($Literature[0]['type'] == 0) ? $template->setValue("one_memory_#" . $row, "") : $template->setValue("one_memory_#" . $row, "(Дополнительная)");
        $template->setValue("One_NumberOfCopies_#" . $row, $Literature[0]['count']);

        if (isset($Literature[0]['countInLib'])) {
            if ($Literature[0]['countInLib'] == "Неограниченно")  $template->setValue("One_NumberOfCopies_#" . $row, "1");
        }

        if ($forma == "Очная") $template->setValue("One_NumberOfCopiesForStud_#" . $row, "0,25");
        else $template->setValue("One_NumberOfCopiesForStud_#" . $row, "0,5");
        //4. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("one_books_2#" . $row, $amount);

        if ($amount > 0) {
            //5.Остальное записываем по циклу
            for ($num = 1; $num <= $amount; $num++) {
                $column = $num + 1;
                $template->setValue("one_books_2#" . $row . "#" . $num, $column . ". " . $Literature[$num]['author'] . ' ' . $Literature[$num]['description']);
                ($Literature[$num]['type'] == 0) ? $template->setValue("one_memory_2#" . $row . "#" . $num, "") : $template->setValue("one_memory_2#" . $row . "#" . $num, "(Дополнительная)");
                $template->setValue("one_memory_2#" . $row . "#" . $num, $column . ". " . $Literature[$num]['description']);
                $template->setValue("One_NumberOfCopies_2#" . $row . "#" . $num, $Literature[$num]['count']);
                if (isset($Literature[$num]['countInLib'])) {
                    if ($Literature[$num]['countInLib'] == "Неограниченно")  $template->setValue("One_NumberOfCopies_2#" . $row . "#" . $num, "1");
                }
                if ($forma == "Очная") $template->setValue("One_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,25");
                else $template->setValue("One_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,5");
            }
        }
        //6.Готово
    }

    //Запись обоих видов литературы
    public function printTwoViewBooks($template, $TLiterature, $ELiterature, $t_amount, $e_amount, $row, $forma)
    {
        $t_amount = $t_amount - 1;
        $e_amount = $e_amount - 1;
        $T_TEXT = "Печатные учебные издания";
        $E_TEXT = "Электронные учебные издания, имеющиеся в электронном каталоге электронно-библиотечной системы";
        //1. Записываем вид литературы
        $template->setValue("one_literature_#" . $row, $T_TEXT);
        //2.Записываем первую литературу и ее количество
        $template->setValue("one_books_#" . $row, "1. " . $TLiterature[0]['author'] . ' ' . $TLiterature[0]['description']);
        ($TLiterature[0]['type'] == 0) ? $template->setValue("one_memory_#" . $row, "") : $template->setValue("one_memory_#" . $row, "(Дополнительная)");
        $template->setValue("One_NumberOfCopies_#" . $row, $TLiterature[0]['count']);

        if ($forma == "Очная") $template->setValue("One_NumberOfCopiesForStud_#" . $row, "0,25");
        else $template->setValue("One_NumberOfCopiesForStud_#" . $row, "0,5");

        //3. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("one_books_2#" . $row, $t_amount);
        if ($t_amount > 0) {
            //4.Остальное записываем по циклу
            for ($num = 1; $num <= $t_amount; $num++) {
                $column = $num + 1;
                $template->setValue("one_books_2#" . $row . "#" . $num, $column . ". " . $TLiterature[$num]['author'] . ' ' . $TLiterature[$num]['description']);
                ($TLiterature[$num]['type'] == 0) ? $template->setValue("one_memory_2#" . $row . "#" . $num, "") : $template->setValue("one_memory_2#" . $row . "#" . $num, "(Дополнительная)");
                $template->setValue("one_memory_2#" . $row . "#" . $num, $column . ". " . $TLiterature[$num]['description']);
                $template->setValue("One_NumberOfCopies_2#" . $row . "#" . $num, $TLiterature[$num]['count']);
                if ($forma == "Очная") $template->setValue("One_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,25");
                else $template->setValue("One_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,5");
            }
        }
        //5. Записываем вид литературы
        $template->setValue("two_literature_#" . $row, $E_TEXT);
        //6.Записываем первую литературу и ее количество
        $template->setValue("two_books_#" . $row, "1. " . $ELiterature[0]['author'] . ' ' . $ELiterature[0]['description']);
        ($ELiterature[0]['type'] == 0) ? $template->setValue("two_memory_#" . $row, "") : $template->setValue("two_memory_#" . $row, "(Дополнительная)");
        $template->setValue("Two_NumberOfCopies_#" . $row, "1");

        if ($forma == "Очная") $template->setValue("Two_NumberOfCopiesForStud_#" . $row, "0,25");
        else $template->setValue("Two_NumberOfCopiesForStud_#" . $row, "0,5");

        //7. Если тектовой литературы более 1 шт клонируем строку литературы нужное количество раз, если нет, то удаляем дополнительную строку
        $template->cloneRow("two_books_2#" . $row, $e_amount);
        if ($e_amount > 0) {
            //8.Остальное записываем по циклу
            for ($num = 1; $num <= $e_amount; $num++) {
                $column = $num + 1;
                $template->setValue("two_books_2#" . $row . "#" . $num, $column . ". " . $ELiterature[0]['author'] . ' ' . $ELiterature[$num]['description']);
                ($ELiterature[$num]['type'] == 0) ? $template->setValue("two_memory_2#" . $row . "#" . $num, "") : $template->setValue("two_memory_2#" . $row . "#" . $num, "(Дополнительная)");
                $template->setValue("two_memory_2#" . $row . "#" . $num, $column . ". " . $ELiterature[$num]['description']);
                $template->setValue("Two_NumberOfCopies_2#" . $row . "#" . $num, "1");
                if ($forma == "Очная") $template->setValue("Two_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,25");
                else $template->setValue("Two_NumberOfCopiesForStud_2#" . $row . "#" . $num, "0,5");
            }
        }
        //9.Готово
    }

    public function printReportsAction()
    {
        //Получение справок выбранным году и специальности

        $speccode = $this->request->getPost('speccode');
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];
        $year = $this->request->getPost('year');
        $forma = $this->request->getPost('forma');

        $Recs = (new LibraryReport())->getReportsByNrec($year, $speccode, $forma);

        for($i = 0; $i < count($Recs); $i++) {
            //Обновление статуса не печать
        (new LibraryReport())->printReport($Recs[$i]["UCD_FNREC"], $compiler, true);
            $LibraryReports[$i] = (new LibraryReport())->getReport($Recs[$i]["UCD_FNREC"]);
        }

        //Количество составляемых дисциплин
        $AmountOfLibraryReport = count($LibraryReports);

        //Инициализация документа
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //Выбор шаблона
        $template = $phpWord->loadTemplate('print/libraryreport/Template.docx');

        //Указываем направление подготовки
        $template->setValue('br_special_special', $LibraryReports[0][0]["SPECIALITYCODE"] . " - " . $LibraryReports[0][0]["SPECIALITY"]); //номер договора
        $template->setValue('br_special_year', $LibraryReports[0][0]["YEARED"]);

        //клонируем тамблицу под количесво дисциплин
        $template->cloneRow('d_discipline_', $AmountOfLibraryReport);

        //Проходим все справки по циклу
        for ($i = 0; $i < $AmountOfLibraryReport; $i++) {
            $row = $i + 1;
            
            //Сначало простое
            $template->setValue("d_discipline_number_#" . $row, $row);
            $template->setValue("d_discipline_#" . $row, $LibraryReports[$i][0]["DISCIPLINE"]);
            //Простое закончилось
            //Теперь проверяем присутствуют ои оба вида литературы (Электронная и Печатная)
            if (((($LibraryReports[$i][0]["COUNTLITERATURE"]["countTBook"]) > 0)) and ((($LibraryReports[$i][0]["COUNTLITERATURE"]["countEBook"]) > 0))) {
                self::printTwoViewBooks($template, $LibraryReports[$i][0]["TLITERATURE"], $LibraryReports[$i][0]["ELITERATURE"], $LibraryReports[$i][0]["COUNTLITERATURE"]["countTBook"], $LibraryReports[$i]["COUNTLITERATURE"]["countEBook"], $row, $LibraryReports[$i]["FORMA"]);
            } else if (((($LibraryReports[$i][0]["COUNTLITERATURE"]["countEBook"]) > 0))) {
                //Если есть только печатная литература
                self::printOnlyOneViewBooks($template, 1, $LibraryReports[$i][0]["ELITERATURE"], $LibraryReports[$i][0]["COUNTLITERATURE"]["countEBook"], $row, $LibraryReports[$i][0]["FORMA"]);
            } else if (((($LibraryReports[$i][0]["COUNTLITERATURE"]["countTBook"]) > 0))) {
                //Если есть только печатная литература
                self::printOnlyOneViewBooks($template, 0, $LibraryReports[$i][0]["TLITERATURE"], $LibraryReports[$i][0]["COUNTLITERATURE"]["countTBook"], $row, $LibraryReports[$i][0]["FORMA"]);
            }
        }

        //Проверка директории
        $dir = 'user_files/libraryreport/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $pathPublic = '/public/user_files/libraryreport/reports/';
        $pathDirectory = $_SERVER['DOCUMENT_ROOT'] . $pathPublic;

        $date = date("Y-m-d H-i-s");
        //Номер справки
        $n = strval($LibraryReports[0][0]['SPECIALITYCODE']);
        $fileName = "Library report reference all" . $n . " (" . $date . ").docx";
        $template->saveAs($pathDirectory . $fileName);

        //Публичный url для скачивания документа. Сохраняется на сервере и передается ссылка на ПК пользователя
        return $this->response = json_encode(["url" => $pathPublic . $fileName], JSON_UNESCAPED_UNICODE);
    }

    //Печать библиографической справки на дисциплину
    public function printReportAction()
    {
        $ucd_fnrec = $this->request->getPost('ucd_fnrec');
        $compiler = ($this->session->get('user_info'))[0]["FFULLNAME"];

        //Обновление статуса не печать
        (new LibraryReport())->printReport($ucd_fnrec, $compiler);


        //Получаем всю информацию о библиографической справке
        $report = (new LibraryReport())->getReport($ucd_fnrec);

        //Инициализация документа
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //Выбор шаблона
        $template = $phpWord->loadTemplate('print/libraryreport/Template.docx');

        //Количество составляемых дисциплин
        $count = count($report);

        //Указываем направление подготовки
        $template->setValue('br_special_special', $report[0]["SPECIALITYCODE"] . " - " . $report[0]["SPECIALITY"]);

        $template->setValue('br_special_year', $report[0]["YEARED"]);

        //клонируем тамблицу под количесво дисциплин
        $template->cloneRow('d_discipline_', $count);

        //Проходим все справки по циклу
        for ($i = 0; $i < $count; $i++) {
            $row = $i + 1;
            //Сначало простое
            $template->setValue("d_discipline_number_#" . $row, $row);
            $template->setValue("d_discipline_#" . $row, $report[0]["DISCIPLINE"]);

            //Простое закончилось
            //Теперь проверяем присутствуют ои оба вида литературы (Электронная и Печатная)
            if (((($report[$i]["COUNTLITERATURE"]["countTBook"]) > 0)) and ((($report[$i]["COUNTLITERATURE"]["countEBook"]) > 0))) {
                self::printTwoViewBooks($template, $report[$i]["TLITERATURE"], $report[$i]["ELITERATURE"], $report[$i]["COUNTLITERATURE"]["countTBook"], $report[$i]["COUNTLITERATURE"]["countEBook"], $row, $report[$i]["FORMA"]);
            } else if (((($report[$i]["COUNTLITERATURE"]["countEBook"]) > 0))) {
                //Если есть только печатная литература
                self::printOnlyOneViewBooks($template, 1, $report[$i]["ELITERATURE"], $report[$i]["COUNTLITERATURE"]["countEBook"], $row, $report[$i]["FORMA"]);
            } else if (((($report[$i]["COUNTLITERATURE"]["countTBook"]) > 0))) {
                //Если есть только печатная литература
                self::printOnlyOneViewBooks($template, 0, $report[$i]["TLITERATURE"], $report[$i]["COUNTLITERATURE"]["countTBook"], $row, $report[$i]["FORMA"]);
            }
        }

        //Проверка директории
        $dir = 'user_files/libraryreport/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $pathPublic = '/public/user_files/libraryreport/reports/';
        $pathDirectory = $_SERVER['DOCUMENT_ROOT'] . $pathPublic;

        $date = date("Y-m-d H-i-s");
        //Номер справки
        $n = strval($report[0]['UCD_FNREC']);
        $fileName = "Library report reference " . $n . " (" . $date . ").docx";
        $template->saveAs($pathDirectory . $fileName);

        //Публичный url для скачивания документа. Сохраняется на сервере и передается ссылка на ПК пользователя
        return $this->response = json_encode(["url" => $pathPublic . $fileName], JSON_UNESCAPED_UNICODE);
    }
}

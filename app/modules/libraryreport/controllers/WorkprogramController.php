<?php

namespace Elios\Libraryreport\Controllers;


use Phalcon\Mvc\Controller;
use Elios\Admin\Models\Services;
use Elios\Libraryreport\Models\WorkProgram;

class WorkprogramController extends Controller
{
    public function getSpecialityAction()
    {
        $year = $this->request->getPost('year');
        return $this->response = json_encode((new WorkProgram())->getSpeciality($year), JSON_UNESCAPED_UNICODE);
    }

    public function getFormAction()
    {
        $year = $this->request->getPost('year');
        $speccode = $this->request->getPost('speccode');
        return $this->response = json_encode((new WorkProgram())->getForm($year,$speccode), JSON_UNESCAPED_UNICODE);
    }

    public function getDisciplineAction()
    {
        $year = $this->request->getPost('year');
        $speccode = $this->request->getPost('speccode');
        $forma = $this->request->getPost('forma');
        return $this->response = json_encode((new WorkProgram())->getDiscipline($year, $speccode, $forma), JSON_UNESCAPED_UNICODE);
    }

    public function getStudCountAction()
    {
        $year = $this->request->getPost('year');
        $speccode = $this->request->getPost('speccode');
        $forma = $this->request->getPost('forma');
        //Преобразуем форму обучения в числовое значение
        ((trim($forma)) == "Очная") ? $forma = 0 : $forma = 1;
        return $this->response = json_encode((new WorkProgram())->getStudCount($year, $speccode, $forma), JSON_UNESCAPED_UNICODE);
    }

    public function getFNRecAction()
    {
        $year = $this->request->getPost('year');
        $speccode = $this->request->getPost('speccode');
        $forma = $this->request->getPost('forma');
        $discode = $this->request->getPost('discode');
        return $this->response = json_encode((new WorkProgram())->getFNRec($year, $speccode, $forma, $discode), JSON_UNESCAPED_UNICODE);
    }
}
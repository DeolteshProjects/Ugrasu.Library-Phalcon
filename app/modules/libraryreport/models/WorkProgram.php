<?php

namespace Elios\Libraryreport\Models;

use Phalcon\Db as Db;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;

class WorkProgram extends Model
{

    public function initialize()
    {
        $sql = "ALTER SESSION SET NLS_LANGUAGE='RUSSIAN'";
        $this->di->get('db')->query($sql);
        $sql = "ALTER SESSION SET NLS_TERRITORY='CIS'";
        $this->di->get('db')->query($sql);
        $this->setSource('V_ELIOS_CATEGORY_TREES');
    }

    public function getSpeciality($year)
    {
        //FYEARED - Год набора

        $query = 
            'SELECT DISTINCT 
                SPECIALITY, FSPECIALITYCODE
            FROM
                V_RPD_DISC
            WHERE
                FYEARED = :FYEARED
            ORDER BY
                FSPECIALITYCODE';

        $data = [
            ':FYEARED' => $year
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getForm($year, $speccode)
    {

        $query = 
            'SELECT DISTINCT 
                FORMA
            FROM
                V_RPD_DISC
            WHERE
                FYEARED = :FYEARED
            AND
                FSPECIALITYCODE = :FSPECIALITYCODE';

        $data = [
            ':FYEARED' => $year,
            ':FSPECIALITYCODE' => $speccode
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getDiscipline($year, $speccode, $forma)
    {

        $query = 
            "SELECT DISTINCT 
                DISCODE, DISCIPLINE
            FROM
                V_RPD_DISC
            WHERE
                    FYEARED = :FYEARED
                AND
                    FSPECIALITYCODE = :FSPECIALITYCODE
                AND
                    FORMA = :FORMA
            AND DISCODE NOT IN (
                SELECT DISTINCT 
                    DISCIPLINECODE as DISCODE
                FROM 
                    RPD_LITERATURE
                WHERE
                    YEARED = :FYEARED
                AND
                    SPECIALITYCODE = :FSPECIALITYCODE
                AND
                    FORMA = :FORMA)
            AND 
                DISCIPLINE NOT LIKE '%Экзамены по модулю%'
            AND 
                DISCIPLINE NOT LIKE 'дисциплина%'
            ORDER BY
                DISCIPLINE";

        $data = [
            ':FYEARED' => $year,
            ':FSPECIALITYCODE' => $speccode,
            ':FORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getStudCount($year, $speccode, $forma)
    {

        //TYPEREPORT    -   тип
        //YEARENTER     -   год набора

        $query = 
            'SELECT DISTINCT 
               sum(STUD_COUNT_ALL) as STUDCOUNT
            FROM
                MF_IFE_VPO1
            WHERE
                    TYPEREPORT = :TYPEREPORT
                AND
                    YEARENTER = :YEARENTER
                AND
                    CODESPECIALITY = :CODESPECIALITY
                AND
                    CFORMA = :CFORMA';

        $data = [
            ':TYPEREPORT' => "PlanNabora",
            ':YEARENTER' => $year,
            ':CODESPECIALITY' => $speccode,
            ':CFORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getFNRec($year, $speccode, $forma, $discode)
    {

        $query = 
            'SELECT 
                UCD_FNREC
            FROM
                V_RPD_DISC
            WHERE
                    FYEARED = :FYEARED
                AND
                    FSPECIALITYCODE = :FSPECIALITYCODE
                AND
                    FORMA = :FORMA
                AND
                    DISCODE = :DISCODE';

        $data = [
            ':FYEARED' => $year,
            ':FSPECIALITYCODE' => $speccode,
            ':DISCODE' => $discode,
            ':FORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }
    
}

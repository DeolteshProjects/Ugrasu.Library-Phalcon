<?php

namespace Elios\Libraryreport\Models;

use Phalcon\Db as Db;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;

class LibraryReport extends Model
{

    //Сохранение новой БС в базе
    public function saveNew($year, $speccode, $speciality, $discode, $discipline, $forma, $fgos, $fnrec, $studCount, $studCoef, $countAllBook, $countTBook, $countEBook, $countABook, $countBBook, $tBooks, $eBooks, $compiler)
    {
        $date = date("d-m-Y");

        $query =
            "INSERT INTO
                RPD_LITERATURE 
                (   UCD_FNREC, YEARED, YEAREDS, SPECIALITYCODE, SPECIALITY, DISCIPLINECODE, 
                    DISCIPLINE, COUNTSTUDENTS, FORMA, FGOS, COMPILER, STATUS, DATAFILE,   
                    COUNTLITERATURE, CREATEDATE, UPDATEDATE) 
            VALUES (
                    :UCD_FNREC, :YEARED, :YEAREDS, :SPECIALITYCODE, :SPECIALITY, 
                    :DISCIPLINECODE, :DISCIPLINE, :COUNTSTUDENTS, :FORMA, :FGOS, 
                    :COMPILER, :STATUS, :DATAFILE, 
                    :COUNTLITERATURE, :CREATEDATE, :UPDATEDATE
                )";

        $Activity[0] = [
            'Time'  => date("d-m-Y H:i:s"),
            'Activ' => $compiler,
            'Activiry'  =>  0,
            'Comment'   =>  'Создание БС'
        ];

        $dataReport = [
            0 => $Activity,
            1 => $tBooks,
            2 => $eBooks
        ];


        $dataReport = serialize($dataReport);


        $countLiterature = [
            'countAllBook'  =>  $countAllBook,
            'countTBook'    =>  $countTBook,
            'countEBook'    =>  $countEBook,
            'countABook'    =>  $countABook,
            'countBBook'    =>  $countBBook
        ];


        $pathPublic = '/public/user_files/libraryreport/data/';
        $pathDirectory = $_SERVER['DOCUMENT_ROOT'] . $pathPublic;
        $filename = $year . "_" . $speccode . "_" . $fnrec . "_(" . date("d-m-Y") . ").php";
        file_put_contents($pathDirectory . $filename, $dataReport);

        $data = [
            ':UCD_FNREC' => $fnrec,
            ':YEARED' => $year,
            ':YEAREDS' => $year . "-" . ($year + 1),
            ':SPECIALITYCODE' => $speccode,
            ':SPECIALITY' => $speciality,
            ':DISCIPLINECODE' => $discode,
            ':DISCIPLINE' => $discipline,
            ':COUNTSTUDENTS' => $studCount,
            ':FORMA' => $forma,
            ':FGOS' => $fgos,
            ':COMPILER' => $compiler,
            ':STATUS' => 0,
            ':DATAFILE' => $pathDirectory . $filename,
            ':COUNTLITERATURE' => serialize($countLiterature),
            ':CREATEDATE' => $date,
            ':UPDATEDATE' => null
        ];

        $answer = $this->di->get('db')->query($query, $data);
    }

    public function editReport($compiler, $fnrec, $countAllBook, $countTBook, $countEBook, $countABook, $countBBook, $tBooks, $eBooks)
    {
        $query = "
            SELECT 
                DATAFILE 
            FROM 
                RPD_LITERATURE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UCD_FNREC' => $fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $answer = $answer->fetchAll();

        $filename = fopen($answer[0]["DATAFILE"], "r");
        $line = "";
        while (!feof($filename)) {
            $line .= fgets($filename);
        }
        fclose($filename);

        //Расшифровываем библиографическую справку
        $dataReport = unserialize($line);
        $Activity = ($dataReport[0]);

        //
        $Activity[count($Activity)] = [
            'Time'  =>  date("d-m-Y H:i:s"),
            'Activ' => $compiler,
            'Activiry'  =>  8,
            'Comment'   =>  'Внесение изменений в библиографическую справку'
        ];

        $dataReport = [
            0 => $Activity,
            1 => $tBooks,
            2 => $eBooks
        ];

        $dataReport = serialize($dataReport);

        $countLiterature = [
            'countAllBook'  =>  $countAllBook,
            'countTBook'    =>  $countTBook,
            'countEBook'    =>  $countEBook,
            'countABook'    =>  $countABook,
            'countBBook'    =>  $countBBook
        ];

        file_put_contents($answer[0]["DATAFILE"], $dataReport);

        $query = "
            UPDATE 
                RPD_LITERATURE
            SET
                STATUS  =   8,
                UPDATEDATE   =   :UPDATEDATE,
                COUNTLITERATURE =   :COUNTLITERATURE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'COUNTLITERATURE' => serialize($countLiterature),
            'UPDATEDATE' => date("d-m-Y"),
            'UCD_FNREC' => $fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
    }

    public function getNew()
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 0
            OR
                STATUS = 8";

        $answer = $this->di->get('db')->query($query);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getNewByCompiler($compiler)
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 0
            OR
                STATUS = 8
            AND
                COMPILER = :COMPILER";

        $data = [
            'COMPILER' => $compiler
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getSuccess()
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 10";

        $answer = $this->di->get('db')->query($query);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getSuccessByCompiler($compiler)
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 10
            AND
                COMPILER = :COMPILER";

        $data = [
            'COMPILER' => $compiler
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getDanger()
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 2";

        $answer = $this->di->get('db')->query($query);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getDangerByCompiler($compiler)
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                STATUS = 2
            AND
                COMPILER = :COMPILER";

        $data = [
            'COMPILER' => $compiler
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getAll()
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE";

        $answer = $this->di->get('db')->query($query);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getEmpty($year, $speccode, $forma)
    {
        $query1 = "
        SELECT DISTINCT
            UCD_FNREC, DISCIPLINE, STATUS
        FROM 
            RPD_LITERATURE
        WHERE
            YEARED = :YEARED
        AND
            SPECIALITYCODE = :SPECCODE
        AND 
            FORMA = :FORMA
        AND
            STATUS != 2
        ORDER BY DISCIPLINE";

        $data = [
            'YEARED' => $year,
            'SPECCODE' => $speccode,
            'FORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query1, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $result[0] = $answer->fetchAll();

        $query2 = "
        SELECT DISTINCT
            UCD_FNREC, DISCIPLINE, DISCODE
        FROM 
            V_RPD_DISC
        WHERE
            FYEARED = :YEARED
        AND
            FSPECIALITYCODE = :SPECCODE
        AND 
            FORMA = :FORMA
        AND
        DISCIPLINE NOT IN (
                SELECT DISTINCT 
                    DISCIPLINE 
                FROM 
                    RPD_LITERATURE 
                WHERE
                    YEARED = :YEARED
                AND
                    SPECIALITYCODE = :SPECCODE
                AND 
                    FORMA = :FORMA
                )
        AND 
            DISCIPLINE NOT LIKE '%Экзамены по модулю%'
        AND 
            DISCIPLINE NOT LIKE 'дисциплина%'
        ORDER BY DISCIPLINE";

        $answer = $this->di->get('db')->query($query2, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $result[1] = $answer->fetchAll();

        $query3 = "
        SELECT DISTINCT
            UCD_FNREC, DISCIPLINE, STATUS
        FROM 
            RPD_LITERATURE
        WHERE
            YEARED = :YEARED
        AND
            SPECIALITYCODE = :SPECCODE
        AND 
            FORMA = :FORMA
        AND
            STATUS = 2
        ORDER BY DISCIPLINE";

        $answer = $this->di->get('db')->query($query3, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $result[2] = $answer->fetchAll();

        return $result;
    }

    public function getAllByCompiler($compiler)
    {
        $query = "
            SELECT 
                UCD_FNREC, YEARED, SPECIALITY, DISCIPLINE, COMPILER, STATUS, CREATEDATE, UPDATEDATE 
            FROM 
                RPD_LITERATURE 
            WHERE 
                COMPILER = :COMPILER";

        $data = [
            'COMPILER' => $compiler
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        return $answer->fetchAll();
    }

    public function getStarted()
    {
        $query2 = "
        SELECT DISTINCT
        VRPD.FYEARED, VRPD.SPECIALITY, VRPD.FSPECIALITYCODE, VRPD.FORMA, 
            (   SELECT count(DISTINCT DISCIPLINE) FROM V_RPD_DISC
                WHERE FYEARED = :YEARED
                AND FSPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND DISCIPLINE NOT LIKE '%Экзамены по модулю%'
                AND DISCIPLINE NOT LIKE 'дисциплина%'
            ) AS F1, (
                SELECT count(DISTINCT DISCIPLINE) FROM RPD_LITERATURE
                WHERE FYEARED = :YEARED
                AND SPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND STATUS = 10
            ) AS F2
        FROM 
            V_RPD_DISC VRPD
            WHERE FYEARED = :YEARED
            AND VRPD.DISCIPLINE NOT LIKE '%Экзамены по модулю%'
            AND VRPD.DISCIPLINE NOT LIKE 'дисциплина%'
            AND FORMA != 'Очно-заочная'
            ORDER BY F2 DESC , VRPD.SPECIALITY
            ";

        $data = [
            'YEARED' => date('Y')
        ];

        $answer = $this->di->get('db')->query($query2, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[0] = $answer->fetchAll();

        /*
        $query = "
        SELECT DISTINCT
        FYEARED, SPECIALITY, FSPECIALITYCODE 
        FROM 
            V_RPD_DISC
        WHERE
        SPECIALITY NOT IN (
                SELECT DISTINCT 
                    SPECIALITY 
                FROM
                    RPD_LITERATURE
                WHERE
                    YEARED >= :YEARED 
            )
        AND
            FYEARED >= :YEARED
        GROUP BY
            FYEARED, SPECIALITY, FSPECIALITYCODE
        ORDER BY
            FYEARED, SPECIALITY";

        $data = [
            'YEARED' => date('Y')
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[1] = $answer->fetchAll();
        */
        return $result;
    }

    public function getStartedNew()
    {
        $query2 = "
        SELECT DISTINCT
        VRPD.FYEARED, VRPD.SPECIALITY, VRPD.FSPECIALITYCODE, VRPD.FORMA, 
            (   SELECT count(DISTINCT DISCIPLINE) FROM V_RPD_DISC
                WHERE FYEARED = :YEARED
                AND FSPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND DISCIPLINE NOT LIKE '%Экзамены по модулю%'
                AND DISCIPLINE NOT LIKE 'дисциплина%'
            ) AS F1, (
                SELECT count(DISTINCT DISCIPLINE) FROM RPD_LITERATURE
                WHERE FYEARED = :YEARED
                AND SPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND STATUS = 10
            ) AS F2
        FROM 
            V_RPD_DISC VRPD, RPD_LITERATURE LRPD
            WHERE FYEARED = :YEARED
            AND VRPD.DISCIPLINE NOT LIKE '%Экзамены по модулю%'
            AND VRPD.DISCIPLINE NOT LIKE 'дисциплина%'
            AND VRPD.FORMA != 'Очно-заочная'
            AND VRPD.FYEARED = LRPD.YEARED
            AND VRPD.SPECIALITY = LRPD.SPECIALITY
            AND LRPD.STATUS < 10
            ORDER BY F2 DESC , VRPD.SPECIALITY
            ";

        $data = [
            'YEARED' => date('Y')
        ];

        $answer = $this->di->get('db')->query($query2, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[0] = $answer->fetchAll();

        /*
        $query = "
        SELECT DISTINCT
        FYEARED, SPECIALITY, FSPECIALITYCODE 
        FROM 
            V_RPD_DISC
        WHERE
        SPECIALITY NOT IN (
                SELECT DISTINCT 
                    SPECIALITY 
                FROM
                    RPD_LITERATURE
                WHERE
                    YEARED >= :YEARED 
            )
        AND
            FYEARED >= :YEARED
        GROUP BY
            FYEARED, SPECIALITY, FSPECIALITYCODE
        ORDER BY
            FYEARED, SPECIALITY";

        $data = [
            'YEARED' => date('Y')
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[1] = $answer->fetchAll();
        */
        return $result;
    }

    public function getStartedByCompiler($compiler)
    {

        $query2 = "
        SELECT DISTINCT
        VRPD.FYEARED, VRPD.SPECIALITY, VRPD.FSPECIALITYCODE, VRPD.FORMA,
            (   SELECT count(DISTINCT DISCIPLINE) FROM V_RPD_DISC
                WHERE FYEARED = :YEARED
                AND FSPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND DISCIPLINE NOT LIKE '%Экзамены по модулю%'
                AND DISCIPLINE NOT LIKE 'дисциплина%'
            ) AS F1, (
                SELECT count(DISTINCT DISCIPLINE) FROM RPD_LITERATURE
                WHERE YEARED = :YEARED
                AND SPECIALITYCODE = VRPD.FSPECIALITYCODE
                AND FORMA = VRPD.FORMA
                AND STATUS = 10
            ) AS F2
        FROM 
            V_RPD_DISC VRPD, RPD_LITERATURE LRPD
            WHERE VRPD.FYEARED = :YEARED
            AND VRPD.DISCIPLINE NOT LIKE '%Экзамены по модулю%'
            AND VRPD.DISCIPLINE NOT LIKE 'дисциплина%'
            AND VRPD.FORMA != 'Очно-заочная'
            AND VRPD.FYEARED = LRPD.YEARED
            AND VRPD.SPECIALITY = LRPD.SPECIALITY
            AND LRPD.COMPILER = :COMPILER
            ORDER BY F2 DESC , VRPD.SPECIALITY
            ";

        $data = [
            'YEARED' => date('Y'),
            'COMPILER' => $compiler
        ];

        $answer = $this->di->get('db')->query($query2, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        return $answer->fetchAll();
    }


    public function getNoStarted()
    {
        $query = "
            SELECT DISTINCT
                FYEARED, SPECIALITY, FSPECIALITYCODE 
                FROM 
                    V_RPD_DISC
                WHERE
                    SPECIALITY NOT IN (
                        SELECT DISTINCT 
                            SPECIALITY as SPECIALITY
                        FROM
                            RPD_LITERATURE
                        WHERE
                            STATUS = 10
                        AND
                            YEARED >= :YEARED 
                    )
                AND
                    FYEARED >= :YEARED
                GROUP BY
                    FYEARED, SPECIALITY, FSPECIALITYCODE
                ORDER BY
                    FYEARED, SPECIALITY";

        $data = [
            'YEARED' => date('Y')
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        return $answer->fetchAll();;
    }

    public function getReports($year, $speccode, $forma)
    {
        $query1 = "
            SELECT DISTINCT
                UCD_FNREC, SPECIALITY, YEARED, DISCIPLINE, COMPILER, CREATEDATE, UPDATEDATE, STATUS
            FROM 
                RPD_LITERATURE
            WHERE
                SPECIALITYCODE = :SPECCODE
            AND
                YEARED = :YEARED
            AND
                FORMA = :FORMA
            AND 
                STATUS != 2
            ORDER BY
                YEARED, CREATEDATE";

        $data = [
            'SPECCODE' => $speccode,
            'YEARED' => $year,
            'FORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query1, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[0] = $answer->fetchAll();

        $query2 = "
            SELECT DISTINCT
                UCD_FNREC, FYEARED, SPECIALITY, DISCIPLINE, DISCODE 
            FROM 
                V_RPD_DISC
            WHERE
                FSPECIALITYCODE = :SPECCODE
            AND
                FYEARED = :YEARED
            AND DISCIPLINE NOT IN (
                SELECT DISTINCT
                    DISCIPLINE
                FROM 
                    RPD_LITERATURE
                WHERE
                    YEARED = :YEARED
                AND
                    FORMA = :FORMA
                AND 
                    SPECIALITYCODE = :SPECCODE
            )
            AND
                FORMA = :FORMA
            AND 
                DISCIPLINE NOT LIKE '%Экзамены по модулю%'
            AND 
                DISCIPLINE NOT LIKE 'дисциплина%'
            ORDER BY
                DISCIPLINE";


        $answer = $this->di->get('db')->query($query2, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[1] = $answer->fetchAll();

        $query3 = "
            SELECT DISTINCT
                UCD_FNREC, SPECIALITY, YEARED, DISCIPLINE, COMPILER, CREATEDATE, UPDATEDATE, STATUS
            FROM 
                RPD_LITERATURE
            WHERE
                SPECIALITYCODE = :SPECCODE
            AND
                YEARED = :YEARED
            AND
                FORMA = :FORMA
            AND 
                STATUS = 2
            ORDER BY
                YEARED, CREATEDATE";

        $answer = $this->di->get('db')->query($query3, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        $result[2] = $answer->fetchAll();
        return $result;
    }

    public function getReportsByNrec($year, $speccode, $forma)
    {
        $query = "
            SELECT
                UCD_FNREC
            FROM 
                RPD_LITERATURE
            WHERE
                SPECIALITYCODE = :SPECCODE
            AND
                YEARED = :YEARED
            AND
                FORMA = :FORMA
            AND
                STATUS = 10";

        $data = [
            'SPECCODE' => $speccode,
            'YEARED'    => $year,
            'FORMA' => $forma
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);

        return $answer->fetchAll();
    }

    public function getReport($ucd_fnrec)
    {
        $query = "
            SELECT 
                * 
            FROM 
                RPD_LITERATURE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $answer = $answer->fetchAll();

        $filename = fopen($answer[0]["DATAFILE"], "r");
        $line = "";
        while (!feof($filename)) {
            $line .= fgets($filename);
        }
        fclose($filename);

        $dataReport = unserialize($line);
        $answer[0]['ACTIVITY'] = $dataReport[0];
        $answer[0]['TLITERATURE'] = $dataReport[1];
        $answer[0]['ELITERATURE'] = $dataReport[2];

        $answer[0]['COUNTLITERATURE'] = (unserialize($answer[0]['COUNTLITERATURE']));

        return $answer;
    }

    public function successReport($ucd_fnrec, $compiler)
    {

        $query = "
            SELECT 
                DATAFILE 
            FROM 
                RPD_LITERATURE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $answer = $answer->fetchAll();

        $filename = fopen($answer[0]["DATAFILE"], "r");
        $line = "";
        while (!feof($filename)) {
            $line .= fgets($filename);
        }
        fclose($filename);

        //Расшифровываем библиографическую справку
        $dataReport = unserialize($line);
        $Activity = ($dataReport[0]);

        $Activity[count($Activity)] = [
            'Time'  =>  date("d-m-Y H:i:s"),
            'Activ' => $compiler,
            'Activiry'  =>  10,
            'Comment'   =>  'Принятие библиографической справки'
        ];

        $dataReport[0] = $Activity;
        $dataReport = serialize($dataReport);

        //Заносим данные в файл
        file_put_contents($answer[0]['DATAFILE'], $dataReport);

        $query = "
            UPDATE 
                RPD_LITERATURE
            SET
                STATUS  =   10,
                UPDATEDATE   =   :UPDATEDATE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UPDATEDATE' => date("d-m-Y"),
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
    }

    public function dangerReport($ucd_fnrec, $compiler, $message)
    {
        $query = "
        SELECT 
            DATAFILE 
        FROM 
            RPD_LITERATURE
        WHERE
            UCD_FNREC = :UCD_FNREC";

        $data = [
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $answer = $answer->fetchAll();

        $filename = fopen($answer[0]["DATAFILE"], "r");
        $line = "";
        while (!feof($filename)) {
            $line .= fgets($filename);
        }
        fclose($filename);

        //Расшифровываем библиографическую справку
        $dataReport = unserialize($line);
        $Activity = ($dataReport[0]);

        $Activity[count($Activity)] = [
            'Time'  =>  date("d-m-Y H:i:s"),
            'Activ' => $compiler,
            'Activiry'  =>  2,
            'Comment'   =>  $message
        ];


        $dataReport[0] = $Activity;
        $dataReport = serialize($dataReport);

        //Заносим данные в файл
        file_put_contents($answer[0]['DATAFILE'], $dataReport);


        $query = "
            UPDATE 
                RPD_LITERATURE
            SET
                STATUS  =   2,
                UPDATEDATE   =   :UPDATEDATE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UPDATEDATE' => date("d-m-Y"),
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
    }

    public function printReport($ucd_fnrec, $compiler, $mass = false)
    {
        $query = "
        SELECT 
            DATAFILE 
        FROM 
            RPD_LITERATURE
        WHERE
            UCD_FNREC = :UCD_FNREC";

        $data = [
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $answer = $answer->fetchAll();

        $filename = fopen($answer[0]["DATAFILE"], "r");
        $line = "";
        while (!feof($filename)) {
            $line .= fgets($filename);
        }
        fclose($filename);

        //Расшифровываем библиографическую справку
        $dataReport = unserialize($line);
        $Activity = ($dataReport[0]);

        $Activity[count($Activity)] = [
            'Time'  =>  date("d-m-Y"),
            'Activ' => $compiler,
            'Activiry'  =>  11,
            'Comment'   => ($mass) ? 'Печать в составе полной справки' : 'Печать'
        ];

        $dataReport[0] = $Activity;
        $dataReport = serialize($dataReport);

        //Заносим данные в файл
        file_put_contents($answer[0]['DATAFILE'], $dataReport);


        $query = "
            UPDATE 
                RPD_LITERATURE
            SET
                UPDATEDATE   =   :UPDATEDATE
            WHERE
                UCD_FNREC = :UCD_FNREC";

        $data = [
            'UPDATEDATE' => date("d-m-Y"),
            'UCD_FNREC' => $ucd_fnrec
        ];

        $answer = $this->di->get('db')->query($query, $data);
    }
}

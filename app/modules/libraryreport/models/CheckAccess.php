<?php

namespace Elios\Libraryreport\Models;

use Phalcon\Db as Db;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Query;

class CheckAccess extends Model
{

    //Сохранение новой БС в базе
    public function checkPPS($compiler)
    {
        $query = "
        SELECT 
            FNAIKAT
        FROM
            MV_PERSON_WORK
        WHERE 
            FFULLNAME = :FFULLNAME
        AND
            FNAIKAT = 'ППС'";

        $data = [
            'FFULLNAME' => $compiler
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $result = $answer->fetchAll();
        if ($result) {
            return 1;
        }
        return 0;
    }

    //Сохранение новой БС в базе
    public function checkLibrarian($librarian)
    {
        $query = "
        SELECT 
            FFULLNAME
        FROM
            MV_PERSON_WORK
        WHERE 
            FFULLNAME = :FFULLNAME
        AND 
            FCAPPOINTCUR IN (
                SELECT 
                    FCAPPOINTCUR 
                FROM 
                    SYST_SERVICES_ADMIN
                WHERE 
                    FCSERVICES = :FCSERVICES
            )";

        $data = [
            'FFULLNAME' => $librarian,
            'FCSERVICES' => 653
        ];

        $answer = $this->di->get('db')->query($query, $data);
        $answer->setFetchMode(Db::FETCH_ASSOC);
        $result = $answer->fetchAll();
        if ($result) {
            return 1;
        }
        return 0;
    }
}

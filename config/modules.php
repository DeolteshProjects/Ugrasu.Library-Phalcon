<?php

/**
 * Register application modules
 */

$application->registerModules(
    array(
        'libraryreport' => array( // Модуль библиографических справок
            'className' => 'Elios\Libraryreport\Module',
            'path'      => '../app/modules/libraryreport/Module.php',
        ),
    )
);

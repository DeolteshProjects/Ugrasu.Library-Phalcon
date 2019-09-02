<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Dialect\Oracle as Oracle;
use Phalcon\Db\Adapter\Pdo\Oracle as DbAdapter;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Http\Response;
use Phalcon\Breadcrumbs;

    // Create a DI
	$di = new FactoryDefault();

    // Роутинг для модулей подключаемый из файла routes
    $di->set('router', function () {
        require 'routes.php';
        return $router;
    });

	// Проверка событий при переходе
    $di->set('dispatcher', function () use ($di) {
        $eventsManager = new EventsManager;
        /**
         * Check if the user is allowed to access certain action using the SecurityPlugin
         */
        $eventsManager->attach('dispatch', new SecurityPlugin);
        $dispatcher = new Dispatcher;
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    });

    // Настраиваем сервис для работы с БД со схемой ELIOS
    $di->set('db', function() {
        return new DbAdapter(array(
         "dbname" => "(DESCRIPTION =
                        (ADDRESS_LIST =
                            (ADDRESS =
                                (PROTOCOL = TCP)
                                (HOST     = 192.168.100.18)
                                (PORT=1521)
                            )
                        )
                        (CONNECT_DATA = (SERVICE_NAME = gala)
                                        (FAILOVER_MODE = (TYPE = SELECT)
                                                         (METHOD = BASIC)
                                                         (RETRIES = 20)
                                                         (DELAY=5)
                                        )
                        )
                      )",

         "username" => "ELIOS",
         "password" => "watchdogsmopskoks647",
         "charset"  => "AL32UTF8",
         "dialectClass" => Oracle::class,
         "options" => [PDO::ATTR_CASE              => PDO::CASE_UPPER,
                       PDO::ATTR_PERSISTENT        => TRUE,
                       PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC]
        ));
    });

	// Настраиваем сервис для работы с БД со схемой ELIOS
	$di->set('db_finance', function() {
		return new DbAdapter(array(
		 "dbname" => "(DESCRIPTION =
						(ADDRESS_LIST =
							(ADDRESS =
								(PROTOCOL = TCP)
								(HOST     = 192.168.100.18)
								(PORT=1521)
							)
						)
						(CONNECT_DATA = (SERVICE_NAME = gala)
										(FAILOVER_MODE = (TYPE = SELECT)
														 (METHOD = BASIC)
														 (RETRIES = 20)
														 (DELAY=5)
										)
						)
					  )",

		 "username" => "ELIOS",
		 "password" => "watchdogsmopskoks647",
		 "charset"  => "AL32UTF8",
		 "dialectClass" => Oracle::class,
		 "options" => [PDO::ATTR_CASE              => PDO::CASE_UPPER,
					   PDO::ATTR_PERSISTENT        => TRUE,
					   PDO::ATTR_DEFAULT_FETCH_MODE=> PDO::FETCH_ASSOC]
		));
	});


    //Подключение мультимодульного шаблона volt
/*    $di->set('view', function () use (&$config) {

        $view = new View();
        $view->setPartialsDir('partials/');

        $view->registerEngines(
            ['.volt' =>  function ($view, $di) use ($config) {
                $volt = new Volt($view, $di);

                $volt->setOptions(array(
                    'compiledPath' => $config->application->cacheDir,
                    'compiledSeparator' => '_'
                ));
                return $volt;
            }]
        );
    },true);*/

	// Подключение сервиса для окон с ошибками
	$di->set('flash', function() {
    return new FlashSession(array(
        'error'   => 'callout alert',
        'success' => 'callout success',
        'notice'  => 'callout info',
        'warning' => 'callout warning'
	    ));
	});

    // Регистрируем пользовательский компонент для авторизации
    $di->set('Authorization', function () {
        return new Authorization();
    });

	// Старт сессии первый раз тогда, когда некий компонент запросит сервис сессий
	$di->set('session', function(){
	    $session = new Phalcon\Session\Adapter\Files();
	    $session->start();
	    return $session;
	});

    // Настраиваем базовый URI так, чтобы все генерируемые URI начинались от корня
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/');
        return $url;
    });

    //Компонент для breadcrumbs, являющийися совместным
    $di->setShared('breadcrumbs', function () {
        return new Breadcrumbs();
    });

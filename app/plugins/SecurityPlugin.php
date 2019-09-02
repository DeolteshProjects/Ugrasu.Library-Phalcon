<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

class SecurityPlugin extends Plugin
{

    public function getAcl()
    {

        if (!isset($this->persistent->acl)) {
            // Создаём новый access лист
            $acl = new AclList();
            // Указываем "запрещено" по умолчанию для тех объектов, которые не были занесены в список контроля доступа
            $acl->setDefaultAction(Acl::DENY);

            // Получение и регистрация всех ролей в системе
            $allRoles = new Elios\Auth\Models\Roles();
            $allRolesUsers = $allRoles->getAllRoles();
            foreach ($allRolesUsers as $role) {
                $role = new Role($role);
                $acl->addRole($role);
            }

            //Определяем доступные ресурсы для SuperVisora(1)
            require 'aclList/Supervisor.php';

            // Определяем доступные ресурсы для Administrator(2)
            require 'aclList/Administrator.php';

            // Определяем доступные ресурсы для Руководителей университета (3)
            require 'aclList/Rector.php';

            // Определяем доступные ресурсы для руководителей института (4)
            require 'aclList/Director.php';

            // Определяем доступные ресурсы для руководителей высшых школ (9)
            require 'aclList/HighSchoolLeader.php';

            // Определяем доступные ресурсы для менеджера/руководителя ООП (5)
            require 'aclList/Manager.php';

            // Определяем доступные ресурсы для тьюторов (10)
            require 'aclList/Tutor.php';

            // Определяем доступные ресурсы для Participant of the education process(6)
            require 'aclList/PartEP.php';

            // Определяем доступные ресурсы для сотрудника Employee (7)
            require 'aclList/Employee.php';

            // Определяем доступные ресурсы для Student(8)
            require 'aclList/Student.php';

            // Руководитель университета
            // Руководитель института
            // Менеджер/руководитель ООП ПП

            $this->persistent->acl = $acl;
        }
        return $this->persistent->acl;
    }

    public function afterExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerName();

        // Проверяем авторизован ли пользователь в системе
        if ($this->session->has("login")) {
            // Получаем наименование модулей, контроллеров и действий
            $module = $dispatcher->getModuleName();
            $action = $dispatcher->getActionName();
            $unionModuleWithController = $module . "/" . $controller;

            // Получаем текущие данные пользователя
			$userInfo = $this->session->get("user_info");
            $currentUser = $this->session->get("current_appoint");
			$roleName = $userInfo[$currentUser]['ROLESENGNAME'];
            $roleUserId = $userInfo[$currentUser]['ROLES'];
            // $roleNameGenetive = $userInfo[$currentUser]['FGENITIVENAME'];

            // print_r($userInfo);

            // Проверяем доступные роли для данного пользователя
            $acl = $this->getAcl();
            $allowed = $acl->isAllowed($roleName, $module, $controller . $action);
						
            // Проверяем есть ли у пользователя права для доступа к данной директории и не находится ли он на странице с ошибкой
            // и не использует ли он глаз саурона, после которого происходит редирект
            if ($allowed != Acl::ALLOW && $controller != "error" && $action != "erroraccess" && $action != "eyesauron" && $action != "closeeyesauron") {
                return $this->response->redirect('/error/erroraccess');
			}
		}
        // Если пользователь не авторизован перебрасываем на страницу авторизации
        else if ($controller != "signup") {
            return $this->response->redirect("/auth/signup/index");
        }

        return false;

    }
}

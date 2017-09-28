<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use \rmrevin\yii\module\Comments\Permission;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;
        
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...
        
        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $editor = $auth->createRole('editor');
        $user = $auth->createRole('user');
        
        // запишем их в БД
        $auth->add($admin);
        $auth->add($editor);
        $auth->add($user);
        
        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';
        
        $updateNews = $auth->createPermission('updateNews');
        $updateNews->description = 'Редактирование новости';

        $createComments = $auth->createPermission(Permission::CREATE);
        $createComments->description = 'Can create own comments';

        $updateComments = $auth->createPermission(Permission::UPDATE);
        $updateComments->description = 'Can update own comments';

        $updateOwnComments = $auth->createPermission(Permission::UPDATE_OWN);
        $updateOwnComments->description = 'Can update own comments';

        $deleteComments = $auth->createPermission(Permission::DELETE);
        $deleteComments->description = 'Can delete all comments';

        $deleteOwnComments = $auth->createPermission(Permission::DELETE_OWN);
        $deleteOwnComments->description = 'Can delete own comments';
        
        // Запишем эти разрешения в БД 
        $auth->add($viewAdminPage);
        $auth->add($updateNews);
        $auth->add($createComments);
        $auth->add($updateComments);
        $auth->add($updateOwnComments);
        $auth->add($deleteComments);
        $auth->add($deleteOwnComments);
        
        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage
        
        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($editor, $createComments);
        $auth->addChild($editor, $updateOwnComments);
        $auth->addChild($editor, $deleteOwnComments);
        $auth->addChild($editor,$updateNews);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $editor);

        $auth->addChild($admin, $viewAdminPage);
        $auth->addChild($admin, $deleteComments);
        $auth->addChild($admin, $updateComments);

        $auth->addChild($user, $createComments);
        $auth->addChild($user, $updateOwnComments);
        $auth->addChild($user, $deleteOwnComments);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 3); 
        
        // Назначаем роль editor пользователю с ID 2
        $auth->assign($editor, 2);
        $auth->assign($user, 1);
    }
}
<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User; // Ensure you have this import for the User model

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Удаляем все старые данные
        $auth->removeAll();

        // Создаем роли
        $admin = $auth->createRole('admin');
        $user = $auth->createRole('user');

        // Добавляем роли в систему
        $auth->add($admin);
        $auth->add($user);

        // Назначаем права
        $auth->assign($admin, 7); // Назначаем роль 'admin' пользователю с ID 7

        // Assign 'user' role to all existing users
        $users = User::find()->all();
        foreach ($users as $userModel) {
            // Check if the user already has a role assigned
            if (!$auth->getAssignments($userModel->id)) {
                $auth->assign($user, $userModel->id);
            }
        }
    }
}

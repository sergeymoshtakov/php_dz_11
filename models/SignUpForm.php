<?php
namespace app\models;

use yii\base\Model;
use app\models\User;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            [['username', 'email'], 'unique', 'targetClass' => 'app\models\User'],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = 'user';
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                return $user; // Возвращаем объект пользователя, если сохранение успешно
            }
        }

        return null; // Возвращаем null в случае ошибки или невалидных данных
    }
}

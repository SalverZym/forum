<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use app\models;

class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass'=> User::className()]
        ];
    }

    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }


        $user = new User();
        $user_status=new User_status();
        $user->username = $this->username;
        $user->password=\Yii::$app->security->generatePasswordHash($this->password);
        $user->email=$this->email;
        if(!$user->save()){
            return null;
        }
        $user_status->user_id=$user->id;
        $user_status->date=date("Y-m-d H:i:s");
        if(!$user_status->save()){
            return null;
        }
        return $user;
    }
}
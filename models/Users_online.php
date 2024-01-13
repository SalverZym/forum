<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Users_online extends ActiveRecord
{
    public static function collectionName()
    {
        return 'users_online';
    }

    public function attributes()
    {
        return ['_id', 'id', 'name'];
    }
}
<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Notifications extends ActiveRecord
{
    public static function collectionName()
    {
        return 'notifications';
    }

    public function attributes()
    {
        return ['_id', 'from_id', 'to_id', 'from_name', 'status','date'];
    }
}
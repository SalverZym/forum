<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Frend_list extends ActiveRecord
{
    public static function collectionName()
    {
        return 'frend_list';
    }

    public function attributes()
    {
        return ['_id', 'user_id', 'frends'];
    }
}
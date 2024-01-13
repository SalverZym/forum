<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comments extends ActiveRecord
{
    public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'string', ],
        ];
    }
}
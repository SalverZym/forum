<?php

namespace app\models;

use yii\db\ActiveRecord;

class Meseges extends ActiveRecord
{
    public function rules()
    {
        return [['text', 'required']];
    }
}
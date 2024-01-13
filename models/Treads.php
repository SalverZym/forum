<?php

namespace app\models;

use yii\db\ActiveRecord;

class Treads extends ActiveRecord
{
    public function rules()
    {
        return [
            ['tread_name', 'required'],
            ['tread_name', 'string', 'length'=>[4,24]],

        ];
    }


    public function getUsertread(){
        return $this->hasOne(Usertread::className(), ['id'=>'tread_id']);
    }


}
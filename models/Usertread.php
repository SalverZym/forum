<?php

namespace app\models;

use yii\db\ActiveRecord;

class Usertread extends ActiveRecord
{
    public function getTreads(){
        return $this->hasOne(Treads::className(), ['tread_id'=>'id']);
    }
}
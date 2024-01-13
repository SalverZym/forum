<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions'=> 'jpg', 'skipOnEmpty'=>true],
        ];
    }

    public function upload($name){
        if($this->validate()){
            $this->image->saveAs('images/'.$name. '.' . $this->image->extension);
            return true;
        }else{
            return false;
        }
    }

}
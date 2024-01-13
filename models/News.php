<?php

namespace app\models;

use yii\base\Model;


class News extends Model
{
    public $heading;
    public $text;

    public function rules()
    {
        return [
            [['heading', 'text'], 'required'],
            [['heading'], 'string' ,'max'=>15, 'min'=>5],
            [['text'], 'string' ,'max'=>60 , 'min'=>5],
        ];
    }

    public function addNews(){

        $id_hash=\Yii::$app->getSecurity()->generateRandomString(8);

        $news_text=new News_text();
        $news_text->id=$id_hash;
        $news_text->text="$this->text";
        $news_text->save();

        $collection=\Yii::$app->mongodb->getCollection('News');
        $collection->insert([
            'text'=>"$this->heading",
            'user_id'=>\Yii::$app->user->id,
            'date'=>date("Y-m-d"),
            'likes'=>array(),
            'news_id'=>"$id_hash",
        ]);


    }
}
<?php

namespace app\controllers;

use app\models\News_text;
use yii\web\Controller;

class TextController extends Controller
{
    public function actionShow($id){

        $new_text=News_text::findOne($id);
        return $this->render('text', compact('new_text'));
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['show'],
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ]
            ]
        ];
    }
}
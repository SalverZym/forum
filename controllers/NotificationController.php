<?php

namespace app\controllers;

use app\models\Notifications;
use yii\mongodb\Query;
use yii\web\Controller;
use yii\web\Response;

class NotificationController extends Controller
{
    public function actionShow($id){
        $notifications=(new Query())
            ->select(['from_id', 'from_name', 'to_id', 'date'])
            ->from("notifications")
            ->where(['to_id'=>"{$id}"])
            ->all();
        $collection = \Yii::$app->mongodb->getCollection('notifications');
        $collection->update(
            ['status'=>"unread"],
            ['$set'=>['status'=>"read"]],
            ['multiple' => false]
        );

        return $this->render('list', compact('notifications'));
    }

    public function actionAddfrend($id){
        $this->updateFrendList($id, \Yii::$app->user->id);
        $this->updateFrendList(\Yii::$app->user->id, $id);
        $this->delete($id);
    }

    public function actionDeletefrend($id){
        $collection = \Yii::$app->mongodb->getCollection('frend_list');
        $collection->update(
            ['user_id'=>\Yii::$app->user->id],
            ['$pull'=>['frends'=>"$id"]],
            ['multiple' => false]
        );
    }

    public function actionDecline($id){
        $this->delete($id);
    }

    private function delete($id){
        $collection = \Yii::$app->mongodb->getCollection('notifications');
        $collection->remove(['from_id'=>"{$id}", 'to_id'=>(string)\Yii::$app->user->id]);
    }

    private function updateFrendList($user_id, $frend_id){
        $collection = \Yii::$app->mongodb->getCollection('frend_list');
        if(!($collection->find(['user_id'=>"$user_id"]))){
            $collection->insert(['user_id'=>"$user_id", "frends"=>[]]);
        }
        $collection->update(
            ['user_id'=>"$user_id"],
            ['$push'=>['frends'=>$frend_id]],
            ['multiple' => false]
        );
    }

    public function actionUnreadnot(){
        $count=Notifications::find()->where(['to_id'=>(string)\Yii::$app->user->id, 'status'=>'unread'])->count();

        \Yii::$app->response->format=Response::FORMAT_JSON;
        return ['count'=>$count];

    }

}
<?php

namespace app\controllers;

use app\models\Frend_list;
use app\models\Meseges;
use app\models\User;
use app\models\User_online;
use yii\db\Query;
use yii\web\Controller;
use yii\mongodb\Collection;
use yii\redis;
use Exception;
use MongoDB\Client;
use MongoDB\Driver\ServerApi;
use yii\mongodb;

class MessengerController extends Controller
{
    public function actionShow($id=null)
    {
        if(\Yii::$app->request->isAjax && \Yii::$app->request->isPost){
            $mesegess=\Yii::$app->request->post('Meseges');
            $new_tex=$mesegess['text'];
            $new_messege=new Meseges();
            $new_messege->text=$new_tex;
            $new_messege->id_from=\Yii::$app->user->id;
            $new_messege->id_to=$id;
            $new_messege->date=date("Y-m-d H:i:s");
            if($new_messege->validate()){
                $new_messege->save();
            }
        }

        if(!$id){
            $meseges=null;
            $user_to=null;

        }else{
            $meseges=Meseges::find()
                ->where(['or', ['and', "id_from=".\Yii::$app->user->id."", "id_to=$id"], ['and', "id_from=$id", "id_to=".\Yii::$app->user->id.""]])
                ->all();
            $user_to=User::findOne($id);
            Meseges::updateAll( ["status"=>"read"],['and', 'id_to='.\Yii::$app->user->id.'', "id_from=$id", 'status="unread"']);
        }

        $frend_id=(new mongodb\Query())
            ->select(['frends'])
            ->from('frend_list')
            ->where(['user_id'=>\Yii::$app->user->id])
            ->one();
        $frend_id=implode(',', $frend_id['frends']);



        $frends=\Yii::$app->db->createCommand("SELECT username, id,
  (SELECT text FROM meseges WHERE (id_from=".\Yii::$app->user->id." AND id_to=user.id OR (id_from=user.id) AND id_to=".\Yii::$app->user->id.") ORDER BY date DESC LIMIT 1) AS last, 
  (SELECT COUNT(*) FROM meseges WHERE status='unread' AND (id_from=".\Yii::$app->user->id." AND id_to=user.id) OR (id_from=user.id AND id_to=".\Yii::$app->user->id.") ORDER BY date DESC LIMIT 1 ) AS count FROM user WHERE user.id IN ($frend_id)")
        ->queryAll();

        $mesege=new Meseges();
        $user_from=User::findOne(\Yii::$app->user->id);

        return $this->render('chat', compact('meseges', 'user_from', 'user_to', 'mesege', 'frend_id', 'frends'));
    }


}
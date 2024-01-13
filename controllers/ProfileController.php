<?php

namespace app\controllers;

use app\models\Notifications;
use yii\web\Controller;
use app\models\User;
use app\models\User_status;
use app\models\UploadForm;
use yii\web\UploadedFile;

class ProfileController extends Controller
{
    public function actionShow($id){
        $user=User::findOne($id);
        $user_status=User_status::findOne($id);
        return $this->render('profile', compact('user', 'user_status'));
    }

    public function actionChange($id){

        $user=User::findOne($id);
        $user_status=User_status::findOne($id);
        $user_img= new UploadForm();


        if(\Yii::$app->request->isPost){

            $user_img->image=UploadedFile::getInstance($user_img, 'image');
            if($user_img->image){
                if(!$user_img->upload($id)){
                    return false;
                }
                $user_status->img=$id.$user_img->image->extension;
                $user_status->save();
            }

            if($user->load(\Yii::$app->request->post()) && $user->validate()){
                $user->save();
                return $this->render('change', compact('user', 'user_status', 'user_img'));
            }
            var_dump($user->getErrors());

        }

        return $this->render('change', compact('user', 'user_status', 'user_img'));
    }

    public function actionAddnotification($id){

        $notification=new Notifications();
        $notification->from_id=(string)\Yii::$app->user->id;
        $notification->from_name=User::findOne($id)['username'];
        $notification->to_id="{$id}";
        $notification->status="unread";
        $notification->date=date("Y-m-d H:i:s");
        $notification->save();

    }

    public function actionDeletenotification($id){
        $collection = \Yii::$app->mongodb->getCollection('notifications');
        $collection->remove(['from_id'=>(string)\Yii::$app->user->id, 'to_id'=>"{$id}"]);
    }
}
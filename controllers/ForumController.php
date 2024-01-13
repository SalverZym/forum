<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Tread_comments;
use app\models\Treads;
use app\models\User_online;
use app\models\Usertread;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\mongodb;
use yii\mongodb\Command;
use yii\mongodb\Collection;

class ForumController extends Controller
{
    public function actionShow(){
        $user_tread=Usertread::find()
            ->select(['*'])
            ->all();
        $treads=Treads::find()
            ->select(['*'])
            ->innerJoin('usertread', 'usertread.tread_id=treads.id')
            ->with('usertread')
            ->all();

        $posts=\Yii::$app->db
            ->createCommand('SELECT * FROM `treads` INNER JOIN `usertread` ON usertread.tread_id=treads.id
                                                        INNER JOIN `user` ON user.id=usertread.user_id
                                                        INNER JOIN `user_status` ON user.id=user_status.user_id')
            ->queryAll();


        $collection=\Yii::$app->mongodb->getCollection('users_online');
        $count=$collection->count();
        $users_online=(new mongodb\Query())
            ->select(['id', 'username'])
            ->from('users_online')
            ->limit(5)
            ->all();

        return $this->render('forum', compact('treads', 'posts', 'count', 'users_online'));
    }

    public function actionCreate()
    {
        $treads=new Treads();
        $user_tread=new Usertread();
        $comments=new Comments();
        $tread_comments= new Tread_comments();

        if(($treads->load(\Yii::$app->request->post()) && $treads->validate()) && ($comments->load(\Yii::$app->request->post()) && $comments->validate())){
            $treads->date=date("Y-m-d H:i:s");
            $treads->save();
            $comments->date=date("Y-m-d H:i:s");
            $comments->id_user=\Yii::$app->user->id;
            $comments->save();
            $user_tread->tread_id=$treads->id;
            $user_tread->user_id=\Yii::$app->user->id;
            $user_tread->save();
            $tread_comments->id_tread=$treads->id;
            $tread_comments->id_comment=$comments->id;
            $tread_comments->save();
        }

        return $this->render('create', compact('treads', 'user_tread', 'comments'));
    }
}
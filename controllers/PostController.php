<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Likes;
use app\models\Tread_comments;
use app\models\Treads;
use app\models\User_status;
use app\models\Usertread;
use yii\web\Controller;

class PostController extends Controller
{


    public function actionView($id){
        $comment=new Comments();
        if($comment->load(\Yii::$app->request->post()) && $comment->validate()){
            $t_c= new Tread_comments();
            $comment->id_user=\Yii::$app->user->id;
            $comment->date=date("Y-m-d H:i:s");
            $comment->save();
            $t_c->id_tread=$id;
            $t_c->save();
        }

        $treadid=$id;
        $comments=self::makeQuery($id);

        return $this->render('post', compact('treadid', 'comments', 'comment'));
    }

    public function actionChange($id ,$change ,$treadid)
    {

        if($change>0){
            $likes=new Likes();
            $likes->id_comment=$id;
            $likes->id_user=\Yii::$app->user->id;
            $likes->save();
        }else{
            $like=Likes::findOne($id);
            $like->delete();
        }
        $com=Comments::findOne($id);
        $com->reiting+=$change;
        $com->save();
        $user=User_status::findOne(\Yii::$app->user->id);
        $user->reating+=$change;
        $user->save();
        $comments=self::makeQuery($treadid);
        $comment=new Comments();

        return ;
    }

    static function makeQuery($id){
        $queryy="SELECT user.username, tread_comments.* ,comments.*, user_status.img, likes.id_user FROM `tread_comments` INNER JOIN `comments` ON tread_comments.id_comment=comments.id 
                                                      INNER JOIN `user_status` ON user_status.user_id=comments.id_user
                                                      INNER JOIN  `user` ON  user.id=comments.id_user ";
        if(\Yii::$app->user->id){
            $userid=\Yii::$app->user->id;
            $queryy.="LEFT JOIN `likes` ON likes.id_comment=comments.id ";
        }
        $queryy.="WHERE tread_comments.id_tread ={$id}";
        if(\Yii::$app->user->id){
            $queryy.=" AND (likes.id_user={$userid} OR likes.id_user IS NULL )";
        }

        return \Yii::$app->db->createCommand($queryy)->queryAll();
    }
}
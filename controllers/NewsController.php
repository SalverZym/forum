<?php

namespace app\controllers;

use app\models\News;
use app\models\News_text;
use yii\web\Controller;
use yii\mongodb\Query;
use function React\Promise\all;

class NewsController extends Controller
{
    public function actionNews(){

        $new_news= new News();

        if(\Yii::$app->request->isAjax){
            if($new_news->load(\Yii::$app->request->post()) && $new_news->validate()){
                $new_news->addNews();
            }
        }

        $frends_raiting=(new Query())
            ->select(['frends_raiting'])
            ->where(['user_id'=>(int)\Yii::$app->user->id])
            ->from('frend_list')
            ->all();

        $all_news=array();

        foreach ($frends_raiting[0]['frends_raiting'] as $k => $v){
            if($v!= null) {
                $news_s = (new Query())
                    ->select(['text', 'user_id', 'date', 'likes', 'news_id'])
                    ->where(['user_id' => $v])
                    ->from('News')
                    ->all();
                $all_news=array_merge($all_news, $news_s);
            }
        };

        $date=array();

        foreach ($all_news as $k=>$v){
            $date[$k]=$v['date'];
        }

        for($i=0; $i<100000; $i++){
            $date_tmp=$all_news;
            array_multisort($date, SORT_NUMERIC, SORT_DESC, $date_tmp);
        }

        $date_tmp=array_reverse($date_tmp);

        return $this->render('news_list', compact( 'new_news', 'date_tmp'));
    }

    public function actionChange($id ,$change){

        $collection=\Yii::$app->mongodb->getCollection('News');
        $frends_likes=\Yii::$app->mongodb->getCollection('frend_list');
        $user_id=(new Query())
            ->select(['user_id'])
            ->from('News')
            ->where(['news_id'=> (string)$id])
            ->one();

        if($change>0){
            $collection->update(
                ['news_id'=>(string)$id],
                ['$push'=>['likes'=>\Yii::$app->user->id]],
                ['multiple' => false]
            );
            $frends_likes->update(
                ['user_id' => \Yii::$app->user->id, 'frends_likes.id' => $user_id['user_id']],
                ['$inc'=>['frends_likes.$.likes'=>1]],
                ['multiple' => false]
            );
        }else{
            $collection->update(
                ['news_id'=>(string)$id],
                ['$pull'=>['likes'=>\Yii::$app->user->id]],
                ['multiple' => false]
            );
            $frends_likes->update(
                ['user_id' => \Yii::$app->user->id, 'frends_likes.id' => $user_id['user_id']],
                ['$inc'=>['frends_likes.$.likes'=>-1]],
                ['multiple' => false]
            );
        }

        $this->changeRaiting($user_id['user_id']);

    }

    private function changeRaiting($user_id){

        $count_news=(new Query())
            ->from('News')
            ->where(['user_id'=>$user_id])
            ->count();
        $query=(new Query())->select(['frends_likes'])->from('frend_list')->where(['user_id'=>\Yii::$app->user->id])->one();
        $likes_count=null;

        foreach ($query['frends_likes'] as $k=>$v){
            if($v['id']==$user_id){
                $likes_count=$v['likes'];
                break;
            }
        }

        $ratio=$likes_count/($count_news/100);

        if($ratio<=20){
            $rating=5;
        }elseif ($ratio<=40){
            $rating=4;
        }elseif ($ratio<=60){
            $rating=3;
        }elseif ($ratio<=80){
            $rating=2;
        }else{
            $rating=1;
        }

        $document = \Yii::$app->mongodb->getCollection('frend_list')->findOne(['user_id' => \Yii::$app->user->id]);
        foreach ($document['frends_raiting'] as &$subarray) {
            $subarray = array_diff($subarray, [$user_id]);
        }
        $document['frends_raiting'][$rating][]=$user_id;

        \Yii::$app->mongodb->getCollection('frend_list')->update(['user_id' => \Yii::$app->user->id], $document);

    }


}
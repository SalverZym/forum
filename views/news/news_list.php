<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<?php Pjax::begin([
    'id' => 'news_form',
    'scrollTo'=>false,
    'timeout'=>3000,
]);?>

<?php $form=\yii\widgets\ActiveForm::begin([
        'id'=>'create',
        'action'=>'',
        'method'=>'post',
        'enableAjaxValidation' => false,
        'options'=>[
                'class' => 'form-horizontal',
                'data-pjax'=> true
        ],
]);?>
    <?= $form->field($new_news, 'heading')->textInput()->label('Заголовок');?>
    <?= $form->field($new_news, 'text')->textarea()->label('Текст статьи');?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

<?php \yii\widgets\ActiveForm::end()?>
<?php Pjax::end();?>

<div class="posts-table">
    <?php foreach ($date_tmp as $k=>$v):?>
        <div class="table-row">
            <div class="subjects">
                <?= Html::a( $v['text'], ['text/show', 'id' => $v['news_id']], ['class' => 'profile-link']) ?>
                <br>
                <button data-id="<?=$v['news_id']?>" class="btn plus<?php if(array_search((int)\Yii::$app->user->id,$v['likes'])!==false):;?> active <?php endif;?>"><i class="fa-regular fa-thumbs-up"></i></button>
                <div><?=count($v['likes'])?></div>
                <span>Started by <b><a href="">User</a></b> .</span>
            </div>
        </div>
    <?php endforeach;?>
</div>

<?php
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;

?>


<div class="posts-table">
    <?php foreach ($comments as $k=>$v):?>
    <div class="table-row">
        <div class="status"><img src="/images/<?=$v['id_user'];?>" width="100px" height="100px">
        <?php echo Html::a("{$v['username']}" ,['/profile/show', 'id'=>$v['id_user']],['class'=>'nav-link']);?>
        </div>
            <div class="subjects">
                <div><?=$v['text']?></div>
                <br>
                <button data-id="<?=$v['id_comment']?>" data-content="<?=$treadid?>" class="btn plus<?php if($v['id_user']):;?> active <?php endif;?>"><i class="fa-regular fa-thumbs-up"></i></button>
                <div><?=$v['reiting']?></div>
                <button id="<?=$v['id_comment']?>" class="btn minus"><i class="fa-regular fa-thumbs-down"></i></button>
                <span>Started by <b><a href="">User</a></b> .</span>
            </div>

    </div>
     <?php endforeach;?>

</div>

<?php if(!Yii::$app->user->isGuest):;?>
    <?php $form=\yii\widgets\ActiveForm::begin([
        'id'=>'comment-post',
        'options'=>['class' => 'form-horizontal'],
    ]
    );?>
    <?=$form->field($comment, 'text')->textarea();?>

    <?= Html::submitButton('Ответить' );?>

    <?php \yii\widgets\ActiveForm::end();?>
<?php endif;?>






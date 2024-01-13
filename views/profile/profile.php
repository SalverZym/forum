<?php
use app\models\User_status;
use app\models\User;
use yii\bootstrap4\Html;
?>

<?php echo $user->username;?><br>
<?php echo $user_status->date;?><br>
<?php echo $user_status->count_comment;?><br>
<?php echo $user_status->reating;?><br>
<?php if(!$user_status->is_admin):?>
    <div>Пользователь</div>
<?php else:?>
    <div>Администратор</div>
<?php endif;?>

<img src="/images/<?=$user_status->img;?>" width="100px" height="100px">
<?php if($user->id == Yii::$app->user->id):?>
    <?php echo Html::a('Изменить' ,['/profile/change', 'id'=>Yii::$app->user->id], ['class'=>'nav-link']);?>
<?php else:;?>
    <?php if(!Yii::$app->user->isGuest):?>
        <?php echo Html::a('Написать сообщение' ,['/messenger/show', 'id'=>$user->id], ['class'=>'nav-link']);?>
        <?php if(!(\yii\helpers\NotificationsHelper::Check('notifications', array('from_id'=>(string)Yii::$app->user->id, 'to_id'=>(string)$user->id)))):?>
            <div id="addnotif" class="btn btn-primary" data-content="<?= $user->id;?>">Добавить в друзья</div>
        <?php else:?>
            <div id="deletenotif" class="btn btn-primary" data-content="<?= $user->id;?>">Отменить заявку</div>
        <?php endif;?>

    <?php endif;?>
<?php endif;?>






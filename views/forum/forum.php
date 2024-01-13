<?php
use yii\bootstrap4\Html;
?>
<h5>Форум</h5>
<?php if(!Yii::$app->user->isGuest):;?>
    <?php echo Html::a('Создать тему',['/forum/create'], ['class'=>'nav-link']);?>
<?php endif;?>
<div class="posts-table">
    <div class="table-head">
        <div class="status" >Status</div>
        <div class="subjects">Subjects</div>
        <div class="replies">Replies/Views</div>
        <div class="last-reply">Last Reply</div>
    </div>
    <?php foreach($posts as $k=>$v):?>
    <?php /*echo $v['id'];*/?><!--
        <?php /*echo $v['count_comment'];*/?>
        --><?php /*echo $v['tread_name'];*/?>
    <div class="table-row">
        <div class="status"><i class="fa fa-fire"></i></div>
        <div class="subjects">
            <?= Html::a("{$v['tread_name']}", ['/post/view', 'id' => $v['tread_id']], ['class' => 'profile-link']) ?>
            <span>Создано:<?= Html::a("{$v['username']}", ['/profile/show', 'id' => $v['user_id']], ['class' => 'profile-link']) ?></span>
            <span>Дата <?=$v['date']?>.</span>
        </div>
        <div class="replies">
            <?=$v['count_comment']?> <br> 125 views
        </div>
        <div class="last-reply">
            Oct 12 2021
            <br>By <b><a href="">User</a></b>
        </div>
    </div>
    <? endforeach;?>
</div>
<div class="forum component-block">
    <div class="component-block__title subtitle-global">
        Пользователей онлайн:<?=$count;?>
    </div>
    <ul class="">
        <?php foreach ($users_online as $k=>$v):?>
        <li class="forum__item">
            <a class="" href="<?= \yii\helpers\Url::toRoute(['/profile/show', 'id'=>$v['id']]);?>">
                <?= $v['username'];?>
            </a>
        </li>
        <?php endforeach;?>
    </ul>
</div>





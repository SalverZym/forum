<?php foreach ($notifications as $k=>$v):?>
    <div>
        <?= \yii\helpers\Html::a("{$v['from_name']}", ['/profile/show', 'id'=>$v['from_id'], ['class'=>'nav-link']]);?> хочет добавить вас в друзья
    </div>
    <div>
        <div id="addfrend" class="btn btn-primary" data-content="<?=$v['from_id'];?>">Добавить</div>
        <div id="decline" class="btn btn-primary" data-content="<?=$v['from_id'];?>">Отклонить</div>
    </div>
<?php endforeach;?>

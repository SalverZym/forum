<?php
use yii\bootstrap4\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
?>

<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <?php Pjax::begin([
                        'id'=>'frend_list',
                        'scrollTo'=>false
                ]);?>
                <?php foreach ($frends as $k=>$v):?>
                    <div class="user-container" data-id="<?=$v['id']?>">
                        <div class="user"><?=$v['username']?></div>
                        <?php if(\yii\helpers\NotificationsHelper::Check("users_online", ['id'=>$v['id']])):?>
                            <div>Online</div>
                        <?php else:?>
                            <div>Ofline</div>
                        <?php endif;?>
                        <?php if($v['last']!=null):?>
                            <div><?= $v['last'];?></div>
                            <?php if($v['count']):?>
                                <div><?= $v['count'];?></div>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                <?php endforeach;?>
                <?php Pjax::end();?>
                <div class="chat">
                    <?php Pjax::begin([
                        'id' => 'select_pjax1',
                        'scrollTo'=>false,
                        'timeout'=>3000,
                    ]);?>
                    <?php Pjax::begin([
                        'id' => 'select_pjax2',
                        'scrollTo'=>false,
                        'timeout'=>3000,
                    ]);?>
                    <div class="chat-header clearfix">

                        <div class="row">
                            <?php if($user_to):?>
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0"><?= $user_to->username;?></h6>
                                    <small>Last seen: 2 hours ago</small>
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="col-lg-6 hidden-sm text-right">
                                <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history">
                        <ul class="m-b-0">
                            <?php if($meseges):?>
                            <?php foreach ($meseges as $k=>$v):?>
                            <li class="clearfix">
                                <?php if($v['id_from']!=\Yii::$app->user->id):?>
                                    <?php $c="text-right";?>
                                    <?php $d="other-message float-right";?>
                                    <?php $b="";?>
                                <?php else:?>
                                    <?php $c="";?>
                                    <?php $d="my-message";?>
                                    <?php if($v['status']=="read"):?>
                                        <?php $b="<span class='message-data-time'>Прочитано</span>";?>
                                    <?php elseif($v['status']=="unread"):?>
                                        <?php $b="<span class='message-data-time'>Не прочитано</span>";?>
                                    <?php endif;?>
                                <?php endif;?>
                                <div class="message-data <?=$c?>">
                                    <span class="message-data-time"><?= $v['date'];?></span>
                                    <?= $b;?>
                                </div>
                                <div class="message <?=$d?>"><?= $v['text'];?></div>
                            </li>
                            <?php endforeach;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <?php Pjax::end();?>
                    <?php if($user_to):?>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <?php $form=ActiveForm::begin([
                                'id'=>'target',
                                'action'=>'',
                                'method'=>'post',
                                'enableAjaxValidation' => false,
                                'options'=>['data-pjax'=> true],
                            ]);;?>
                            <div class="input-group-prepend">
                                <?= Html::submitButton( 'Отправить', ['class'=>'input-group-text']);?>
                            </div>
                            <?=$form->field($mesege, 'text')->textInput(['class'=>'form-control'])?>
                            <?php ActiveForm::end();?>
                        </div>
                    </div>
                    <?php Pjax::end();?>
                    <?php else:?>
                        <div>Выберите чат</div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>



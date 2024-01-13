<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title='registration';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form= \yii\widgets\ActiveForm::begin([
        'id'=>'register-form',
        'options'=>['class'=>'form-horizontal'],
])?>
    <?= $form->field($model, 'username' ,['template' => "{label}\n <div class='col-md-5'>{input} </div>
\n <div class='col-md-5'>{hint} </div>\n <div class='col-md-5'>{error} </div>"])->textInput(['autofocus' => true])->label('Логин')?>
    <?= $form->field($model, 'password' ,['template' => "{label}\n <div class='col-md-5'>{input} </div>
\n <div class='col-md-5'>{hint} </div>\n <div class='col-md-5'>{error} </div>"])->passwordInput()->hint('Пароль должен быть сложным')?>
    <?= $form->field($model, 'email', ['template' => "{label}\n <div class='col-md-5'>{input} </div>
\n <div class='col-md-5'>{hint} </div>\n <div class='col-md-5'>{error} </div>"])?>

    <div class="form-group">
        <div class="col-lg-11">
            <?= Html::submitButton('Регистрация',['class'=>'btn btn-primary'])?>
        </div>
    </div>

<?php $form= \yii\widgets\ActiveForm::end()?>

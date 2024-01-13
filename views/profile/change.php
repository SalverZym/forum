<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

$form=ActiveForm::begin([
    'id'=>'user-change',
    'options'=>['class' => 'form-horizontal'],
]);
?>

<?=$form->field($user, 'username')?>
<?=$form->field($user, 'email')?>
<?=$form->field($user, 'password')?>
<?=$form->field($user_img, 'image')->fileInput()?>

<?= Html::submitButton('Сохранить', ['class'=>'btn btn-primary'])?>

<?= $form->errorSummary($user); ?>

<?php ActiveForm::end()?>

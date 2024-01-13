<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

$form=ActiveForm::begin([
    'id'=>'user-change',
    'options'=>['class' => 'form-horizontal'],
]);
?>

<?=$form->field($treads, 'tread_name')->textInput()?>
<?=$form->field($comments, 'text')->textarea()?>

<?= Html::submitButton('сохранить',['class'=>'btn btn-primary']);?>

<?php ActiveForm::end();?>





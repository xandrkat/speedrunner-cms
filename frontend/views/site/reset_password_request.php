<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Reset password request');
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<?= $this->title ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    
    <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-primary btn-block']) ?><hr>
    <?= Html::a(Yii::t('app', 'Login'), ['site/login'], ['class' => 'btn btn-success btn-block']) ?>
<?php ActiveForm::end(); ?>

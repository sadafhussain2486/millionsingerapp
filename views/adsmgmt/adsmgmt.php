<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdsMgmt */
/* @var $form ActiveForm */
?>
<div class="adsmgmt">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'ads_image') ?>
        <?= $form->field($model, 'ads_url') ?>
        <?= $form->field($model, 'ads_startdate') ?>
        <?= $form->field($model, 'ads_enddate') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'modify_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- adsmgmt -->

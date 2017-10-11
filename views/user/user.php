<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'registration_id') ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'forget_key') ?>
        <?= $form->field($model, 'facebook_id') ?>
        <?= $form->field($model, 'image') ?>
        <?= $form->field($model, 'mobile_no') ?>
        <?= $form->field($model, 'alternate_no') ?>
        <?= $form->field($model, 'otp_code') ?>
        <?= $form->field($model, 'device_id') ?>
        <?= $form->field($model, 'nick_name') ?>
        <?= $form->field($model, 'occupation') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'age') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'register_by') ?>
        <?= $form->field($model, 'opening_balance') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'last_update_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user -->

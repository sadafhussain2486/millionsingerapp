<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SetTarget */
/* @var $form ActiveForm */
?>
<div class="Target">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'income') ?>
        <?= $form->field($model, 'family_member') ?>
        <?= $form->field($model, 'children_no') ?>
        <?= $form->field($model, 'house_type') ?>
        <?= $form->field($model, 'monthly_rent') ?>
        <?= $form->field($model, 'investment_habit') ?>
        <?= $form->field($model, 'suggest_target') ?>
        <?= $form->field($model, 'working_member') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'modify_date') ?>
        <?= $form->field($model, 'status') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Target -->

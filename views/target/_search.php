<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SetTargetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="set-target-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'income') ?>

    <?= $form->field($model, 'family_member') ?>

    <?= $form->field($model, 'children_no') ?>

    <?php // echo $form->field($model, 'house_type') ?>

    <?php // echo $form->field($model, 'monthly_rent') ?>

    <?php // echo $form->field($model, 'investment_habit') ?>

    <?php // echo $form->field($model, 'suggest_target') ?>

    <?php // echo $form->field($model, 'working_member') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'modify_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

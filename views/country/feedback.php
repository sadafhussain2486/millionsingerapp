<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form ActiveForm */
?>
<div class="feedback">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'comment') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'modify_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- feedback -->

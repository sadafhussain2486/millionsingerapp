<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Amount */
/* @var $form ActiveForm */
?>
<div class="amount">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'expense_category_id') ?>
        <?= $form->field($model, 'payment_detail') ?>
        <?= $form->field($model, 'amount') ?>
        <?= $form->field($model, 'note') ?>
        <?= $form->field($model, 'bill_image') ?>
        <?= $form->field($model, 'repeat') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'modify_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- amount -->

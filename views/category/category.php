<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form ActiveForm */
?>
<div class="category">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'parent_category_id') ?>
        <?= $form->field($model, 'category_name') ?>
        <?= $form->field($model, 'category_slug') ?>
        <?= $form->field($model, 'category_icon') ?>
        <?= $form->field($model, 'category_type') ?>
        <?= $form->field($model, 'applied_for') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'created_date') ?>
        <?= $form->field($model, 'modify_date') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- category -->

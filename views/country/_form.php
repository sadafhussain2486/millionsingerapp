<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php /*$form = ActiveForm::begin(); ?>

	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end();*/ ?>
    <div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'comment')->textarea(['rows' => 6,'required'=>'true','data-parsley-maxlength'=>"500",'data-parsley-minlength'=>"10"]) ?>

                    <?= $form->field($model, 'sortorder')->textInput(['type'=>'number','required'=>'true','data-parsley-type'=>"integer",'data-parsley-type-message'=>"Enter Only Digit"]) ?>

				    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active' , '0' => 'Inactive'],['prompt'=>'Select Status','required'=>'true']) ?>

                </div> 
                <div class="form-group form_group_button margin">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>



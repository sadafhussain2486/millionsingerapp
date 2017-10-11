<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title="Admin Profile";
//$this->registerCssFile("@web/css/custom.css");
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

            <div class="col-md-6 box-body">

                <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Nick Name",'required'=>true, 'data-parsley-required-message'=>'This value is required.']); ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class' => 'form-control', 
                  'placeholder'=>"Username",'required'=>true, 'data-parsley-required-message'=>'This value is required.']); ?>             

                <?= $form->field($model, 'image')->fileInput(['class' => 'form-control'],['label'=>'Profile Image']); ?>

            </div>  
         

            <div class="form-group form_group_button margin">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
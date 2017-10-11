<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'required'=>true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6,'required'=>true]) ?>

                    <?= $form->field($model, 'file')->fileInput(['class' => 'form-control']) ?>
                    <p class="text-red">Max Upload Size: 2 MB & Resolution: 800x480px</p>
                    <?php 
                    if(!empty($model['image']))
                    {
                        echo '<img src="'.$model['image'].'" style="border:1px dashed #cdcdcd; padding:5px; border-radius:3px; width:20%;"/>';
                    }                    
                    ?>  
                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active' , '0' => 'Inactive']) ?>
                </div>                
                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'title_c')->textInput(['maxlength' => true,'required'=>true])->label('Title in Chinese') ?>

                    <?= $form->field($model, 'description_c')->textarea(['rows' => 6,'required'=>true])->label('Description in Chinese') ?>

                    <?= $form->field($model, 'image_c')->fileInput(['class' => 'form-control'])->label('Image in Chinese') ?>
                    <p class="text-red">Max Upload Size: 2 MB & Resolution: 800x480px</p>
                    <?php 
                    if(!empty($model['image_c']))
                    {
                        echo '<img src="'.$model['image_c'].'" style="border:1px dashed #cdcdcd; padding:5px; border-radius:3px; width:20%;"/>';
                    }                    
                    ?>  
                    <?= $form->field($model, 'status_c')->dropDownList(['1' => 'Active' , '0' => 'Inactive'])->label('Status Chinese') ?>
                </div>
                <div class="form-group form_group_button margin">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

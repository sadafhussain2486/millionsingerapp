<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

                <div class="col-md-12 box-body">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true,'required'=>true])->label("Title in English") ?>
                </div>
                <div class="col-md-12 box-body">
                    <?= $form->field($model, 'content')->textarea(['rows' => 6,'required'=>true,'class'=>'form-control','id'=>'editor1'])->label('Description in English') ?>
                </div>
                <div class="col-md-12 box-body">
                    <?= $form->field($model, 'title_c')->textInput(['maxlength' => true,'required'=>true])->label('Title in Chinese') ?>
                </div>
                <div class="col-md-12 box-body">
                    <?= $form->field($model, 'content_c')->textarea(['rows' => 6,'required'=>true,'class'=>'form-control','id'=>'editor2'])->label('Description in Chinese') ?>
                </div>
                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active' , '0' => 'Inactive']) ?>
                </div>                
                <div class="col-md-6 box-body">
                    <?php 
                    if(!empty($model['category_icon']))
                    {
                        echo '<img height="100" width="100" src="'.$model['category_icon'].'" style="border:1px dashed #cdcdcd;padding:5px;border-radius:3px;"/>';
                    }                    
                    ?>                    
                </div>
                <div class="form-group form_group_button margin">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
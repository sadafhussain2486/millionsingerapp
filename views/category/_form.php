<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\widgets\ActiveField;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */

//$this->registerCssFile("@web/css/custom.css");
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'type')->dropDownList(['1' => 'Income', '2' => 'Expense'],["prompt"=>"Select Type",'required'=>'true']);?>

                    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true, 'class' => 'form-control','required'=>true]) ?>

                    <?= $form->field($model, 'category_name_c')->textInput(['maxlength' => true, 'class' => 'form-control','required'=>true])->label('Category Name In Chinese'); ?>

                    <?= $form->field($model, 'category_color')->textInput(['maxlength' => true, 'class' => 'form-control my-colorpicker1','required'=>true])->label('Select Color'); ?>

                    <?= $form->field($model, 'category_sort')->textInput(['maxlength' => true, 'class' => 'form-control','required'=>true,'type'=>'number','data-parsley-type'=>'number','data-parsley-type-message'=>'Enter Only Digits','min'=>0,'max'=>999,'data-parsley-maxlength'=>'3'])->label('Category Sorting'); ?>
                    
                </div>                
                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'applied_for')->dropDownList(['1' => 'Individual', '2' => 'Family', '3' => 'Company'],["prompt"=>"Select Applied For",'required'=>'true'])->label('Group Applied'); ?>

                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive'],["prompt"=>"Select Status",'required'=>'true']); ?>

                    <?= $form->field($model, 'category_icon')->fileInput(['class' => 'form-control']) ?>
                    <p class="text-red">Max Upload Size: 2 MB & Resolution: 800x480px</p>

                    <?php 
                    if(!empty($model['category_icon']))
                    {
                        echo '<img src="'.$model['category_icon'].'" style="border:1px dashed #cdcdcd;padding:5px;border-radius:3px; width:30%;"/>';
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

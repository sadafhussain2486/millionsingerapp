<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\UserSearch;
$model1=new UserSearch();
$userlist=$model1->displayUserForSelect();
$listData=ArrayHelper::map($userlist,'id','nick_name');

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
    <div class="income-category-form user-form box box-primary">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>
        <div class="col-md-6 box-body">
        	<?= $form->field($model, 'user_id')->dropDownList($listData,['prompt'=>'Select User','required'=>true]);?>

            <?= $form->field($model, 'group_name')->textInput(['maxlength' => true,'required'=>true]) ?>
            
            <?= $form->field($model, 'opening_balance')->textInput(['maxlength' => true,'required'=>true]) ?>

            <?= $form->field($model, 'group_type')->dropDownList(['1' => 'Family', '2' => 'Company']);?>

            <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']); ?>

            <?= $form->field($model, 'group_icon')->fileInput() ?>
            <p class="text-red">Max Upload Size: 2 MB & Resolution: 800x480px</p>

        </div>    	
        <div class="col-md-6 box-body">
            <?php 
            if(!empty($model['oldAttributes']["group_icon"]))
            {
                echo '<img src="'.$model['oldAttributes']["group_icon"].'" style="border:1px dashed #cdcdcd; padding:5px; border-radius:3px; width:100%;"/>';
            }                    
            ?>  
        </div>  
        <div class="form-group form_group_button margin">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
      <?php ActiveForm::end(); ?>

  </div>
</div>

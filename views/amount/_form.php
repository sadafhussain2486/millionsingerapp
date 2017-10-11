<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\UserSearch;

$id=Yii::$app->request->get('id');
$type=Yii::$app->request->get('type');
$applied=Yii::$app->request->get('applied');

if($applied==2 || $applied==3)
{   
    $groupid=Yii::$app->request->get('groupid'); 
    $model1=new UserSearch();
    $userlist=$model1->displayGroupUserForSelect($groupid);
    $listData=ArrayHelper::map($userlist,'id','nick_name');
}
use app\models\CategorySearch;
$model2=new CategorySearch();

$categorylist=$model2->displayCategoryForSelect($type,$applied);
$listCatData=ArrayHelper::map($categorylist,'id','category_name');

$this->title = ($type==1)?'Create Income':'Create Expense';
//print_r($model);
/* @var $this yii\web\View */
/* @var $model app\models\Amount */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="amount-form box">
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>
                        <div class="col-md-6 box-body">                    

                            <?php //= $form->field($model, 'type')->dropDownList(['1' => 'Income', '2' => 'Expense'],['options'=>[$type => ['selected' => true]]],['prompt'=>'Select Type'])->label("Select Type");?>

                            <?php 
                            if($applied==2 || $applied==3){
                                echo $form->field($model, 'user_id')->dropDownList($listData,['prompt'=>'Select User'])->label("Select User");
                                //['options'=>[$id => ['selected' => true]]]
                            }
                            ?>

                            <?= $form->field($model, 'category_id')->dropDownList($listCatData,['prompt'=>'Select Category','required'=>true])->label('Select Category') ?>

                            <?= $form->field($model, 'payment_detail')->textInput(['maxlength' => true,'class'=>'form-control','required'=>true]) ?>

                            <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'class'=>'form-control','required'=>true]) ?>
                            
                            <?= $form->field($model, 'note')->textArea(['maxlength' => true,'class'=>'form-control']) ?>

                            <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>                            
                            </div>
                        </div>
                        <div class="col-md-6 box-body">                            

                            <?= $form->field($model, 'bill_image')->fileInput(['maxlength' => true,'class'=>'form-control']) ?>
                            <p class="text-red">Max Upload Size: 2 MB & Resolution: 800x480px</p>
                            <?= $form->field($model, 'repeat')->dropDownList(['1' => 'Yes', '0' => 'No'],['prompt'=>'Select','required'=>true]) ?>

                            <?= $form->field($model, 'repitition_period')->dropDownList(['1' => 'Daily', '2' => 'Weekly', '3'=>'Monthly','4'=>'Quarterly','5'=>'Half-Yearly','6'=>'Yearly'],['prompt'=>'Select'])->label("Repitition Period"); ?>

                            <?= $form->field($model, 'recordbudget')->dropDownList(['1' => 'Yes', '0' => 'No'],['prompt'=>'Select','required'=>true])->label('Record Budget') ?>
                        </div>
                        
                        
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

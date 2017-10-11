<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$id=Yii::$app->request->get('id');
$type=Yii::$app->request->get('type');
$account=Yii::$app->request->get('account');
$groupid=Yii::$app->request->get('group');

use app\models\CategorySearch;
$model2=new CategorySearch();
$categorylist=$model2->displayCategoryForSelect($type,$account+1);
$listCatData=ArrayHelper::map($categorylist,'id','category_name');

use app\models\UserSearch;
$model3=new UserSearch();
$usergrplist=$model3->displayGroupUserForSelect($groupid);
$listUserData=ArrayHelper::map($usergrplist,'id','nick_name');


$this->title="Add Budget";
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

                            <?php 
                            if($groupid!=0)
                            {
                                echo $form->field($model, 'user_id')->dropDownList($listUserData,['prompt'=>'Select User','required'=>true])->label('Select User');
                            }
                            ?>
                            <?= $form->field($model, 'category_id')->dropDownList($listCatData,['prompt'=>'Select Category','required'=>true])->label('Select Category') ?>
                           
                            <?= $form->field($model, 'amount')->textInput(['maxlength' => true,'class'=>'form-control','required'=>true]) ?>

                            <?= $form->field($model, 'repeat_type')->dropDownList(['1' => 'Weekly', '2' => 'Monthly'],['prompt'=>'Select','required'=>true]) ?>
                            <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div>
                       
                        
                        
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

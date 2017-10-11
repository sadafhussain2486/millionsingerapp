<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\UserSearch;
$model1=new UserSearch();
$userlist=$model1->displayUserForSelect();
$listData=ArrayHelper::map($userlist,'id','nick_name');
/* @var $this yii\web\View */
/* @var $model app\models\Notice */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="notice-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <div class="col-md-6 box-body">
                    <?= $form->field($model, 'user_id')->dropDownList($listData,['prompt'=>'Select User']);?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']); ?>

                </div>
                <div class="form-group form_group_button margin">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

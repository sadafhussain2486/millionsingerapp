<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdsMgmt */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="ads-mgmt-form">
            <div class="row">
                <div class="col-md-12">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>
                        <div class="col-md-6 box-body">
                        <?= $form->field($model, 'category')->dropDownList(['1' => 'Calendar (1440px × 288px)', '2' => 'News (1440px × 288px)', '3' => 'Profile (1440px × 288px)', '4' => 'Popup (1080px × 1080px)'],['prompt'=>'Select Category','required'=>true]); ?>

                            <?= $form->field($model, 'ads_title')->textInput(['maxlength' => true,'required'=>true]) ?>

                            <?= $form->field($model, 'ads_image')->fileInput(['class'=>'form-control']) ?>
                            <p class="text-red">Max Upload Size: 2 MB</p>
                            <?= $form->field($model, 'ads_url')->textInput(['maxlength' => true,'required'=>true,'data-parsley-type'=>"url"]) ?>

                            <?= $form->field($model, 'ads_startdate')->textInput(['class'=>'form-control datepicker','required'=>true]) ?>

                            <?= $form->field($model, 'ads_enddate')->textInput(['class'=>'form-control datepicker','required'=>true]) ?>

                            <?= $form->field($model, 'ads_impressionlimit')->textInput(['required'=>true])->label("Ads Impression Limit") ?>

                            <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']); ?>

                            <div class="form-group">
                                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                            </div>
                        </div> 
                        <div class="col-md-6 box-body">
                            <?php 
                            if(!empty($model['ads_image']))
                            {
                                echo '<img src="'.$model['ads_image'].'" style="border:1px dashed #cdcdcd; padding:5px; border-radius:3px; width:100%;"/>';
                            }                    
                            ?>  
                        </div>                      
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

//$this->registerCssFile("@web/css/custom.css");

?>
<div class="panel panel-primary">
    <div class="panel-heading">
          <?php echo $this->title; ?>
    </div>
    <div class="user-form box box-primary">    
      
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','data-parsley-validate'=>true]]); ?>

        <div class="col-md-6 box-body">

            <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Nick-name",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"text",'data-parsley-type-message'=>'This value should be a valid text.','autocomplete'=>'off'])->label('Nick-name'); ?>
			<?= $form->field($model, 'location')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"location",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"text",'data-parsley-type-message'=>'This value should be a valid email.','autocomplete'=>'off'])->label('Location'); ?>
			  <?= $form->field($model, 'horoscope')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"horoscope",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"text",'data-parsley-type-message'=>'This value should be a valid email.','autocomplete'=>'off'])->label('Horoscope'); ?>
			  <?= $form->field($model, 'dob')->textInput(['maxlength' => true, 'class' => 'form-control datepicker', 
              'placeholder'=>"DOB",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"date",'data-parsley-type-message'=>'This value should be a valid email.','autocomplete'=>'off'])->label('DOB'); ?>
            
            <?= $form->field($model, 'image')->fileInput(['class' => 'form-control'])->label('Profile'); ?>
           
                 

        </div>  

        <div class="col-md-6 box-body">
		<?= $form->field($model, 'number')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Mobile Number",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"number",'data-parsley-type-message'=>'This value should be a number.','autocomplete'=>'off'])->label('Mobile Number'); ?> 
            

            <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female']); ?>
           
            <?= $form->field($model, 'age')->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Age (in digit only)",'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"digits",'data-parsley-digits-message'=>'This value should be digits.','data-parsley-min'=>"1",'data-parsley-max'=>"120",'maxlength'=>3,'minlength'=>2,'data-parsley-min-message'=>'This value length is invalid. It should be 3 digits long.']); ?>            

           
			   <?= $form->field($model, 'intro')->textArea(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Intro",'type'=>'textarea','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"textarea",'autocomplete'=>'off'])->label('Intro'); ?> 
			  

        </div>

        <div class="form-group form_group_button margin">
            <?= Html::submitButton($model->isNewRecord ? 'ADD' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>



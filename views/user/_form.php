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
            <?php /*if(empty(Yii::$app->request->get('id'))){?>
              <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Password",'type'=>'password','required'=>true, 'data-parsley-required-message'=>'This value is required.','data-parsley-length'=>"[6, 10]",'data-parsley-length-message'=>'This value length is invalid. It should be between 6 and 10 characters long.','data-parsley-pattern'=>"(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*", 'data-parsley-pattern-message'=>"Password must contain at least (1) lowercase,uppercase letter and 1 digit.",'id'=>'userpassword','autocomplete'=>'off']); */?>   		  
            <?php //} ?>
            <?= $form->field($model, 'image')->fileInput(['class' => 'form-control']); ?>
            <!--<p class="text-red">Max Upload Size: 2 MB & Resolution: 300x300px</p>-->

            <?/*= $form->field($model, 'number')->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Mobile No",'required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-length'=>"[6, 15]",'data-parsley-length-message'=>'This value length is invalid. It should be between 6 and 15 characters long.','data-parsley-pattern'=>"(?=.*[0-9]).*", 'data-parsley-pattern-message'=>"Mobile No. should in Number only."]); ?>

            <?= $form->field($model)->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Alternative No",'data-parsley-length'=>"[6, 8]",'data-parsley-pattern'=>"(?=.*[0-9]).*", 'data-parsley-pattern-message'=>"Mobile No. should in Number only."])->label('Alternative No. {optional}'); */?>            

        </div>  

        <div class="col-md-6 box-body">
		<?= $form->field($model, 'number')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Mobile Number",'type'=>'text','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"number",'data-parsley-type-message'=>'This value should be a number.','autocomplete'=>'off'])->label('Mobile Number'); ?> 
            <?/*= $form->field($model, 'nick_name')->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Nick Name",'required'=>true,'data-parsley-required-message'=>'This value is required.']); ?>

            <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']) ?>

            <?= $form->field($model, 'occupation')->textInput(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Occupation"]); */?>

            <?= $form->field($model, 'gender')->dropDownList(['1' => 'Male', '2' => 'Female']); ?>
           
            <?= $form->field($model, 'age')->textInput(['maxlength' => true, 'class' => 'form-control', 
               'placeholder'=>"Age (in digit only)",'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"digits",'data-parsley-digits-message'=>'This value should be digits.','data-parsley-min'=>"1",'data-parsley-max'=>"120",'maxlength'=>3,'minlength'=>2,'data-parsley-min-message'=>'This value length is invalid. It should be 3 digits long.']); ?>            

            <?/*= $form->field($model, 'opening_balance')->textInput(['maxlength' => '9', 'class' => 'form-control', 
               'placeholder'=>"Opening Balance (in digit only)",'data-parsley-required-message'=>'This value is required.','data-parsley-pattern'=>"^[0-9]*\.[0-9]{1}$",'data-parsley-pattern-message'=>"Opening Balance should in 1 point decimal."]); */?>
			   <?= $form->field($model, 'intro')->textArea(['maxlength' => true, 'class' => 'form-control', 
              'placeholder'=>"Intro",'type'=>'textarea','required'=>true,'data-parsley-required-message'=>'This value is required.','data-parsley-type'=>"textarea",'autocomplete'=>'off'])->label('Intro'); ?> 
			  

        </div>

        <div class="form-group form_group_button margin">
            <?= Html::submitButton($model->isNewRecord ? 'ADD' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>



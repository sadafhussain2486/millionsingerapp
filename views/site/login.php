<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\LoginForm;

$model = new LoginForm();
$this->title = 'Million singer app';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="main-section-div">

    <div class="login-left-side" style="background-image:url('<?php echo Yii::getAlias('@web/assets/f45111d2/dist/img/login-bg.png')?>');">
        <div class="site-login">
            <!-- <h1><?php //= Html::encode($this->title) ?></h1> -->
            <!--<div align="center" style="margin-bottom: 20px;">
                <img class="loginlogo" src="<?php echo Yii::getAlias('@web/assets/f45111d2/dist/img/login-logo.png')?>"/>
            </div>-->

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
                    'labelOptions' => ['class' => 'control-label'],
                ],
            ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => false,'placeholder'=>'Username','autocomplete'=>'off']) ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password','autocomplete'=>'off']) ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"col-lg-12\">{input} <label>Remember Me ?</label></div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>

                <div class="form-group">
                    <div class="col-lg-12">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-lg btn-color', 'name' => 'login-button','style'=>'width:100%']) ?>
                    </div>
                </div>                
                <!--<div align="center" class="copyright">
                    <?php //date('Y')?> &copy AppOne Esolution Limited - All rights reserved
                </div>-->

            <?php ActiveForm::end(); ?>

            <!-- <div class="col-lg-offset-1" style="color:#999;">
                You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>
                To modify the username/password, please check out the code <code>app\models\User::$users</code>.
            </div> -->
        </div> 
    </div>
    <div class="login-right-side"></div>


        
    </div>
  


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title="Admin Change Password";
//$this->registerCssFile("@web/css/custom.css");
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <form id="demo-form" method="post" data-parsley-validate="true">
            <div class="col-md-6 box-body">
                <div class="box-body">
                    <div class="form-group">
                      <label for="currentpassword">Current Password</label>
                      <input class="form-control" id="currentpassword" placeholder="Current Password" type="password" name="currentpassword" required="true" data-parsley-required-message="This value is required." autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label for="newpassword">New Password</label>
                      <input class="form-control" id="newpassword" placeholder="New Password" type="password" name="newpassword" required="true" data-parsley-required-message="This value is required." data-parsley-length="[6, 20]" data-parsley-length-message="This value length is invalid. It should be between 6 and 20 characters long." autocomplete="off">
                    </div>
                    <div class="form-group">
                      <label for="confirmpassword">Confirm Password</label>
                      <input class="form-control" id="confirmpassword" placeholder="Confirm Password" type="password" name="confirmpassword" required="true" data-parsley-required-message="This value is required." data-parsley-equalto="#newpassword" data-parsley-equalto-message="Please Enter Same Value." autocomplete="off">
                    </div> 
                </div>
            </div>
            <div class="form-group form_group_button margin">
                <button type="submit" class="btn btn-primary margin">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
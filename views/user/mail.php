<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserSearch;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title="Email Section";
//$this->registerCssFile("@web/css/custom.css");
if(!empty(Yii::$app->request->get('id')))
{
    $connection = Yii::$app->getDb();
    $fetid=Yii::$app->request->get('id');
    $command = $connection->createCommand("Select * from email where id=".$fetid."");
    $dataemail = $command->queryAll();
}
?>
<div class="panel panel-primary">
    <div class="row">
        <div class="col-md-12">
            <form name="frm1" id="frm1" method="post" enctype="multipart/form-data" data-parsley-validate="true">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title">Compose New Message</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <input type="email" name="to" class="form-control" value="<?php echo(!empty($dataemail[0]['to']))?$dataemail[0]['to']:''; ?>" placeholder="To:" required="true" data-parsley-required-message="This value is required.">
                            <!-- <select name="to" id="to" multiple="">
                                <option value=""></option>
                                <?php /*foreach($userlist as $todata){?>
                                    <option value=""><?php //echo $todata["username"]?></option>
                                <?php }*/ ?>
                            </select> -->
                        </div>
                        <div class="form-group">
                            <input name="subject" class="form-control" value="<?php echo(!empty($dataemail[0]['subject']))?$dataemail[0]['subject']:''; ?>" placeholder="Subject:" required="true" data-parsley-required-message="This value is required.">
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="editor1" class="form-control" style="height: 300px"><?php echo(!empty($dataemail[0]['message']))?$dataemail[0]['message']:''; ?></textarea>
                        </div>
                        <!-- <div class="form-group">
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-paperclip"></i> Attachment
                                <input type="file" name="attachment">
                            </div>
                            <p class="help-block">Max. 2 MB</p>
                        </div> -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" name="submit" value="Send" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </form>
          <!-- /. box -->
        </div>
    </div>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title="Email Section";
//$this->registerCssFile("@web/css/custom.css");
?>
<div class="panel panel-primary">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mailbox
        <div class="box-tools pull-right">
          <div class="has-feedback">
            <a href="<?php echo Yii::$app->request->baseUrl."/user/mail"; ?>" class="btn btn-primary btn-block margin-bottom pull-right">Compose</a>
          </div>
        </div>
      </h1>   

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">            
            <!-- /.box-header -->
            <div class="box-body no-padding margin">
             
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <thead>
                    <th>#</th>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php 
                    $r=0;
                    foreach($data as $emaildata) {?>
                    <tr>
                      <td><input type="checkbox"></td>
                      <td class="mailbox-star"><!-- <a href="#"><i class="fa fa-star text-yellow"></i></a> --><?php echo $emaildata['to']; ?></td>
                      <td class="mailbox-name"><?php echo $emaildata['subject']; ?></td>
                      <td class="mailbox-attachment"><?php echo $emaildata['created_date']; ?></td>
                      <td class="mailbox-date">
                        <a href="<?php echo Yii::$app->request->baseUrl."/user/mail?id=".$emaildata['id']; ?>" class="btn btn-xs btn-success">
                          <span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
                        </a>
                        || 
                        <a onclick="return confirm("Are you Sure Delete This Record?");" href="<?php echo Yii::$app->request->baseUrl."/user/outbox?delete=".$emaildata['id']; ?>" class="btn btn-xs btn-danger">
                          <span data-toggle="tooltip" title="Click To Delete" data-placement="top"><i class="fa fa-trash"></i></span>
                        </a>
                      </td>
                    </tr>
                    <?php } ?>
                    
                  
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>            
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

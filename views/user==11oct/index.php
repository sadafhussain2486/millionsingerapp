<?php

use yii\helpers\Html;
use yii\grid\GridView;
//print_r(Yii::$app->session);
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p> -->
        <!-- <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?> -->
    <!-- </p> -->
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?= Html::a('Create User', ['create'], ['class' => 'btn btn-warning pull-right']) ?>
            </div>           

        
    </div>
</div>
<div class="modal modal-info fade" id="modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" id="resetpassword" name="resetpassword">
                        <input type="hidden" name="hideid" id="hideid" value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-flat" onclick="resetpassword();">Reset</button>
                        </span>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<script type="text/javascript">
function addid(id)
{
    $("#hideid").val(id);
}
function resetpassword()
{
    var value=$("#resetpassword").val();
    var id=$("#hideid").val();
    if(value=="")
    {
        alert("Please Enter Password");
        return false;
    }
    else if(value.length<=5)
    {
        alert("Enter Minimum Six Words.");
        return false;
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('user/resetpassword');?>",
            data: {id: id,str:value},
            success: function (data) {
                $("#resetpassword").val("");
                alert(data);
            },
            error: function (exception) {
                $("#resetpassword").val("");
                alert("Error Found.");
            }
        });
    }
}
</script>

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\UserSearch;
$model2= new UserSearch;

use app\models\CategorySearch;
$model3= new CategorySearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupmemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Group Members of '.$groupname;
//$this->params['breadcrumbs'][] = $this->title;

$groupid=Yii::$app->request->get('id'); 
$model1=new UserSearch();

$userlist=$model1->displayUserForSelect();
$alreadyuser=$model1->displayGroupUserForSelect($groupid);
foreach ($alreadyuser as $alreayvalue) {
    $alreayusr[]=$alreayvalue['id'];
}

?>
<div class="group-member-index">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?> 
            <?php
            echo Html::a('<span class="btn btn-sm pull-right btn-warning" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Click to Add New Member.').'">Add New</span>', "javascript:;",
                [
                    'target'=>'_blank',
                    'data-toggle'=>"modal",
                    'data-target'=>"#modal-addmember"
                ]);
            ?>           
        </div>
         <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sent By</th>
                        <th>Join By</th>
                        <th>Group Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php
                    $i=1;
                    foreach ($data as $amtvalue) 
                    {
                    ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $model2->displayname($amtvalue["sent_by"]); ?></td>
                        <td><?php echo $model2->displayname($amtvalue["user_id"]); ?></td>
                        <td>
                            <?php 
                            if($amtvalue["invite_status"]==0){ echo "Invite"; }
                            if($amtvalue["invite_status"]==1){ echo "Accept"; }
                            if($amtvalue["invite_status"]==2){ echo "Reject"; }
                            ?>
                        </td>
                        <td><?php echo ($amtvalue["status"]==1)?'Active':'Inactive'; ?></td>
                        <td>
                            <a target="_blank" href="<?php echo Yii::$app->request->baseUrl."/groupmember/view?id=".$amtvalue["id"]; ?>" class="btn btn-xs btn-success">
                                <span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i> View</span>
                            </a>
                            ||
                            <!-- <a onclick="removeact(<?php //echo $amtvalue["id"]; ?>)" href="javascript:;" class="btn btn-xs btn-warning" >
                                <span data-toggle="tooltip" title="Click To Delete Member From Group" data-placement="top"><i class="fa fa-trash"></i> Remove</span>
                            </a> -->
                            <a id="rmstatus_<?php echo $amtvalue["id"];?>" href="javascript:;" class="btn btn-xs <?php echo($amtvalue['exit_by']==0)?'btn-success':'btn-warning';?>" title="Click To Change Current Group Status" onclick="removeact(<?php echo $amtvalue["id"] ?>)" data-toggle="tooltip" data-placement="top"><?php echo($amtvalue['exit_by']==0)?'Active':'Exit';?>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>                             
                </tbody>               
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-addmember">
    <div class="modal-dialog" style="min-width: 50%;">
        <div class="modal-content">         
            <div class="modal-body">
                <div class="box box-success">
                    <div class="box-header">
                      <h3 class="box-title">Add New Group Member</h3>                   
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding"> 
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" method="post" action="<?php echo Yii::$app->request->baseUrl."/groupmember/create"; ?>" data-parsley-validate="true">
                                    <input type="hidden" name="sent_by" value="<?php echo Yii::$app->request->get('sentby'); ?>">
                                    <input type="hidden" name="group_id" value="<?php echo Yii::$app->request->get('id'); ?>">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Select User</label>
                                            <select class="form-control" id="user_id" name="user_id" required="true">
                                                <option value="">Select User</option>
                                                <?php 
                                                foreach ($userlist as $uservalue) 
                                                {
                                                ?>
                                                <option value="<?php echo $uservalue["id"]; ?>" <?php if(in_array($uservalue["id"], $alreayusr)){ echo 'disabled="disabled"'; }?>><?php echo $uservalue["nick_name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Select Status</label>
                                            <select class="form-control" id="status" name="status" required="true">
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>                                        
                                    </div>
                                      <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>  
                        </div>                                        
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script type="text/javascript">
function removeact(id)
{
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('groupmember/remove'); ?>",
        data: {id: id},
         dataType: 'json',
        success: function (data) {
            if(data==1)
            {
                $("#rmstatus_"+id).removeClass("btn-success");
                $("#rmstatus_"+id).addClass("btn-warning");
                $("#rmstatus_"+id).text('Exit');
            }
            else if(data==0)
            {
                //alert("danger");
                $("#rmstatus_"+id).removeClass("btn-warning");
                $("#rmstatus_"+id).addClass("btn-success");
                $("#rmstatus_"+id).text('Active');
            }
        },
        error: function (exception){
            alert("Error Found.");
        }
    });
}
</script>
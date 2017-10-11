<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserSearch;
$model1=new UserSearch;
use app\models\GroupSearch;
$model2=new GroupSearch;
/* @var $this yii\web\View */
/* @var $model app\models\GroupMember */

$this->title = $model2->groupname($model->group_id);
?>
<div class="group-member-view">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">   
            <?php echo $this->title; ?> 
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [ 
                    'attribute'=>'Sent By',
                    'value' =>$model1->displayname($model->sent_by),
                ],
                [ 
                    'attribute'=>'User',
                    'value' =>$model1->displayname($model->user_id),
                ],
                [ 
                    'attribute'=>'Group Name',
                    'value' =>$model2->groupname($model->group_id),
                ],
                [ 
                    'attribute'=>'Invite Status',
                    'value' =>($model->invite_status==1)?"Accept":"Reject / Invite",
                ],
                [ 
                    'attribute'=>'Group Status',
                    'value' =>($model->exit_by==0)?"Active": "Exit",
                ],
                [ 
                    'attribute'=>'status',
                    'value' =>($model->status==1)?"Active": "Inactive",
                ],
                'created_date',
                'modify_date',
            ],
        ]) ?>
    </div>
</div>

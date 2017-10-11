<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notice */
use app\models\UserSearch;
$model1=new UserSearch();
$this->title = $model->id;
?>
<div class="notice-view">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning pull-right','style'=>'margin-left:10px;']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?> 
        </div>            
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute'=>'user_id',
                                'value'=>$model1->displayname($model->user_id),
                            ],
                            'description:ntext',
                            [ 
                                'attribute'=>'status',
                                'value' =>($model->status==1)?"Active": "Inactive",
                            ],
                            'created_date',
                            'modify_date',
                        ],
                    ]) ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>
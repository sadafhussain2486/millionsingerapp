<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\UserSearch;
$model1=new UserSearch;
/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = $model->id;
?>
<div class="feedback-view">    
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
                            //'user_id',
                            [
                                'attribute'=>'User',
                                'value' => $model1->displayname($model->user_id),
                            ],
                            'comment:ntext',
                            [ 
                				'attribute'=>'status',
                				'value' =>($model->status==1)?"Active": "Inactive",
                			],
                            'sortorder',
                            'created_date',
                            'modify_date',
                        ],
                    ]) ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>

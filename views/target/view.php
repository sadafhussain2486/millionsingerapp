<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\UserSearch;
$model1=new UserSearch();
/* @var $this yii\web\View */
/* @var $model app\models\SetTarget */

$this->title = $model->id;
?>
<div class="set-target-view">
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
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            //'user_id',
                            [
                                'attribute'=>'Type',
                                'label'=>'Nickname',
                                'value'=>$model1->displayname($model->user_id),
                            ],
                            'income',
                            'family_member',
                            'children_no',
                            [ 
                                'attribute'=>'Type',
                                'label'=>'House Type',
                                'value' =>($model->investment_habit==1)?"Private": "Rent",
                            ],
                            'monthly_rent',
                            [ 
                                'attribute'=>'Type',
                                'label'=>'Investment Habit',
                                'value' =>($model->investment_habit==1)?"Yes": "No",
                            ],    
                            'suggest_target',                        
                            'working_member',
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
        </div
    </div>
</div>

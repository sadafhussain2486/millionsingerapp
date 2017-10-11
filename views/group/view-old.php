<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserSearch;

$model1=new UserSearch;
/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->group_name;
//$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">
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
                    [ 
                        'attribute'=>'Nick Name',
                        'value' =>$model1->displayname($model->user_id),
                    ],
                    'group_name',
                    [
                        'attribute' => 'img',
                        'format' => 'html',
                        'label' => 'Group Icon',
                        'value' => function ($data) {
                            return Html::img($data['group_icon'], ['width' => '60px']);
                        },
                    ],
                    [ 
                        'attribute'=>'Group Type',
                        'value' =>($model->status==1)?"Family": "Company",
                    ],
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
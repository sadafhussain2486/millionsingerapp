<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = $model->title;
?>
<div class="pages-view">
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
                        'title',
                        'content:ntext',
                        [ 
                            'attribute'=>'title_c',
                            'label'=>'Title in Chinese',
                            'value' =>function ($data) { return $data['title_c']; },
                        ],
                        [ 
                            'attribute'=>'content_c',
                            'label'=>'Description in Chinese',
                            'value' =>function ($data) { return $data['content_c']; },
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
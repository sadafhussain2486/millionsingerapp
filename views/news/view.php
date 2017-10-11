<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
?>
<div class="news-view">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?= Html::encode($this->title) ?>
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
                            'description:ntext',                            
                			[
                				'attribute' => 'img',
                				'format' => 'html',
                				'label' => 'Image',
                				'value' => function ($data) {
                					return Html::img($data['image'],
                						['width' => '60px']);
                				},
                			],
                			[ 
                				'attribute'=>'status',
                				'value' =>($model->status==1)?"Active": "Inactive",
                			],
                            [ 
                                'attribute'=>'title_c',
                                'label'=>'Title in Chinese',
                                'value' =>function ($data) { return $data['title_c']; },
                            ],
                            [ 
                                'attribute'=>'description_c',
                                'label'=>'Description in Chinese',
                                'value' =>function ($data) { return $data['description_c']; },
                            ],
                            [
                                'attribute' => 'img',
                                'format' => 'html',
                                'label' => 'Image Chinese',
                                'value' => function ($data) {
                                    return Html::img($data['image_c'],
                                        ['width' => '60px']);
                                },
                            ],
                            [ 
                                'attribute'=>'status_c',
                                'label'=>'Status Chinese',
                                'value' =>($model->status==1)?"Active": "Inactive",
                            ],
                            'created_date',
                            'modified_date',
                        ],
                    ]) ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

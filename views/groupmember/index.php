<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupmemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group Members';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-member-index">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?php echo $this->title; ?>            
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
    			 /* [
    				'label'=>'Username',
    				'attribute'=>'user_id',
    				'value'=>'user.username',
    			],  */
    			[
    				'label'=>'Groupname',
    				'attribute'=>'group_id',
    				'value'=>'group.group_name',
    			],
                'sent_by',
                'user_id',
                //'group_id',
                //'status',
                'created_date',
                // 'modify_date',

                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{view}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="btn btn-success btn-xs glyphicon glyphicon-eye-open"></span> || ', $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
                            ]);
                        },  
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                            ]);
                        }                                           
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>

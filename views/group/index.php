<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Groups';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">    
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>       
            <?= Html::a('Create Group', ['create'], ['class' => 'btn btn-warning pull-right']) ?>     
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary'=>'',
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    			[
    				'label'=>'Admin Email',
    				'attribute'=>'user_id',
    				'value'=>'user.username',
    			],
    			[
    				'label'=>'Admin Name',
    				'attribute'=>'user_id',
    				'value'=>'user.nick_name',
    			],
                'group_name',
                [
                    'attribute' => 'Type',
                    'label' => 'Group Type',
                    'value' => function ($data) {
                        return ($data['group_type']==1)?'Family':'Company';
                    },
                ],
                [
                    'attribute' => 'Type',
                    'label' => 'Status',
                    'value' => function ($data) {
                        return ($data['status']==1)?'Active':'Inactive';
                    },
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{view}{update}{delete}{viewmember}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="btn btn-success btn-xs glyphicon glyphicon-eye-open"></span> || ', $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'target'=>'_blank',
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="btn btn-warning btn-xs glyphicon glyphicon-pencil"></span> || ', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
                            ]);
                        },  
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs glyphicon glyphicon-trash"></span> || ', $url, [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                            ]);
                        },
                        'viewmember' => function ($url, $model) {
                            return Html::a('<span class="btn btn-primary btn-xs fa fa-eye"></span>', Yii::$app->request->baseurl."/groupmember/viewmember?id=".$model->id."&sentby=".$model->user_id, [
                                        'title' => Yii::t('app', 'View Group Member'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'target'=>'_blank'
                            ]);
                        },                                          
                    ],
                ],
            ],
        ]); 
        ?>
    </div>
</div>
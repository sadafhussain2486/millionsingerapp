<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AdsmgmtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ads Mgmts';
?>
<div class="ads-mgmt-index">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?= Html::a('Create Ads', ['create'], ['class' => 'btn btn-warning pull-right']) ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'category',
                    'value'=>function($data){
                        if($data['category']==1){ return "Calender"; }
                        if($data['category']==2){ return "News"; }
                        if($data['category']==3){ return "Profile"; }
                        if($data['category']==4){ return "Popup"; }
                    },
                ],
                'ads_title',
                'ads_url:url',
                'ads_startdate',
                'ads_enddate',
                'ads_impressionlimit',
                [
                    'attribute'=>'status',
                    'value'=>function($data){
                        return ($data["status"]==1)?'Active':'Inactive';
                    },
                ],
                // 'created_date',
                // 'modify_date',

                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="btn btn-success btn-xs glyphicon glyphicon-eye-open"></span> || ', $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
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
                        },                                         
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>

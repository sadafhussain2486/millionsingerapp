<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\UserSearch;
$modeluser=new UserSearch();
/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedbacks';
?>
<div class="feedback-index">    
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],   			
                //'user_id',
                /*[
                    'attribute'=>'user_id',
                    'label'=>'User',                    
                ],*/
                [
                    'label'=>'Name',
                    'attribute'=>'user_id',
                    'value'=>'user.nick_name',
                ],
                'comment:ntext',
                [
                    'attribute'=>'status',
                    'value'=>function($data){
                        return ($data["status"]==1)?'Active':'Inactive';
                    }
                ],
                'sortorder',
                'created_date',
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
                        }                                                   
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>

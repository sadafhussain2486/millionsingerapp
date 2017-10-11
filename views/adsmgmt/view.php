<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdsMgmt */

$this->title = $model->ads_title;
?>
<div class="ads-mgmt-view">

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
                                'attribute' => 'Text',
                                'label' => 'Category',
                                'value' => function ($data) {
                                    if($data['category']==1){ return "Calender"; }
                                    if($data['category']==2){ return "News"; }
                                    if($data['category']==3){ return "Profile"; }
                                    if($data['category']==4){ return "Popup"; }
                                },
                            ],
                            'ads_title',
                            [
                                'attribute' => 'img',
                                'format' => 'html',
                                'label' => 'Ads Image',
                                'value' => function ($data) {
                                    return Html::img($data['ads_image'], ['width' => '60px']);
                                },
                            ],   
                            'ads_url:url',
                            'ads_startdate',
                            'ads_enddate',
                            'ads_impressionlimit',
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
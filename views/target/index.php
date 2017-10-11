<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SetTargetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Set Targets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-target-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Set Target', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'income',
            'family_member',
            'children_no',
            // 'house_type',
            // 'monthly_rent',
            // 'investment_habit',
            // 'suggest_target',
            // 'working_member',
            // 'status',
            // 'created_date',
            // 'modify_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\NoticeComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notice Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notice-comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary','style'=>'margin-left:10px;']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'notice_id',
            'comment:ntext',
            'status',
            'created_date',
            'modify_date',
        ],
    ]) ?>

</div>

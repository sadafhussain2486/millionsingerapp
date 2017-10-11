<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GroupMember */

$this->title = 'Update Group Member: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Group Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="group-member-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GroupMember */

$this->title = 'Create Group Member';
$this->params['breadcrumbs'][] = ['label' => 'Group Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

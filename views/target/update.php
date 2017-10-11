<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SetTarget */

$this->title = 'Update Set Target: ' . $model->id;
?>
<div class="set-target-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

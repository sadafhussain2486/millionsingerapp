<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notice */

$this->title = 'Update Notice: ' . $model->id
?>
<div class="notice-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

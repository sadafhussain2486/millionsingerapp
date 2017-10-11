<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pushnotification */

$this->title = 'Update Notification: ' . $model->id
?>
<div class="pushnotification-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

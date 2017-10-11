<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pushnotification */

$this->title = 'Create Notification';
?>
<div class="notice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

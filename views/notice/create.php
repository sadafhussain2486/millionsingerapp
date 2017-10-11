<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Notice */

$this->title = 'Create Notice';
?>
<div class="notice-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

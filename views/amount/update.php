<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Amount */

$this->title = 'Update  Income / Expense : ' . $model->id;
?>
<div class="amount-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

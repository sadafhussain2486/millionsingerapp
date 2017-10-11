<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pages */

$this->title = 'Update Pages: ' . $model->title;
?>
<div class="pages-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

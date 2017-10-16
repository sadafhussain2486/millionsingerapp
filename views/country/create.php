<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = 'Create Feedback';
?>
<div class="feedback-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

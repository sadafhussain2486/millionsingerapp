<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdsMgmt */

$this->title = 'Update Ads Mgmt: ' . $model->id;
?>
<div class="ads-mgmt-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

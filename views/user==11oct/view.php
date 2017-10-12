<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->nick_name;
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <p class="pull-right">
                <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger pull-right',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // 'id',
                    // 'registration_id',
                    'username',
                    //'password',
                    //'forget_key',
                    //'facebook_id',
                    'image',
                    'mobile_no',
                    'alternate_no',
                    'otp_code',
                    'device_id',
                    'nick_name',
                    'occupation',
                    'gender',
                    'age',
                    'status',
                    'register_by',
                    'opening_balance',
                    'created_date',
                    'last_update_date',
                ],
            ]) ?>
        </div>
    </div>
</div>

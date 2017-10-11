<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->category_name;
//$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning pull-right','style'=>'margin-left:10px;']) ?>
            <span></span>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger pull-right',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?> 
        </div>            
        <div class="table-responsive">
            <table class="table">
            <tbody>
                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [ 
                        'attribute'=>'Type',
                        'value' =>($model->type==1)?"Income": "Expense",
                    ],
                    'category_name',
                    [ 
                        'attribute'=>'Category Name Chinese',
                        'value' =>$model->category_name_c,
                    ],
                    [ 
                        'attribute'=>'Category Sort',
                        'value' =>$model->category_sort,
                    ],
                    [ 
                        'attribute'=>'Category Color',
                        'value' =>$model->category_color,
                    ],
                    [
                        'attribute' => 'img',
                        'format' => 'html',
                        'label' => 'Category Image',
                        'value' => function ($data) {
                            return Html::img($data['category_icon'], ['width' => '60px']);
                        },
                    ],            
                    [ 
                        'attribute'=>'Group Applied For',
                        'value' =>($model->type==1)?"Individual":"Family",
                    ],
                    [ 
                        'attribute'=>'status',
                        'value' =>($model->status==1)?"Active": "Inactive",
                    ],
                    'created_date',
                    'modify_date',
                ],
                ]) 
            ?>
            </tbody>
            </table>
        </div>
    </div> 

</div>


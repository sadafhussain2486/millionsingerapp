<?php

use yii\helpers\Html;
use yii\grid\GridView;
//print_r(Yii::$app->session);
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p> -->
        <!-- <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?> -->
    <!-- </p> -->
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?= Html::a('<span class="fa fa-plus-circle"></span> Add User', ['create'], ['class' => 'btn btn-warning pull-right crt_user']) ?>
            </div>           

        <?= GridView::widget([            
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'nick_name',
                'number',
                //'name', 
                // [
                    // 'attribute'=>'name',
                    // 'label'=>'Email',
                    // 'value'=>'name',
                // ],
                [
                    'attribute'=>'status',
                    'label'=>'Status',
                    'value'=>function ($data) {
                                return ($data['status']==1)?'Active':'Inactive';
                            },
                ],
                //['class' => 'yii\grid\ActionColumn'],
                 ['class' => 'yii\grid\ActionColumn',  

                    'header' => 'Actions',
                    //'headerOptions' => '',//$data->rate->name
                    'template' => '{viewdetail}{update}',//{delete}{resetpassword}',   //{view}
                    'buttons' => [
                        // 'view' => function ($url, $model) {
                            // return Html::a('<span class="btn btn-primary btn-xs glyphicon glyphicon-eye-open "></span> || ', $url, [
                                        // 'title' => Yii::t('app', 'View'),
                                        // 'data-toggle'=>'tooltip',
                                        // 'data-placement'=>'top',
                                        // 'style'=>'cursor:default;'
										
                            // ]);
                        // },
                        'viewdetail' => function ($url, $model) {
                            return Html::a('<span class="btn ico_hide btn-success btn-xs fa fa-eye"></span> || ', $url, [
                                        'title' => Yii::t('app', 'View All Detail'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'target'=>'_blank'
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return Html::a('<span class="btn btn-warning btn-xs glyphicon glyphicon-pencil"></span> || ', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
                            ]);
                        }
                        // 'delete' => function ($url, $model) {
                            // return Html::a('<i class="fa fa-trash"></i>', $url, [
                                        // 'class'=>'btn btn-danger btn-xs',
                                        // 'title' => Yii::t('app', 'Delete'),
                                        // 'data-toggle'=>'tooltip',
                                        // 'data-placement'=>'top',
                                        // 'style'=>'cursor:default;',
                                        // 'onclick'=>'return confirm("Are You Sure Want To Delete?")',
                                        // 'data-method'=>'post'
                            // ]);
                        // } 
                        // ,
                        // 'resetpassword' => function ($url, $model) {
                            // return Html::a(' || <span class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Reset Password').'"><i class="fa fa-cog"></i></span>', 'javascript:;', [
                                        // 'data-toggle'=>'modal',
                                        // 'data-target'=>'#modal-info',
                                        // 'onclick'=>'addid('.$model->id.')',
                            // ]);
                        // }                        
                    ],
                ], 
            ],
        ]); ?>
    </div>
</div>
<div class="modal modal-info fade" id="modal-info">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" id="resetpassword" name="resetpassword">
                        <input type="hidden" name="hideid" id="hideid" value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-flat" onclick="resetpassword();">Reset</button>
                        </span>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<script type="text/javascript">
function addid(id)
{
    $("#hideid").val(id);
}
function resetpassword()
{
    var value=$("#resetpassword").val();
    var id=$("#hideid").val();
    if(value=="")
    {
        alert("Please Enter Password");
        return false;
    }
    else if(value.length<=5)
    {
        alert("Enter Minimum Six Words.");
        return false;
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::$app->getUrlManager()->createUrl('user/resetpassword');?>",
            data: {id: id,str:value},
            success: function (data) {
                $("#resetpassword").val("");
                alert(data);
            },
            error: function (exception) {
                $("#resetpassword").val("");
                alert("Error Found.");
            }
        });
    }
}
</script>

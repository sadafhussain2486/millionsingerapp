<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use app\models\NoticeSearch;
$model=new NoticeSearch;
/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notices';
?>
<div class="notice-index">
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'summary'=>'',
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'user_id',                
                'description:ntext',
                'status',
                'created_date',
                // 'modify_date',

                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{view}{update}{delete}{viewcomment}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="btn btn-success btn-xs glyphicon glyphicon-eye-open"></span> || ', $url, [
                                        'title' => Yii::t('app', 'View'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
                            ]);
                        },                            
                        'update' => function ($url, $model) {
                            return Html::a('<span class="btn btn-warning btn-xs glyphicon glyphicon-pencil"></span> || ', $url, [
                                        'title' => Yii::t('app', 'Update'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;'
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Yii::t('app', 'Delete'),
                                        'data-toggle'=>'tooltip',
                                        'data-placement'=>'top',
                                        'style'=>'cursor:default;',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                            ]);
                        },
                        'viewcomment' => function ($url, $model) {
                            return Html::a(' || <span class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'View Comment').'"><i class="fa fa-comments"></i></span>', 'javascript:;', [
                                        'data-toggle'=>'modal',
                                        'data-target'=>'#modal-info',
                                        'onclick'=>'viewcomment('.$model->id.')',
                            ]);
                        }                                                   
                    ],
                ],
            ],
        ]); ?>
    </div>
</div>
<div class="modal modal-default fade" id="modal-info">
    <div class="modal-dialog" style="min-width: 65%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Info Modal</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="showresult">                                  
                        </tbody>
                  </table>
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
function viewcomment(nid) 
{
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('notice/viewcomment')  ; ?>",
        data: {id: nid},
        success: function (data) {
            $("#showresult").html(data);
        },
        error: function (exception) {
            alert("Error Found.");
        }
    });
}
</script>
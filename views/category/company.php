<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\categorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Categories Company';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">    
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#indi-income" data-toggle="tab">Income</a></li>   
                <li><a href="#indi-expense" data-toggle="tab">Expense</a></li>     
            </ul>

            <div class="tab-content">
                <div class="active tab-pane" id="indi-income">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?php echo $this->title; ?>                            
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>                                
                                        <th>#</th>                                  
                                        <th>Category Name</th>
                                        <th>Category Group</th>
                                        <th>Category Sort</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    //print_r($data);
                                    foreach ($data["companyincome"] as $indiincvalue) 
                                    {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $indiincvalue["category_name"]; ?></td>
                                        <td><?php                                             
                                                if($indiincvalue["applied_for"]==1){ $group="Individual"; }
                                                if($indiincvalue["applied_for"]==2){ $group="Family"; }
                                                if($indiincvalue["applied_for"]==3){ $group="Company"; }
                                                echo $group;
                                            
                                         ?></td>        
                                        <td><?php echo $indiincvalue["category_sort"]; ?></td>
                                        <td><?php echo ($indiincvalue["status"]==1)?'Active':'Inactive'; ?></td> 
                                        <td>
                                            <a href="<?php echo Yii::$app->request->baseUrl."/category/view?id=".$indiincvalue["id"]; ?>" class="btn btn-xs btn-success">
                                                <span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
                                            </a>                                        
                                            || 
                                            <a href="<?php echo Yii::$app->request->baseUrl."/category/update?id=".$indiincvalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                <span data-toggle="tooltip" title="Click To Update Details" data-placement="top"><i class="fa fa-pencil"></i></span>
                                            </a>
                                            ||                                            
                                            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $indiincvalue["id"]], [
                                                'class' => 'btn btn-xs btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <?php } ?>         
                                </tbody>                            
                            </table>
                        </div>
                        
                    </div>                     
                </div>
                <div class="tab-pane" id="indi-expense">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">View All Income</h3>                            
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>                                
                                        <th>#</th>                                  
                                        <th>Category Name</th>
                                        <th>Category Group</th>
                                        <th>Category Sort</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    //print_r($data);
                                    foreach ($data["companyexpense"] as $indiexpvalue) 
                                    {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $indiexpvalue["category_name"]; ?></td>
                                        <td><?php                                             
                                                if($indiexpvalue["applied_for"]==1){ $group="Individual"; }
                                                if($indiexpvalue["applied_for"]==2){ $group="Family"; }
                                                if($indiexpvalue["applied_for"]==3){ $group="Group"; }
                                                echo $group;
                                            
                                         ?></td>   
                                        <td><?php echo $indiexpvalue["category_sort"]; ?></td>     
                                        <td><?php echo ($indiexpvalue["status"]==1)?'Active':'Inactive'; ?></td> 
                                        <td>
                                            <a href="<?php echo Yii::$app->request->baseUrl."/category/view?id=".$indiexpvalue["id"]; ?>" class="btn btn-xs btn-success">
                                                <span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
                                            </a>                                        
                                            || 
                                            <a href="<?php echo Yii::$app->request->baseUrl."/category/update?id=".$indiexpvalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                <span data-toggle="tooltip" title="Click To Update Details" data-placement="top"><i class="fa fa-pencil"></i></span>
                                            </a>
                                            ||                                            
                                            <?= Html::a('<i class="fa fa-trash"></i>', ['delete', 'id' => $indiexpvalue["id"]], [
                                                'class' => 'btn btn-xs btn-danger',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <?php } ?>         
                                </tbody>                            
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.tab-pane -->
            </div>
        <!-- /.tab-content -->
        </div>
      <!-- /.nav-tabs-custom -->
    </div>
</div>   



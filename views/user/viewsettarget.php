<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

//$this->title = $model->nick_name;
$this->title = "View Set Target";
//print_r($data);
$type=Yii::$app->request->get('type');
?>
<div class="user-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <div class="panel panel-primary">
        <div class="panel-heading" style="padding-bottom:22px;">
            <?php echo $this->title; ?>
            <?php 
            $year1 = date("Y",strtotime($data['created_date']));
            $month1 = date("m",strtotime($data['created_date']));  
            if(date('Y-m')==date($year1.'-'.$month1))
            {?> 
            <p class="pull-right">
                <?= Html::a('Update', ['target/update', 'type' => Yii::$app->request->get('type'), 'id' => $data["id"]], ['class' => 'btn btn-warning']) ?> 
            </p>
            <?php } ?>
        </div>
            <div class="table-responsive">
                <table id="w0" class="table table-striped table-bordered detail-view dataTable">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td><?php echo $data["id"]; ?></td>
                        </tr>
                        <tr>
                            <th>Income (After deduction of mpf and taxes)</th>
                            <td>$ <?php echo $data["income"]; ?></td>
                        </tr>
                        <tr>
                            <th>Suggested target</th>
                            <td>$ <?php echo $data["suggest_target"]; ?></td>
                        </tr> 
                        <?php if($type==1) { ?>
                        <tr>
                            <th>No. of family members</th>
                            <td><?php echo $data["family_member"]; ?></td>
                        </tr>
                        <tr>
                            <th>No. of children</th>
                            <td><?php echo $data["children_no"]; ?></td>
                        </tr>
                        <tr>
                            <th>No. of working members(excluding user)</th>
                            <td><?php echo $data["working_member"]; ?></td>
                        </tr>
                        <tr>
                            <th>Type of housing</th>
                            <td><?php echo($data["house_type"])?'Private':'Rent'; ?></td>
                        </tr>
                        <tr>
                            <th>Mortgage/monthly rent</th>
                            <td>$ <?php echo $data["monthly_rent"]; ?></td>
                        </tr>
                        <tr>
                            <th>Investment habit</th>
                            <td><?php echo ($data["investment_habit"]==1)?'Yes':'No'; ?></td>
                        </tr>
                        <tr>
                            <th>Confidence percentage</th>
                            <td><?php if($data["confidence_meet_target"]==1){ echo "Low 60%"; }elseif($data["confidence_meet_target"]==2){ echo "Medium 85%"; }elseif($data["confidence_meet_target"]==3){ echo "High 90%"; } ?></td>
                        </tr>
                        <?php } ?>                     
                        <tr>
                            <th>Status</th>
                            <td><?php echo ($data["status"]==1)?'Active':'Inactive'; ?></td>
                        </tr>
                        <tr>
                            <th>Created Date</th>
                            <td><?php echo $data["created_date"]; ?></td>
                        </tr>
                        <tr>
                            <th>Modify Date</th>
                            <td><?php echo $data["modify_date"]; ?></td>
                        </tr>
                    </tbody>
                </table>            
            </div>
        </div>
    </div>
</div>

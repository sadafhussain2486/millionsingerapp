<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserSearch;
$model2= new UserSearch;

use app\models\CategorySearch;
// $model3= new CategorySearch;

use app\models\GroupSearch;
use app\models\GroupmemberSearch;
/* @var $this yii\web\View */
/* @var $model app\models\User */
//print_r($catdata["amount"]);
$this->title = "Dashboard";
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header" style="padding-bottom: 20px;background-color: #fff;">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box 
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $dashboarddata['category']; ?></h3>

              <p>Total Category</p>
            </div>
            <div class="icon">
              <i class="fa fa-tags"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col 
        <div class="col-lg-3 col-xs-6">
          <!-- small box 
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $dashboarddata['news']; ?></h3>

              <p>Total News</p>
            </div>
            <div class="icon">
              <i class="fa fa-newspaper-o"></i>
            </div>
            <a href="<?php echo Yii::$app->request->baseUrl."/news/"; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $dashboarddata['users']; ?></h3>

              <p>Total Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo Yii::$app->request->baseUrl."/user/"; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col 
        <div class="col-lg-3 col-xs-6">
          <!-- small box 
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $dashboarddata['feedback']; ?></h3>

              <p>Total Feedback</p>
            </div>
            <div class="icon">
              <i class="fa fa-comments"></i>
            </div>
            <a href="<?php echo Yii::$app->request->baseUrl."/feedback/"; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      	<!--<div class="row">
        <!-- Left col 
	        <div class="col-md-6">
	        	<div class="box box-primary">
		            <div class="box-header">
		              	<i class="ion ion-clipboard"></i>
		              	<h3 class="box-title">Weekly Registered Users</h3>              
		            </div>
		            <!-- /.box-header 
		            <div class="box-body">
		            	<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nickname</th>
									<th>Username</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$u=1;
								foreach ($dashboarddata['weekuser'] as $uservalue) {									
								?>
								<tr>
									<td><?php echo $u++; ?></td>
									<td><?php echo $uservalue["nick_name"]; ?></td>
									<td>
										<?php echo $uservalue["name"]; ?>
										<small>Mobile: <?php echo $uservalue["number"]; ?></small>
									</td>
									<td><a target="_blank" href="<?php echo Yii::$app->request->baseUrl."/user/viewincome?id=".$uservalue["id"]; ?>" class="btn btn-xs btn-success" data-toggle="tooltip" data-title="Click to View Detail"><i class="fa fa-eye"></i></a></td>
								</tr>
								<?php } ?>					       
							</tbody>
							
						</table>
		            </div>
		            
		        </div>
	        </div>
	        <div class="col-md-6">
	        	<div class="box box-primary">
		            <div class="box-header">
		              	<i class="ion ion-clipboard"></i>
		              	<h3 class="box-title">Weekly Income And Expense</h3>    
		              	<form method="post" id="incexpfrom" name="incexpfrom" class="pull-right">
			              	<select class="pull-right" name="incexpfilter" id="incexpfilter" onchange="displayfilter();">
			              		<option value="0" <?php echo($_POST["incexpfilter"]==0)?'selected="selected"':''; ?>>Individual</option>
			              		<option value="1" <?php echo($_POST["incexpfilter"]==1)?'selected="selected"':''; ?>>Group</option>		              		
			              	</select>   
		            	</form>           
		            </div>
		            <!-- /.box-header 
		            <div class="box-body">
		            	<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Payment Detail</th>
									<th>Category</th>
									<th>Balance</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i=1;
								foreach ($dashboarddata['weekincome'] as $incomevalue) {									
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td>
										<?php 
											echo Yii::$app->mycomponent->dateformat($incomevalue["selectdate"]); 
										?>		
										<br>
										<?php echo($incomevalue["type"]==1)?'<small class="label bg-green">Income</small>':'<small class="label bg-yellow">Expense</small>'; ?>									
									</td>
									<td><?php echo $incomevalue["payment_detail"]; ?></td>
									<td><?php echo $model3->categoryname($incomevalue["category_id"]); ?></td>
									<td><?php echo $incomevalue["amount"]; ?></td>
									
								</tr>
								<?php } ?>					       
							</tbody>
							
						</table>
		            </div>
		            
		        </div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-6">
	        	<div class="box box-primary">
		            <div class="box-header">
		              	<i class="ion ion-clipboard"></i>
		              	<h3 class="box-title">Weekly Registered Group</h3>              
		            </div>
		            <!-- /.box-header 
		            <div class="box-body">
		            	<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Group Name</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$g=1;
								foreach ($dashboarddata['weekgroup'] as $groupvalue) {									
								?>
								<tr>
									<td><?php echo $g++; ?></td>
									<td>
										<?php echo $model2->displayname($groupvalue["user_id"],'username'); ?>
										<small>Nickname: <?php echo $model2->displayname($groupvalue["user_id"]); ?></small>
									</td>
									<td><?php echo $groupvalue["group_name"]; ?></td>
									<td><a target="_blank" href="<?php echo Yii::$app->request->baseUrl."/group/view?id=".$groupvalue["id"]; ?>" class="btn btn-xs btn-success" data-toggle="tooltip" data-title="Click to View Detail"><i class="fa fa-eye"></i></a></td>
								</tr>	
								<?php } ?>					       
							</tbody>
							
						</table>
		            </div>
		            
		        </div>
	        </div>
	        <div class="col-md-6">
        	<div class="box box-primary">
	            <div class="box-header">
	              	<i class="ion ion-clipboard"></i>
	              	<h3 class="box-title">All User Expense Category Wise</h3>  
	              	<form method="post" id="expchart" name="expchart" class="pull-right">
		              	<select class="pull-right" name="expensechart" id="expensechart" onchange="displaychart();">
		              		<option value="1" <?php echo($_POST["expensechart"]==1)?'selected="selected"':''; ?>>Individual</option>
		              		<option value="2" <?php echo($_POST["expensechart"]==2)?'selected="selected"':''; ?>>Family</option>
		              		<option value="3" <?php echo($_POST["expensechart"]==3)?'selected="selected"':''; ?>>Company</option>
		              	</select>   
		            </form>         
	            </div>
	            <!-- /.box-header 
	            <div class="box box-solid">		            
		            <!-- /.box-header 
		            <?php if(empty($_POST["expensechart"]) || $_POST["expensechart"]==1){?>
		            <div id="expindividual">
			            <div class="box-body text-center">
			                <div class="row">
			                    <div class="col-md-12">
			                        <div class="sparkline" data-type="pie" data-offset="90" data-width="150px" data-height="150px"><?php echo $dashboarddata['expchartindi']['categoryper']; ?></div>
			                        <small><strong>Individual</strong></small>
			                    </div>                          
			                </div>                    
			            </div>
			            <div class="box-footer no-padding">
			                <div class="box-body">
			                    <div class="table-responsive">
			                        <table class="table no-margin">
			                          	<thead>
				                          	<tr>
					                            <th>Category</th>
					                            <th>Percentage</th>
				                          	</tr>
			                          	</thead>
			                          	<tbody>	
			                          		<?php 
			                          		$in=0;			                          		
			                          		foreach($dashboarddata['expchartindi']['categorylist'] as $expchartcatindi)
			                          		{
			                          			if($dashboarddata['expchartindi']['expinditotallist'][$in]>0){
			                          			?>		                          
				                          	<tr>
					                            <td><?php echo $expchartcatindi['category_name']; ?></td>
					                            <td><?php echo $dashboarddata['expchartindi']['expinditotallist'][$in]; ?>%</td>
				                          	</tr>	
				                          	<?php } $in++; } ?>		                                                   
			                          	</tbody>                                    
			                        </table>
			                    </div>
			                </div>
			            </div>
		            </div>
		            <?php 
		        	} 
		        	if(isset($_POST["expensechart"]) && $_POST["expensechart"]==2 || $_POST["expensechart"]==3){
		            ?>
		            <div id="expfamily">
			            <div class="box-body text-center">
			                <div class="row">
			                    <div class="col-md-12">
			                        <div class="sparkline" data-type="pie" data-offset="90" data-width="150px" data-height="150px"><?php echo $dashboarddata['expchartindi']['categoryper']; ?></div>
			                        <small><strong><?php echo($_POST["expensechart"]==2)?'Family':'Company';?></strong></small>
			                    </div>                          
			                </div>                    
			            </div>
			            <div class="box-footer no-padding">
			                <div class="box-body">
			                    <div class="table-responsive">
			                        <table class="table no-margin">
			                          	<thead>
			                          		<tr>
					                            <th>Category</th>
					                            <th>Percentage</th>
			                          		</tr>
			                          	</thead>
			                          	<tbody>
				                          	<?php 
			                          		$in=0;			                          		
			                          		foreach($dashboarddata['expchartindi']['categorylist'] as $expchartcatindi)
			                          		{?>		                          
				                          	<tr>
					                            <td><?php echo $expchartcatindi['category_name']; ?></td>
					                            <td><?php echo $dashboarddata['expchartindi']['expinditotallist'][$in]; ?>%</td>
				                          	</tr>	
				                          	<?php $in++; } ?>                             
			                          	</tbody>                                    
			                        </table>
			                    </div>
			                </div>
			            </div>
		            </div>
		            <?php } ?>
		        </div>		            
	        </div>
        	</div>
        <!-- /.Left col -->
        <!-- right col -->
      	</div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
<script type="text/javascript">
function displaychart()
{
	$("#expchart").submit();
}
function displayfilter()
{
	$("#incexpfrom").submit();
}

</script>

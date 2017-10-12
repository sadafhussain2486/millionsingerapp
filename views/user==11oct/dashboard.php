<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\UserSearch;
$model2= new UserSearch;

use app\models\CategorySearch;
$model3= new CategorySearch;

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
       <!-- ./col -->
       <!-- ./col -->
       <!-- ./col -->
         <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      	<div class="row">
        <!-- Left col -->
	        <div class="col-md-6">
	        	<div class="box box-primary">
		            <div class="box-header">
		              	<i class="ion ion-clipboard"></i>
		              	<h3 class="box-title">Weekly Registered Users</h3>              
		            </div>
		            <!-- /.box-header -->
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
									<td>#</td>
									<td>Nickname</td>
									<td>Username</td>
									<td>Action</td>       
							</tbody>
							
						</table>
		            </div>
		            
		        </div>
	        </div>
	        
		          
		            </div>
		            
		        </div>
	        </div>
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

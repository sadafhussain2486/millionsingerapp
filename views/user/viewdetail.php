<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use app\models\UserSearch;
$model2= new UserSearch;

//use app\models\CategorySearch;
//$model3= new CategorySearch;

//use app\models\GroupSearch;
//use app\models\GroupmemberSearch;
/* @var $this yii\web\View */
/* @var $model app\models\User */
//print_r($catdata);
//print_r($currenttarget);
$this->title = "View Income";

//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
// $selectmonth=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');

// $searchviewmonth=@$_POST["analysiscat"];
// $searchviewyear=@$_POST["analysisyear"];
// (!empty($searchviewmonth))?$month=$searchviewmonth:$month=date('m');
// (!empty($searchviewyear))?$monthyear=$searchviewyear:$monthyear=date('Y');     
// if(!empty($searchviewmonth))
// {
	// if($searchviewyear==date('Y',strtotime(date('Y'),'last year')))
	// {
		// $monthname=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
	// }	
	// else
	// {
		// if($searchviewmonth=="12month")
	    // {
			// for ($i = 0; $i <= 11; $i++) {
		        // $monthname[] = date("M-Y", strtotime( date( 'Y-m-01' )." -$i months"));
		    // }
		// }
		// else
		// {
			// $monthname=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
		// }
	// }	
// }
// else
// {
	// $monthname=array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
// }

// print_r($catdata["cashflow"]);
// print_r($catdata["anaycatamt"]);
// $userid=Yii::$app->request->get('id');
?>
<div id="loadingimage" style="display: none;"><img src="<?php echo Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/css/loading.gif'?>" height="80" width="80" style="z-index: 999; top: 40%; left: 49%; position: fixed;"></div>
<div class="row">	
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          	<img class="profile-user-img img-responsive img-circle" src="<?php echo(!empty($catdata['user']['image']))?$catdata['user']['image']:Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/default.jpg'; ?>" alt="User profile picture">

          	<h3 class="profile-username text-center"><?php echo $catdata['user']['nick_name']; ?></h3>

          	<p class="text-muted text-center"><?php echo $catdata['user']['occupation']; ?></p>

          	<ul class="list-group list-group-unbordered">
          		<strong><i class="fa fa-user margin-r-5"></i> Username</strong>
		        <p class="text-muted"><?php echo $catdata['user']['name']; ?></p>
	            <li class="list-group-item">
	              	<b>Unique Id</b> <a class="pull-right"><?php echo $catdata['user']['regid']; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Gender</b> <a class="pull-right"><?php echo $catdata['user']['gender']; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Age</b> <a class="pull-right"><?php echo $catdata['user']['age']; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Opening Balance</b> <a class="pull-right">$ <?php echo $catdata['user']['opening_balance']; ?></a>
	            </li>
	            <li class="list-group-item">	            	
	              	<b>Savings Target</b> <a class="pull-right">$ <?php echo(!empty($currenttarget))?$currenttarget['income']:'0.0'; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>No. of Time Target Achieved</b> <a class="pull-right">4</a>
	            </li>
	            <li class="list-group-item">
	              	<b>Group</b> 
	              	<a href="javascript:;" class="label pull-right bg-blue" data-toggle="modal" data-target="#modal-info">
						<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><?php //echo GroupSearch::groupcount(Yii::$app->request->get('id'));?></span>
					</a>
	            </li>
	            <li class="list-group-item">
	              	<b>Join Group</b> 
	              	<a href="javascript:;" class="label pull-right bg-yellow" data-toggle="modal" data-target="#modal-info">
						<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><?php //echo GroupmemberSearch::groupjoin(Yii::$app->request->get('id'));?></span>
					</a>
	            </li>
	            <li class="list-group-item">
	              	<b>Token</b> <a class="pull-right"><?php echo $catdata['user']['token']; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Language</b> <a class="pull-right"><?php echo($catdata['user']['lang']==0)?'English':'Chinese'; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Created Date</b> <a class="pull-right"><?php echo $catdata['user']['created_date']; ?></a>
	            </li>
	            <li class="list-group-item">
	              	<b>Last Update</b> <a class="pull-right"><?php echo $catdata['user']['last_update_date']; ?></a>
	            </li>
          	</ul>
          	<a id="status_<?php echo $catdata["user"]["id"];?>" href="javascript:;" class="btn <?php echo($catdata['user']['status']==1)?'btn-success':'btn-danger';?> btn-block" title="Click To Change Current Status" data-toggle="tooltip" data-placement="top" onclick="changestatus(<?php echo $catdata['user']['id'] ?>)"><b><?php echo($catdata['user']['status']==1)?'Status: Active':'Status: Inctive';?></b></a>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      	<div class="nav-tabs-custom">
	        <ul class="nav nav-tabs">
	          <li class="active"><a href="#analysis" data-toggle="tab">Analysis</a></li>   
	          <li><a href="#activity" data-toggle="tab">Income</a></li>
	          <li><a href="#timeline" data-toggle="tab">Expense</a></li>
	          <li><a href="#settings" data-toggle="tab">Budget</a></li>
	          <li><a href="#targetbudget" data-toggle="tab">Target Budget</a></li>  
	          <li class="pull-right">
	          	<div class="form-control">	          		
		          	<form name="analysiscatfrm" id="analysiscatfrm" method="post" action="" class="pull-right">
		          		<label>Filter</label>
		          		<select name="analysiscat" id="analysiscat" onchange="displayfilter()">
		              		<option value="">Select Month</option>
		              		<?php
		              		foreach ($selectmonth as $monkey => $monvalue) {
		              		?>
		              			<option value="<?php echo $monkey; ?>" <?php echo($monkey==@$_POST["analysiscat"])?'selected="selected"':'';?> ><?php echo $monvalue; ?></option>
		              		<?php } ?>
		              		<option value="12month" <?php echo($searchviewmonth=="12month")?'selected="selected"':'';?>>Last 12 Month</option>
		              	</select>
		          		<select name="analysisyear" id="analysisyear" onchange="displayfilter()">
		              		<option value="<?php echo date('Y'); ?>" <?php echo(date('Y')==@$_POST["analysisyear"])?'selected="selected"':'';?>><?php echo date('Y'); ?></option>
		              		<option value="<?php echo date('Y',strtotime('last year')); ?>" <?php echo(date('Y',strtotime('last year'))==@$_POST["analysisyear"])?'selected="selected"':'';?>><?php echo date('Y',strtotime('last year')); ?></option>
		              	</select>

		          	</form> 
	          	</div>
          	</li>     
	        </ul>
	        <div class="tab-content">
	        	<div class="active tab-pane" id="analysis">
	            	<div class="row">
				        <div class="col-md-6">
				          <div class="box box-success">
				            <div class="box-header with-border">
				              	<h3 class="box-title">Cash Flow</h3>
				            </div>
				            <!-- /.box-header -->
				            <div class="box-body">
				              <div class="row">
				                <div class="col-md-12">
				                  	<p class="text-center">
				                    	<strong>Period: <span class="showmonth1">1 Jan</span>, <span class="showyear1"><?php //echo date('Y'); ?></span> - <span class="showmonth2">31 Dec</span>, <span class="showyear2"><?php //echo date('Y'); ?></span></strong>
				                  	</p>
				                  	<!-- <div class="chart">
				                    	<canvas id="salesChart" style="height: 265px;"></canvas>
				                  	</div> -->				                  	
				                  	<div class="chart">
						            	<canvas id="areaChart" style="height:250px"></canvas>
						            </div>
				                  <!-- /.chart-responsive -->
				                </div>
				                <!-- /.col -->			                
				              </div>
				              <!-- /.row -->
				            </div>				            
				           	<div class="box-footer no-padding">
				              	<div class="box-body">
					              	<div class="table-responsive">
					                	<table class="table no-margin">
						                  	<thead>
						                  		<tr>
								                    <th>Month</th>
								                    <th>Cash In</th>
								                    <th>Cash Out</th>
								                    <th>Cash Flow</th>
						                  		</tr>
						                  	</thead>
						                  	<tbody>
						                  		<?php 
						                  		$csf=1;
						                  		$cashinlist="";
						                  		$cashoutlist="";
						                  		$totalcashin=0;
						                  		$totalcashout=0;
						                  		foreach($monthname as $monthkey=>$months)
						                  		{
						                  			$cashin=round($catdata["cashflow"]["cashin"][$csf][0]['sum(amount)']);
						                  			$cashout=round($catdata["cashflow"]["cashout"][$csf][0]['sum(amount)']); 
						                  			//TOTAL 
						                  			$totalcashin+=$catdata["cashflow"]["cashin"][$csf][0]['sum(amount)'];
						                  			$totalcashout+=$catdata["cashflow"]["cashout"][$csf][0]['sum(amount)']; 
						                  			$cashinlist.=$cashin.', ';
						                  			$cashoutlist.=$cashout.', ';
						                  		?>
							                  	<tr>
								                    <td><?php echo $months; ?></td>
								                    <td>$<?php echo $cashin; ?></td>
								                    <td>$<?php echo $cashout; ?></td>
								                    <td>$<?php echo ($cashin-$cashout); ?></td>
							                  	</tr>	
							                  	<?php 
							                  		$csf++; 
							                  	} 
							                  	?>
						                  	</tbody>					                  
					                	</table>
					                	<?php 
					                		$this->params["cashinlist"]=$cashinlist;
					                		$this->params["cashoutlist"]=$cashoutlist;
					                	?>
					              	</div>
				              		<!-- /.table-responsive -->
				            	</div>
				            </div>
				            <!-- /.box-footer -->
				          </div>
				          <!-- /.box -->
				        </div>
				        <!-- /.col -->
				        <div class="col-md-6">
				        	<div class="box box-success">
					            <div class="box-header with-border">
					              	<h3 class="box-title">Net Worth</h3>					            
					            </div>
					            <div class="box-body chart-responsive">
					              <div class="chart" id="bar-chart" style="height: 285px;"></div>
					            </div>
					            <div class="box-footer no-padding">
				              	<div class="box-body">
					              	<div class="table-responsive">
					                	<table class="table no-margin">
						                  	<thead>
						                  		<tr>
								                    <th>Month</th>
								                    <th>Net Worth</th>
								                    <th>Difference</th>
						                  		</tr>
						                  	</thead>
						                  	<tbody>
						                  		<?php 
						                  		$nt=1;
						                  		$cashnetdiff=0;
						                  		$cashnetprevval=0;
						                  		$cashnettotalin="";
						                  		$cashnettotaldiff=0;
						                  		foreach($monthname as $monthnetkey=>$monthsnet)
						                  		{
						                  			$cashnetin=round($catdata["cashflow"]["cashin"][$nt][0]['sum(amount)']);
								                    $cashnettotalin+=$cashnetin;
								                    //$cashnetprevval=$catdata["cashflow"]["cashin"][($nt-1)][0]['sum(amount)']; 
								                    if($nt==1)
								                   	{
								                   		$cashnetprevval=0;     
								                   		$cashnetdiff=0;		
								                   	} 
								                    else
								                    {
								                    	$cashnetprevval=$catdata["cashflow"]["cashin"][($nt-1)][0]['sum(amount)']; 
								                    	$cashnetdiff=round(($cashnetin-$cashnetprevval));
								                    }
								                    
								                    //$cashnettotaldiff+=($cashnetin-$cashnetprevval);
								                    $cashnettotaldiff+=$cashnetdiff;
								                    //JSON DATA
								                    $data[]="{y: '$monthsnet', a: $cashnetin, b: $cashnetdiff}";
						                  		?>
							                  	<tr>
								                    <td><?php echo $monthsnet; ?></td>
								                    <td><?php echo "$".$cashnetin; ?></td>
								                    <td><?php echo "$".$cashnetdiff; ?></td>
							                  	</tr>	
							                  	<?php $nt++; } ?>
							                  	<tfoot>
							                  		<tr>
							                  			<th>Total</th>
							                  			<th>$<?php echo $cashnettotalin; ?></th>
							                  			<th>$<?php echo $cashnettotaldiff; ?></th>
							                  		</tr>
							                  	</tfoot>
						                  	</tbody>					                  
					                	</table>
					              	</div>
				              		<!-- /.table-responsive -->
				              		<?php 
			              			$jsonstr="";
			              			foreach($data as $rty){				              				
			              				$jsonstr.=$rty.",";
			              			}	
			              			$this->params["networthjson"]=$jsonstr;			              			
			              			?>	
				            	</div>
				            </div>
					            <!-- /.box-body -->
					          </div>
				        </div>			        
				    </div>
				    <div class="row">
				        <div class="col-md-6">
				        	<div class="box box-success">
					            <div class="box-header with-border">
					              	<h3 class="box-title">Category</h3>
					              	<!-- <form name="analysiscatfrm" id="analysiscatfrm" method="post" action="" class="pull-right">
					              		<select name="analysiscat" id="analysiscat" onchange="displayfilter()">
						              		<option value="">Select</option>
						              		<?php
						              		/*foreach ($selectmonth as $monkey => $monvalue) {
						              		?>
						              			<option value="<?php echo $monkey; ?>" <?php echo($monkey==$_POST["analysiscat"])?'selected="selected"':'';?> ><?php echo $monvalue; ?></option>
						              		<?php }*/ ?>
						              	</select>
					              	</form>	 -->				              	
					            </div>
					            <!-- /.box-header -->
					            <div class="box-body">
					              	<div class="row">
					                	<div class="col-md-12">
					                  		<div class="chart-responsive">
					                    		<div class="box-body">
							              			<canvas id="pieChart" style="height:250px"></canvas>
							            		</div>
					                  		</div>
					                  		<!-- ./chart-responsive -->
					                	</div>				                
					                	<!-- /.col -->
					              	</div>
					              <!-- /.row -->
					            </div>
					            <!-- /.box-body -->
					            <div class="box-footer no-padding">
					              	<div class="box-body">
						              	<div class="table-responsive">
						                	<table class="table no-margin">
							                  	<thead>
							                  		<tr>
									                    <th>General</th>
									                    <th>Percentage</th>
									                    <th>Amount</th>
							                  		</tr>
							                  	</thead>
							                  	<tbody>
							                  	<?php
												$ac=1;
												$analdata="";
												foreach ($catdata["categoryuser"] as $analycat) 
												{
													$analcatname=$model3->categoryname($analycat['category_id']);
													$sumcat=round($catdata["anaycatamt"]["analycatexp"][$ac][0]['sum(amount)']);
													$percatexp=round((($sumcat*100)/$catdata["anaycattotalamt"]),2);
													$analdata[]="{value: $sumcat, label: '$analcatname'}";
												?>
												<tr>
								                    <td><?php echo $analcatname; ?></td>
								                    <td><?php echo $percatexp; ?>%</td>
								                    <td>$<?php echo $sumcat; ?></td>
							                  	</tr>
							                  	<?php $ac++; } ?>	
							                  	</tbody>					                  
						                	</table>
						                	<?php 
					              			$jsoncatexpstr="";
					              			if(!empty($analdata)){
					              				foreach($analdata as $anarty){				              				
						              				$jsoncatexpstr.=$anarty.",";
						              			}						              			
					              			}	
					              			$this->params["analcatexpjson"]=$jsoncatexpstr;			              			
					              			?>	
						              	</div>
					              		<!-- /.table-responsive -->
					            	</div>
					            </div>
					            <!-- /.footer -->
					          </div>
					          <!-- /.box -->
				        </div>
				        <div class="col-md-6">
				        	<div class="box box-success">
					            <div class="box-header with-border">
					              	<h3 class="box-title">Summary</h3>
					              	<form name="analysissummfrm" id="analysissummfrm" method="post" action="" class="pull-right">
					              		<select name="analysissummary" id="analysissummary" onchange="displaysummary(<?php echo $userid; ?>)">
						              		<option value="<?php echo date("m",strtotime(date('Y-m'))); ?>">Select</option>
						              		<?php
						              		foreach ($selectmonth as $monkeysumm => $monvaluesumm) {
						              		?>
						              			<option value="<?php echo $monkeysumm; ?>" <?php echo($monkeysumm==@$_POST["analysiscat"])?'selected="selected"':'';?> ><?php echo $monvaluesumm; ?></option>
						              		<?php } ?>
						              	</select>
					              	</form>				              
					            </div>
					            <!-- /.box-header -->
					            <div class="box-body">
					              	<div class="table-responsive">
					                	<table class="table no-margin">
						                  <thead>
						                  <tr>
						                    <th colspan="2">General</th>
						                  </tr>
						                  </thead>
						                  <tbody>
						                  <tr>
						                    <td>Total Income:</td>
						                    <td>$<span id="anatotalinc"></span></td>
						                  </tr>
						                  <tr>
						                    <td>Total Expense:</td>
						                    <td>$<span id="anatotalexp"></span></td>
						                  </tr>
						                  <tr>
						                    <td>Saving Target:</td>
						                    <td>$<span id="anasettarget"></span></td>
						                  </tr>	
						                  <tr>
						                    <td>Net Cash Flow:</td>
						                    <td>$<span id="netcashflow"></span></td>
						                  </tr>	
						                  <tr>
						                    <td>Target Achievement:</td>
						                    <td><span id="targetachi"></span></td>
						                  </tr>			                  
						                  </tbody>
						                  <thead>
						                  <tr>
						                    <th colspan="2">Budget</th>
						                  </tr>
						                  </thead>
						                  <tbody>
						                  <tr>
						                    <td>Total:</td>
						                    <td>$<span id="budgettotal"></span></td>
						                  </tr>
						                  <tr>
						                    <td>Spent:</td>
						                    <td>$<span id="budgetspent"></span></td>
						                  </tr>	
						                  <tr>
						                    <td>Difference:</td>
						                    <td>$<span id="budgetdifference"></span></td>
						                  </tr>
						                  <tr>
						                    <td>Top Spent:</td>
						                    <td>{<span id="maxcategory"></span>} $<span id="budgettopspent"></span></td>
						                  </tr>				                  
						                  <tr>
						                    <td>Min. Spent:</td>
						                    <td>{<span id="mincategory"></span>} $<span id="budgetminspent"></span></td>
						                  </tr>
						                  </tbody>
					                	</table>
					              	</div>
					              <!-- /.table-responsive -->
					            </div>				            
					            <!-- /.box-footer -->
					        </div>
				        </div>
				    </div>
			    </div>
	          	<div class="tab-pane" id="activity">
	          		<div class="box box-success">
	            		<div class="box-header">
	              			<h3 class="box-title">View All Income</h3>
	              			Record Budget ( <i class="fa fa-circle text-success"></i><strong>Yes</strong>
              				<i class="fa fa-circle text-danger"></i><strong>No</strong> )
	              			<?= Html::a('<span class="btn btn-sm pull-right btn-warning" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Click to Add New Income').'">Add Income</span>', Yii::$app->request->baseUrl."/amount/create?type=1&applied=1&id=".Yii::$app->request->get('id'),['target'=>'_blank']) ?>
	            		</div>
			            <!-- /.box-header -->
			            <div class="box-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>									
										<th>Payment Detail</th>
										<th>Category</th>
										<th>Current Balance</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>	
									<?php
									$i=1;
									foreach ($catdata["amount"] as $amtvalue) 
									{
									?>
									<tr>
										<td>
											<?php 
												echo $i++,'&nbsp;'; 
												if($amtvalue["recordbudget"]==1){ echo '<i class="fa fa-circle text-success"></i>'; }else{ echo '<i class="fa fa-circle text-danger"></i>'; }
											?>											
										</td>
										<td><?php echo $amtvalue["payment_detail"]; ?></td>
										<td><?php echo $model3->categoryname($amtvalue["category_id"]); ?></td>
										<td><?php echo $amtvalue["amount"]; ?></td>
										<td><?php echo $model2->dataformat($amtvalue["selectdate"]); ?></td>
										<td>
											<a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-success" onclick="viewdetail(<?php echo $amtvalue["id"]; ?>)">
												<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
											</a>
											|| 
											<a href="<?php echo Yii::$app->request->baseUrl."/amount/update?type=1&applied=1&userid=".$amtvalue["user_id"]."&id=".$amtvalue["id"]; ?>" class="btn btn-xs btn-warning" target="_blank">
												<span data-toggle="tooltip" title="Click To Update Details" data-placement="top"><i class="fa fa-pencil"></i></span>
											</a>
											|| 
											<a href="javascript:;" id="delete<?php echo $amtvalue["id"]; ?>" onclick="datadelete(<?php echo $amtvalue["id"]; ?>,'amount')" class="btn btn-xs btn-danger" data-method="post">
												<span data-toggle="tooltip" title="Click To Delete Details" data-placement="top"><i class="fa fa-trash"></i></span>
											</a>
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
	          	<div class="tab-pane" id="timeline">
	          		<div class="box box-success">
	            		<div class="box-header">
	              			<h3 class="box-title">View All Expense</h3>
	              			Record Budget ( <i class="fa fa-circle text-success"></i><strong>Yes</strong>
              				<i class="fa fa-circle text-danger"></i><strong>No</strong> )
	              			<?= Html::a('<span class="btn btn-sm pull-right btn-warning" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Click to Add New Expense').'">Add Expense</span>', Yii::$app->request->baseUrl."/amount/create?type=2&applied=1&id=".Yii::$app->request->get('id'),['target'=>'_blank']) ?>
	            		</div>
			            <!-- /.box-header -->
			            <div class="box-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>								
										<th>#</th>									
										<th>Payment Detail</th>
										<th>Category</th>
										<th>Current Balance</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$j=1;
									foreach ($catdata["expense"] as $expvalue) 
									{
									?>
									<tr>
										<td>
											<?php 
												echo $j++,'&nbsp;'; 
												if($expvalue["recordbudget"]==1){ echo '<i class="fa fa-circle text-success"></i>'; }else{ echo '<i class="fa fa-circle text-danger"></i>'; }
											?>											
										</td>
										<td><?php echo $expvalue["payment_detail"]; ?></td>
										<td><?php echo $model3->categoryname($expvalue["category_id"]); ?></td>
										<td><?php echo $expvalue["amount"]; ?></td>									
										<td><?php echo $model2->dataformat($expvalue["selectdate"]); ?></td>
										<td>
											<a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-success" onclick="viewdetail(<?php echo $expvalue["id"]; ?>)">
												<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
											</a>
											|| 
											<a href="<?php echo Yii::$app->request->baseUrl."/amount/update?type=2&applied=1&userid=".$expvalue["user_id"]."&id=".$expvalue["id"]; ?>" class="btn btn-xs btn-warning" target="_blank">
												<span data-toggle="tooltip" title="Click To Update Details" data-placement="top"><i class="fa fa-pencil"></i></span>
											</a>
											|| 
											<a href="javascript:;" id="delete<?php echo $expvalue["id"]; ?>" onclick="datadelete(<?php echo $expvalue["id"]; ?>,'amount')" class="btn btn-xs btn-danger" data-method="post">
												<span data-toggle="tooltip" title="Click To Delete Details" data-placement="top"><i class="fa fa-trash"></i></span>
											</a>										
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
	          	<div class="tab-pane" id="settings">
	            	<div class="box box-success">
	            		<div class="box-header">
	              			<h3 class="box-title">View All Budget</h3>
	              			<?= Html::a('<span class="btn btn-sm pull-right btn-warning" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Click to Manage Budget').'">Manage Budget</span>', "javascript:;",['target'=>'_blank','data-toggle'=>"modal", 'data-target'=>"#modal-manage"]) 
	              			
	              			?>
	            		</div>
			            <!-- /.box-header -->
			            <div class="box-body">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>								
										<th>#</th>									
										<th>Category</th>
										<th>Budget </th>
										<th>Remain Day</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$b=1;
									$categorybudgetid='';
									foreach ($catdata["newbudgetdata"]["withbudget"] as $budgetvalue) 
									{
									?>
									<tr>
										<td><?php echo $b++; ?> <?php echo ($budgetvalue["repeat_type"]==1)?'<span class="badge btn-primary" data-toggle="tooltip" title="Weekly">W</span>':'<span class="badge btn-primary" data-toggle="tooltip" title="Monthly">M</span>'?></td>
										<td><?php echo $model3->categoryname($budgetvalue["category_id"]); ?></td>
										<td>
											<small class="pull-right"><strong><?php 
											(!empty(@$_POST["analysiscat"]))?$postmnt=@$_POST["analysiscat"]:$postmnt=date('m');
												$expget=$model2->getExpenseMonthWise($type=2,$user=1,$month=date('Y-').$postmnt,$budgetvalue["user_id"],$budgetvalue["category_id"]); echo '$'.$expget; ?>
												 /
												 <?php echo '$'.round($budgetvalue["amount"]); ?></strong></small>
											<br>
											<div class="progress progress-xs">
												<?php
												$perc=round(($expget*100)/round($budgetvalue["amount"]));
												?>
								                <div class="progress-bar progress-bar-yellow" role="progressbar" style="width: <?php echo($perc!="" || $perc!=0)?$perc:'0'; ?>%">
								                </div>
								            </div>
										</td>		
										<td><?php echo $model2->getDayInMonth(); ?></td>
										<td>
											<a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-budgetcategory" onclick="viewbudgetexpense(<?php echo $budgetvalue["user_id"]; ?>,<?php echo $budgetvalue["category_id"]; ?>,'0')">
												<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
											</a>
										</td>
									</tr>
									<?php 
									$categorybudgetid[]=$budgetvalue["category_id"];
									} 
									
									foreach ($catdata["newbudgetdata"]["withoutbudget"] as $budgetvalue2) 
									{
										if(!in_array($budgetvalue2["category_id"], $categorybudgetid))
										{
									?>
									<tr>
										<td><?php echo $b++; ?> <?php //echo ($budgetvalue2["repeat_type"]==1)?'<span class="badge btn-primary" data-toggle="tooltip" title="Weekly">W</span>':'<span class="badge btn-primary" data-toggle="tooltip" title="Monthly">M</span>'?></td>
										<td><?php echo $model3->categoryname($budgetvalue2["category_id"]); ?></td>
										<td>
											<small class="pull-right"><strong><?php 
											(!empty(@$_POST["analysiscat"]))?$postmnt=@$_POST["analysiscat"]:$postmnt=date('m');
												$expget=$model2->getExpenseMonthWise($type=2,$user=1,$month=date('Y-').$postmnt,$budgetvalue2["user_id"],$budgetvalue2["category_id"]); echo '$'.$expget; ?>
												 /
												 <?php 
												 //echo '$'.round($budgetvalue2["amount"]); 
												 echo '$0'; 
												 ?></strong></small>
											<br>
											<div class="progress progress-xs">
												<?php
												$perc=round(($expget*100)/round($budgetvalue2["amount"]));
												?>
								                <div class="progress-bar progress-bar-yellow" role="progressbar" style="width: <?php echo($perc!="" || $perc!=0)?$perc:'0'; ?>%">
								                </div>
								            </div>
										</td>		
										<td><?php echo $model2->getDayInMonth(); ?></td>
										<td>
											<a href="javascript:;" class="btn btn-xs btn-success" data-toggle="modal" data-target="#modal-budgetcategory" onclick="viewbudgetexpense(<?php echo $budgetvalue2["user_id"]; ?>,<?php echo $budgetvalue2["category_id"]; ?>,'0')">
												<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
											</a>
										</td>
									</tr>
									<?php } }  ?>	       
								</tbody>							
							</table>
		            	</div>
		            	<!-- /.box-body -->
		          	</div>
	            </div>            
	          	<!-- /.tab-pane -->
	          	<div class="tab-pane" id="targetbudget">
	            	<div class="box box-success">
	            		<div class="box-header">
	              			<h3 class="box-title">Target Budget</h3>  
	              			<?php
                        	if(empty($catdata["currentmonth"]))
                        	{

	              				echo Html::a('<span class="btn btn-sm pull-right btn-warning" data-toggle="tooltip" data-placement="top" title="'.Yii::t('app', 'Click to Add Target.').'">Add New</span>', Yii::$app->request->baseUrl."/target/create?type=1&id=".Yii::$app->request->get('id'),['target'=>'_blank']) ;
	              			}
	              			?>            			
	            		</div>
			            <!-- /.box-header -->
			            <div class="box-body">
			            <?php //print_r($catdata["targetdata"]);?>
							<table class="table table-bordered table-striped">
								<thead>
									<tr>								
										<th>#</th>									
										<th>Income</th>
										<th>Member</th>
										<th>Suggest Target</th>
										<th>Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$ta=1;
									foreach($catdata["targetuserdata"] as $targetvalue) 
									{
									?>								
									<tr>
										<td><?php echo $ta++; ?></td>
										<td><?php echo $targetvalue["income"]; ?></td>
										<td>
											Family: <?php echo $targetvalue["family_member"]; ?>
											<br>	
											Children: <?php echo $targetvalue["children_no"]; ?>
											<br>	
											Working: <?php echo $targetvalue["working_member"]; ?>
										</td>	
										<td><?php echo $targetvalue["suggest_target"]; ?></td>
										<td><?php $rt=explode(" ",$targetvalue["created_date"]); echo $rt[0]; ?></td>	
										<td>
											<a href="<?php echo Yii::$app->request->baseUrl."/user/viewsettarget?type=1&id=".$targetvalue["id"]?>" class="btn btn-xs btn-success" target="_blank">
												<span data-toggle="tooltip" title="Click To View Details" data-placement="top"><i class="fa fa-eye"></i></span>
											</a>
											<?php 
											$year1 = date("Y",strtotime($targetvalue['created_date']));
        									$month1 = date("m",strtotime($targetvalue['created_date']));  
											if(date('Y-m')==date($year1.'-'.$month1))
                        					{?>										
											|| 
											<a href="<?php echo Yii::$app->request->baseUrl."/target/update?type=1&id=".$targetvalue["id"]?>" class="btn btn-xs btn-warning" target="_blank">
												<span data-toggle="tooltip" title="Click To Update Details" data-placement="top"><i class="fa fa-pencil"></i></span>
											</a>
											<?php } ?>
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
    <!-- /.col -->
</div>


<div class="modal modal-default fade" id="modal-manage">
	<div class="modal-dialog" style="min-width: 65%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Manage Budget</h4>
				<a href="<?php echo Yii::$app->request->baseUrl."/amount/budget?type=2&account=0&group=0&id=".Yii::$app->request->get('id'); ?>" target="_blank" class="btn btn-sm btn-success pull-right"><i class="fa fa-pencil"></i> Add Budget</a>
			</div>
			<div class="modal-body">
				<table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Repeat</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>     
                    	<?php
						$i=1;
						foreach ($catdata["categoryuser"] as $usercatvalue) 
						{
						?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $model3->categoryname($usercatvalue["category_id"]); ?></td>
							<td><input type="text" name="cateuser_<?php echo $usercatvalue["id"]; ?>" id="cateuser_<?php echo $usercatvalue["id"]; ?>" value="<?php echo $usercatvalue["amount"]; ?>"></td>
							<td>
								<select name="repeat_<?php echo $usercatvalue["amount"]; ?>" id="repeat_<?php echo $usercatvalue["id"]; ?>">
									<option value="">Select Repeat</option>
									<option value="1" <?php echo($usercatvalue["repeat_type"]==1)?'selected="selected"':'';?>>Weekly</option>
									<option value="2" <?php echo($usercatvalue["repeat_type"]==2)?'selected="selected"':'';?>>Monthly</option>
								</select>								
							</td>									
							<td><?php echo $usercatvalue["created_date"]; ?></td>
							<td>
								<a href="javascript:;" class="btn btn-xs btn-info" onclick="updatebudget(<?php echo $usercatvalue["id"]; ?>);">
									<span data-toggle="tooltip" title="Click To Update" data-placement="top"><i class="fa fa-edit"></i> Update</span>
								</a>										
							</td>
						</tr>
						<?php } ?>	                             
                    </tbody>
              	</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-outline">Save changes</button>
		</div>
	</div>
	<!-- /.modal-content -->
</div>

<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-success">
	<div class="modal-dialog" style="min-width: 55%;">
		<div class="modal-content">			
			<div class="modal-body">
				<div class="box box-success">
		            <div class="box-header">
		              <h3 class="box-title">View Detail</h3>		              
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body no-padding">
		              <table class="table">
		                <tbody>
			                <tr>
			                  <th>Label</th>
			                  <th>Detail</th>
			                </tr>
			                <tr>
			                  <td>Type:</td>			                  
			                  <td><span class="badge bg-light-blue" id="vtype"></span></td>
			                </tr>
			                <tr>
			                  <td>Date</td>	                  
			                  <td><span id="vdate"></span></td>
			                </tr>
			                <tr>
			                  <td>Category</td>
			                  <td><span id="vcategory"></span></td>
			                </tr>
			                <tr>
			                  <td>Payment Detail</td>
			                  <td><span id="vpaydetail"></span></td>
			                </tr>
			                <tr>
			                  <td>Amount</td>
			                  <td><span id="vamount"></span></td>
			                </tr>
			                <tr>
			                  <td>Note</td>
			                  <td><span id="vnote"></span></td>
			                </tr>
			                <tr>
			                  <td>Bill Preview</td>
			                  <td><span id="vbillpreview"></span></td>
			                </tr>
			                <tr>
			                  <td>Repeat</td>
			                  <td><span id="vrepeat"></span></td>
			                </tr>
			                <tr>
			                  <td>Repetition Period</td>
			                  <td><span id="vrepeatpreiod"></span></td>
			                </tr>
			                <tr>
			                  <td>Status</td>
			                  <td><span id="vstatus"></span></td>
			                </tr>
			                <tr>
			                  <td>Created Date</td>
			                  <td><span id="vcreated"></span></td>
			                </tr>
			                <tr>
			                  <td>Modify Date</td>
			                  <td><span id="vmodify"></span></td>
			                </tr>
		              	</tbody>
		              </table>
		            </div>
		            <!-- /.box-body -->
		        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="modal-budgetcategory">
	<div class="modal-dialog" style="min-width: 65%;">
		<div class="modal-content">			
			<div class="modal-body">
				<div class="box box-success">
		            <div class="box-header">
		              <h3 class="box-title">View Detail By Budget Category</h3>		              
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body no-padding" id="showresponse">		              
		            </div>
		            <!-- /.box-body -->
		        </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script type="text/javascript">
function changestatus(id)
{
	$.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('user/changestatus'); ?>",
        data: {id: id},
        success: function (data) {
        	if(data==1)
        	{
        		$("#status_"+id).removeClass("btn-danger");
        		$("#status_"+id).addClass("btn-success");
        		$("#status_"+id).text("Status: Active");
        	}
        	else if(data==0)
        	{
        		//alert("danger");
        		$("#status_"+id).removeClass("btn-success");
        		$("#status_"+id).addClass("btn-danger");
        		$("#status_"+id).text("Status: Inactive");
        	}
        },
        error: function (exception) {
            alert("Error Found.");
        }
    });
}
function viewdetail(id)
{
	$.ajax({
        type: "GET",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('amount/viewdetail'); ?>",
        data: {id: id},
        dataType: 'json',
        success: function (result) {
        	if(result.type==1){ var ty="Income"; }else{ var ty="Expense"; }
        	$("#vtype").html(ty);
        	$("#vdate").html(result.selectdate);
			$("#vcategory").html(result.category_id);    
			$("#vpaydetail").html(result.payment_detail);
			$("#vamount").html(result.amount);    	
			$("#vnote").html(result.note);
			$("#vbillpreview").html('<img id="myImg" src="'+result.bill_image+'" width="100" height="100" onclick="showimage()" />');
			if(result.repeat==1){ var repe="Yes"; }else{ var repe="No"; }
			$("#vrepeat").html(repe);
			var repp=result.repitition_period;
			if(repp==1){ var shrepe="Daily"; }else if(repp==2){ var shrepe="Weekly"; }else if(repp==3){ var shrepe="Monthly"; }else if(repp==4){ var shrepe="Quaterly"; }else if(repp==5){ var shrepe="Half Yearly"; }else if(repp==6){ var shrepe="Yearly"; }else{ var shrepe="No"; }
			$("#vrepeatpreiod").html(shrepe);
			if(result.status==1){ var shstatus="Active"; }else{ var shstatus="Inactive"; }
			$("#vstatus").html(shstatus);
			$("#vcreated").html(result.created_date);
			$("#vmodify").html(result.modify_date); 			   	
        },
        error: function (exception){
            alert("Error Found.");
        }
    });
}
function updatebudget(id)
{
	var amt=$("#cateuser_"+id).val();
	if(amt=="")
	{
		alert("Amount Can't Be Update Blank Field.");
		return false;
	}
	var rep=$("#repeat_"+id).val();
	if(rep=="")
	{
		alert("Please Select Repeat Field.");
		return false;
	}
	var acc=0;
	$.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('amount/budgetupdate'); ?>",
        data: {id: id,amount:amt,repeat:rep,group:acc},
        success: function (result) {
        	alert("Update Successfully");
        	window.location.href="<?php echo Yii::$app->request->url; ?>";
        },
        error: function (exception){
            alert("Error Found.");
        }
    });
}
function viewbudgetexpense(id,catid,account)
{
	$("#showresponse").empty();
	$.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('amount/viewbudgetexpense'); ?>",
        data: {id: id,categoryid:catid,account:account},
        success: function (result) {
        	$("#showresponse").html(result);
        },
        error: function (exception){
            alert("Error Found.");
        }
    });
}
</script>
<!-- The Modal -->
<div id="myModal" class="modal imagemodal" style="text-align: center;">
  <a class="closeimg" onclick="closemodal()">&times;</a>
  <img class="modal-content" id="img01">
</div>
<script type="text/javascript">
function showimage()
{
	var modal = document.getElementById('myModal');
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var img = document.getElementById("myImg");
	var modalImg = document.getElementById("img01");
	//var captionText = document.getElementById("caption");
	img.onclick = function(){
	    modal.style.display = "block";
	    modalImg.src = this.src;
	    //captionText.innerHTML = this.alt;
	}
}
function closemodal()
{ 
	$("#myModal").css('display','none');
}
</script>
<style>
#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}
/* The Modal (background) */

/* The Modal (background) */
.imagemodal.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 9999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.imagemodal.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Add Animation */
 .imagemodal .modal-content {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.closeimg {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.closeimg:hover,
.closeimg:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}
</style>
<script type="text/javascript">
function displayfilter()
{
	$("#analysiscatfrm").submit();
}
function displaysummary(id)
{
	$('#loadingimage').show();
	var mnt=$("#analysissummary").val();
	$.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->getUrlManager()->createUrl('user/displaysummary'); ?>",
        data: {id: id,month:mnt},
         dataType: 'json',
        success: function (result) {
        	$("#anatotalinc").html(result.totalinome);
        	$("#anatotalexp").html(result.totalexpense);
        	$("#anasettarget").html(result.settarget);
        	$("#netcashflow").html(result.netcashflow);
        	$("#targetachi").html(result.targetachi);

        	$("#budgettotal").html(result.budgettotal);
        	$("#budgetspent").html(result.totalexpense);
        	$("#budgetdifference").html(result.budgetdiff);
        	$("#budgettopspent").html(result.budgettopspent);
        	$("#maxcategory").html(result.maxcategory);
        	$("#budgetminspent").html(result.budgetminspent);
        	$("#mincategory").html(result.mincategory);
			
        	$('#loadingimage').hide();
        },
        error: function (exception){
        	$('#loadingimage').hide();
            alert("Error Found.");
        }
    });
}	

</script>
<script type="text/javascript">
	var month = new Array();
	month[0] = "Jan";
	month[1] = "Feb";
	month[2] = "Mar";
	month[3] = "Apr";
	month[4] = "May";
	month[5] = "Jun";
	month[6] = "Jul";
	month[7] = "Aug";
	month[8] = "Sep";
	month[9] = "Oct";
	month[10] = "Nov";
	month[11] = "Dec";
$(document).ready(function(){
  displaysummary(<?php echo $userid; ?>);
  var cyear=$("#analysisyear").val();
  $(".showyear1").html(cyear);
  $(".showyear2").html(cyear);
  var cmonth=$("#analysiscat").val();
  if(cmonth=="12month")
  {
  	//alert("THis");
  	var date = new Date();
  	var intYear = date.getFullYear() - 1;
  	var cYear = date.getFullYear();
  	//$(".box.box-success p.text-center strong").empty();
  	$(".showmonth1").empty();
  	$(".showmonth1").append(month[date.getMonth()]);
  	$(".showyear1").empty();
  	$(".showyear1").append(intYear);
  	$(".showmonth2").empty();
  	$(".showmonth2").append(month[date.getMonth()]);
  	$(".showyear2").empty();
  	$(".showyear2").append(cYear);
  }
});
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title="Setting";
//print_r($data["editval"]);
?>
<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title.$editval[0]["incomefrom"]; ?></div>
        <div class="category-form user-form box">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="<?php echo(empty(Yii::$app->request->get('action')) || Yii::$app->request->get('type')=="1")?'active':''; ?>"><a href="#childrencal" data-toggle="tab">Children</a></li>   
                  <li class="<?php echo(Yii::$app->request->get('type')=="2")?'active':''; ?>"><a href="#childratio" data-toggle="tab">Child Ratio</a></li>   
                  <li class="<?php echo(Yii::$app->request->get('type')=="3")?'active':''; ?>"><a href="#familymember" data-toggle="tab">Family</a></li>
                  <li class="<?php echo(Yii::$app->request->get('type')=="4")?'active':''; ?>"><a href="#household" data-toggle="tab">House Hold</a></li> 
                </ul>
                <div class="tab-content">                   
                    <div class="<?php echo(empty(Yii::$app->request->get('action')) || Yii::$app->request->get('type')=="1")?'active':''; ?> tab-pane" id="childrencal">
                        <form id="demo-form" method="post" data-parsley-validate="true">                            
                            <div class="box-body"> 
                                <div class="col-md-2 box-body">                              
                                    <div class="form-group">
                                        <label>Income From</label>
                                        <input class="form-control" id="incomefrom" placeholder="Income From" type="text" name="incomefrom" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incomefrom"]:'';?>">
                                    </div>
                                </div>
                                <div class="col-md-2 box-body">
                                    <div class="form-group">
                                        <label>Income To</label>
                                        <input class="form-control" id="incometo" placeholder="Income To" type="text" name="incometo" required="true" data-parsley-required-message="This value is required." data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incometo"]:'';?>">
                                    </div> 
                                </div>
                                <div class="col-md-3 box-body">
                                    <div class="form-group">
                                        <label>Percentage</label>
                                        <input class="form-control" id="percentage" placeholder="Percentage" type="text" name="percentage" required="true" data-parsley-required-message="This value is required." data-parsley-required-message="This value is required." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["percentage"]:'';?>">
                                    </div>
                                </div>
                                <div class="col-md-2 box-body">
                                    <div class="form-group form_group_button margin">
                                        <button type="submit" name="childexpense" value="<?php echo(Yii::$app->request->get('action'))?'Update':'Save';?>" id="childexpense" class="btn btn-success margin">Save</button>
                                    </div>
                                </div>
                            </div>                            
                        </form>
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">List of Children Expense</h3>                            
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                  
                                            <th>Income Range</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $c=1; foreach ($data["children"] as $childrenvalue) { ?>   
                                        <tr>
                                            <td><?php echo $c++; ?></td>
                                            <td>
                                                <?php 
                                                    echo $childrenvalue["incomefrom"].' - ';  
                                                    echo($childrenvalue["incometo"]==0)?'above':$childrenvalue["incometo"];
                                                ?>
                                            </td>
                                            <td><?php echo $childrenvalue["percentage"]; ?></td>
                                            <td>
                                                <a href="<?php echo Yii::$app->request->baseUrl."/user/setting?action=update&type=1&id=".$childrenvalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                    <span data-toggle="tooltip" title="Click To Update" data-placement="top"><i class="fa fa-edit"></i> Update</span>
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
                    <div class="<?php echo(Yii::$app->request->get('type')=="2")?'active':''; ?> tab-pane" id="childratio">
                        <form id="demo-form" method="post" data-parsley-validate="true">                            
                            <div class="box-body"> 
                                <div class="col-md-3 box-body">                              
                                    <div class="form-group">
                                        <label>No. of Children</label>
                                        <input class="form-control" id="noofchildren" placeholder="No. of Children" type="text" name="noofchildren" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["children"]:'';?>">
                                    </div>
                                </div>
                                <div class="col-md-3 box-body">
                                    <div class="form-group">
                                        <label>Percentage</label>
                                        <input class="form-control" id="percentage" placeholder="Percentage" type="text" name="percentage" required="true" data-parsley-required-message="This value is required." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["percentage"]:'';?>">
                                    </div>
                                </div>
                                <div class="col-md-2 box-body">
                                    <div class="form-group form_group_button margin">
                                        <button type="submit" name="childratio" id="childratio" value="<?php echo(Yii::$app->request->get('action'))?'Update':'Save';?>" class="btn btn-success margin">Save</button>
                                    </div>
                                </div>
                            </div>                            
                        </form>
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">List of Child Ratio</h3>                            
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                  
                                            <th>No. of Children</th>                                            
                                            <th>Ratio</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $cr=1; foreach ($data["childratio"] as $childratiovalue) { ?>   
                                        <tr>
                                            <td><?php echo $cr++; ?></td>
                                            <td><?php echo $childratiovalue["children"]; ?></td>
                                            <td><?php echo $childratiovalue["percentage"]; ?></td>
                                            <td>
                                                <a href="<?php echo Yii::$app->request->baseUrl."/user/setting?action=update&type=2&id=".$childratiovalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                    <span data-toggle="tooltip" title="Click To Update" data-placement="top"><i class="fa fa-edit"></i> Update</span>
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
                    <div class="<?php echo(Yii::$app->request->get('type')=="3")?'active':''; ?> tab-pane" id="familymember">
                        <div class="box box-success">
                            <form id="demo-form" method="post" data-parsley-validate="true">                            
                                <div class="box-body"> 
                                    <div class="col-md-2 box-body">                              
                                        <div class="form-group">
                                            <label>No. of Family Member</label>
                                            <input class="form-control" id="noofchildren" placeholder="No. of Family Member" type="text" name="noofchildren" required="true" data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["children"]:'';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 box-body">                              
                                        <div class="form-group">
                                            <label>Income From</label>
                                            <input class="form-control" id="incomefrom" placeholder="Income From" type="text" name="incomefrom" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incomefrom"]:'';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 box-body">
                                        <div class="form-group">
                                            <label>Income To</label>
                                            <input class="form-control" id="incometo" placeholder="Income To" type="text" name="incometo" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incometo"]:'';?>">
                                        </div> 
                                    </div>
                                    <div class="col-md-3 box-body">
                                        <div class="form-group">
                                            <label>Percentage</label>
                                            <input class="form-control" id="percentage" placeholder="Percentage" type="text" name="percentage" required="true" data-parsley-required-message="This value is required." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["percentage"]:'';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 box-body">
                                        <div class="form-group form_group_button margin">
                                            <button type="submit" name="familyexpense" id="familyexpense" value="<?php echo(Yii::$app->request->get('action'))?'Update':'Save';?>" class="btn btn-success margin">Save</button>
                                        </div>
                                    </div>
                                </div>                            
                            </form>
                            <div class="box-header">
                                <h3 class="box-title">List of Family Expense</h3>                            
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>    
                                            <th>Family Member</th>                              
                                            <th>Income Range</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $c=1; foreach ($data["family"] as $familyvalue) { ?>   
                                        <tr>
                                            <td><?php echo $c++; ?></td>
                                            <td><?php echo $familyvalue["children"]; ?></td>
                                            <td>
                                                <?php 
                                                    echo $familyvalue["incomefrom"].' - ';  
                                                    echo($familyvalue["incometo"]==0)?'above':$familyvalue["incometo"];
                                                ?>
                                            </td>
                                            <td><?php echo $familyvalue["percentage"]; ?></td>
                                            <td>
                                                <a href="<?php echo Yii::$app->request->baseUrl."/user/setting?action=update&type=3&id=".$familyvalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                    <span data-toggle="tooltip" title="Click To Update" data-placement="top"><i class="fa fa-edit"></i> Update</span>
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
                    <div class="<?php echo(Yii::$app->request->get('type')=="4")?'active':''; ?> tab-pane" id="household">
                        <div class="box box-success">
                            <form id="demo-form" method="post" data-parsley-validate="true">                            
                                <div class="box-body"> 
                                    <div class="col-md-2 box-body">                              
                                        <div class="form-group">
                                            <label>Income From</label>
                                            <input class="form-control" id="incomefrom" placeholder="Income From" type="text" name="incomefrom" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incomefrom"]:'';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 box-body">
                                        <div class="form-group">
                                            <label>Income To</label>
                                            <input class="form-control" id="incometo" placeholder="Income To" type="text" name="incometo" required="true" data-parsley-required-message="This value is required." data-parsley-type="digits" data-parsley-digits-message="This value should be digits." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["incometo"]:'';?>">
                                        </div> 
                                    </div>
                                    <div class="col-md-3 box-body">
                                        <div class="form-group">
                                            <label>Percentage</label>
                                            <input class="form-control" id="percentage" placeholder="Percentage" type="text" name="percentage" required="true" data-parsley-required-message="This value is required." autocomplete="off" value="<?php echo(!empty($data["editval"]))?$data["editval"][0]["percentage"]:'';?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2 box-body">
                                        <div class="form-group form_group_button margin">
                                            <button type="submit" name="household" id="household" value="<?php echo(Yii::$app->request->get('action'))?'Update':'Save';?>" class="btn btn-success margin">Save</button>
                                        </div>
                                    </div>
                                </div>                            
                            </form>
                            <div class="box-header">
                                <h3 class="box-title">List of House Hold Expense</h3>                           
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                  
                                            <th>Income</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $c=1; foreach ($data["household"] as $householdvalue) { ?>   
                                        <tr>
                                            <td><?php echo $c++; ?></td>
                                            <td>
                                                <?php 
                                                    echo $householdvalue["incomefrom"].' - ';  
                                                    echo($householdvalue["incometo"]==0)?'above':$householdvalue["incometo"];
                                                ?>
                                            </td>
                                            <td><?php echo $householdvalue["percentage"]; ?></td>
                                            <td>
                                                <a href="<?php echo Yii::$app->request->baseUrl."/user/setting?action=update&type=4&id=".$householdvalue["id"]; ?>" class="btn btn-xs btn-warning">
                                                    <span data-toggle="tooltip" title="Click To Update" data-placement="top"><i class="fa fa-edit"></i> Update</span>
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
                </div>
            <!-- /.tab-content -->
            </div>
        </div>
    </div>
</div>
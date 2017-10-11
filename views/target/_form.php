<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\UserSearch;
$model1=new UserSearch();
$type=Yii::$app->request->get('type');
$id=Yii::$app->request->get('id');
if($type==2)
{
    $groupid=Yii::$app->request->get('groupid');
    /*$userlist=$model1->displayGroupUserForSelect($groupid);
    $listData=ArrayHelper::map($userlist,'id','nick_name');*/
}
$requesttype=Yii::$app->controller->action->id;

/* @var $this yii\web\View */
/* @var $model app\models\SetTarget */
/* @var $form yii\widgets\ActiveForm */
$year = date("Y",strtotime(date('Y-m-d')));
$month = date("m",strtotime(date('Y-m'))); 
?>

<div class="panel panel-primary">
    <div class="panel-heading"><?php echo $this->title; ?></div>
        <div class="category-form user-form box">

            <?php $form = ActiveForm::begin(['options' => ['data-parsley-validate' => true]]); ?>

                <div class="col-md-6 box-body">
                    <?php if(Yii::$app->request->get('type')==2)
                    {              
                        //$connection = Yii::$app->getDb(); 
                        //$editcommand = $connection->createCommand('Select * from set_target where id="'.$id.'" 'DATE_FORMAT(created_date,"%Y-%m")="'.$year."-".$month.'" AND status=1');   
                        //$viewtarget = $editcommand->queryAll(); 
                        $viewtargetamount='';
                        if($requesttype=="update")
                        {
                            $viewtarget=$model->find()->where(['id' => $id,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();  
                            $viewtargetamount=$viewtarget['income'];
                            $viewtargetid=$viewtarget['id'];
                        }
                        else
                        {
                            $viewtarget=$model->find()->where(['id' => $groupid,'DATE_FORMAT(created_date,"%Y-%m")'=>$year."-".$month, 'status' => 1,'type'=>2])->limit(1)->one();  
                            $viewtargetamount=$viewtarget['income'];
                            $viewtargetid=$id;
                        }
                             

                        //$form->field($model, 'user_id')->dropDownList($listData,['prompt'=>'Select User']);
                        /*foreach ($userlist as $value) 
                        {    
                            $editcommand = $connection->createCommand("Select * from target_amount where settarget_id=".$id." and user_id=".$value["id"]."");                          
                            $viewtarget = $editcommand->queryAll();                             
                            ?>
                            <div class="row margin">
                                <div class="col-md-6">
                                    <strong><?php echo $value["nick_name"]; ?></strong>
                                </div>
                                <div class="col-md-6">                                    
                                    <input class="form-control incomecal" required="true" data-parsley-required-message="This value is required." type="text" name="income[<?php echo $value["id"]; ?>]" value="<?php echo(!empty($viewtarget))?$viewtarget[0]["target_amount"]:'';?>">
                                </div>
                            </div>
                            <?php
                        }*/
                        ?>
                        <div class="row margin">
                            <div class="col-md-6">
                                <strong>
                                Income                                                                 
                                </strong>
                            </div>
                            <div class="col-md-6">                                    
                                <input class="form-control incomecal" required="true" data-parsley-required-message="This value is required." type="text" name="income[<?php echo $viewtargetid; ?>]" value="<?php echo $viewtargetamount;?>" maxlength="7">
                            </div>
                        </div>
                        <?php
                    } 
                    if(Yii::$app->request->get('type')==1)
                    {
                    ?>
                    <?= $form->field($model, 'income')->textInput(['maxlength' => true,'required'=>true,'data-parsley-type'=>'digit','maxlength'=>7]) ?>
                    <p class="text-green">(Income After deduction of mpf and taxes)</p>

                    <?= $form->field($model, 'family_member')->textInput(['type'=>'number','max'=>'5','min'=>'1','required'=>true,'data-parsley-type'=>'digit']) ?>

                    <?= $form->field($model, 'children_no')->textInput(['type'=>'number','max'=>'4','min'=>'0','required'=>true,'data-parsley-type'=>'digit']) ?>

                    <?= $form->field($model, 'working_member')->textInput(['type'=>'number','max'=>'10','min'=>'0','required'=>true,'data-parsley-type'=>'digit']) ?>

                    <?= $form->field($model, 'house_type')->dropDownList(['1' => 'Private', '2' => 'Rent'],['prompt'=>'Select','required'=>true]) ?>
                    <?php } ?>
                </div>                
                <div class="col-md-6 box-body">
                    <?php 
                    if(Yii::$app->request->get('type')==1)
                    {
                    ?>
                    <?= $form->field($model, 'monthly_rent')->textInput(['maxlength' => 9,'required'=>true,'data-parsley-pattern'=>"^[0-9]*\.[0-9]{1}$",'data-parsley-pattern-message'=>"Opening Balance should in 1 point decimal."]) ?>

                    <?= $form->field($model, 'investment_habit')->dropDownList(['1' => 'Yes', '2' => 'No'],['prompt'=>'Select','required'=>true]) ?>

                    <?= $form->field($model, 'confidence_meet_target')->dropDownList(['1' => 'Low (70%)', '2' => 'Medium (85%)', '3'=>'High (100%)'],['prompt'=>'Select','required'=>true])->label('Confidence Meet Target') ?>

                    <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive'],['prompt'=>'Select','required'=>true]); ?>
                    <?php } ?>
                    <div class="row margin">
                        <div class="col-md-4 box-body col-md-offset-2">
                            <a href="javascript:;" onclick="calculatetarget();" class="btn btn-sm btn-warning">Calculate Target</a>
                        </div>
                        <div class="col-md-4 box-body">

                            <?= $form->field($model, 'suggest_target')->textInput(['maxlength' => true,'placeholder'=>'Suggest Target','required'=>'true'])->label(false) ?>
                            <p class="text-green">Suggest Target</p>
                        </div>                                              
                    </div>                   
                
                    
                </div>
                <div class="form-group form_group_button margin">
                    <?= Html::submitButton($model->isNewRecord ? 'Set Target' : 'Set Target', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
function calculatetarget()
{
    var type=<?php echo Yii::$app->request->get('type'); ?>;    
    var income = $("#settarget-income").val();
    if(type==1)
    {
        var familymem = $("#settarget-family_member").val();
        var children = $("#settarget-children_no").val();
        var confidence = $("#settarget-confidence_meet_target").val();
        if(income=="" || familymem=="" || children=="" || confidence=="")
        {
            alert("Please Fill All Field.");
            return false;
        }
    }
    else
    {
        var sum=0;
        $('.incomecal').each(function(){
            sum += parseInt(this.value);
        });
        income=sum;
    }
    
    $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->request->baseUrl.'/target/calculatetarget'; ?>",
        data: {type: type,income:income,familymem:familymem,children:children,confidence:confidence},
        success: function (result) {
            $("#settarget-suggest_target").val(result);
        },
        error: function (exception){
            alert("Error Found.");
        }
    });}
</script>

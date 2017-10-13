<?php
use yii\helpers\Url;
use yii\helpers\Html;
/*if(empty(Yii::$app->user->identity->id))
{
    $this->redirect(['site/login']);
}*/
if(Yii::$app->user->isGuest==1)
{
    ?>
    <script type="text/javascript">
        window.location.href="<?php echo Yii::$app->request->baseUrl; ?>";
    </script>
    <?php 
}
?>


  <header class="main-header">
    <!-- Logo -->	
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>M</b>App</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>MillionSinger</b> App</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle user_nm" data-toggle="dropdown">
              <?php 
              $image="";
              $nick_name="";
              if(Yii::$app->user->isGuest!=1)
              {
                $nick_name=Yii::$app->user->identity->name;
                if(Yii::$app->user->identity->image!=null)
                {
                  if(!file_exists(Yii::$app->user->identity->image))
                  {
                    $image=Yii::$app->user->identity->image;
                  }
                  else
                  {
                    $image=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/avatar80_3.png';
                  }
                }
                else
                {
                  $image=Yii::$app->mycomponent->Siteurl().Yii::$app->request->baseUrl.'/upload/user/avatar80_3.png';            
                }
              }
              ?>
              <img src="<?= $image ?>" class="user-image" alt="User Image">
              <span class="hidden-xs usr_nk"><?php echo ucfirst($nick_name); ?></span>
			  <span class="fa fa-caret-down"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <!-- <li class="user-header">
                <img src="<?php //= $baseUrl ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li> -->
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!--<div class="">
                  <?//= Html::a('Profile',['/user/profile'],
                             // ['class' => 'btn btn-success btn-flat']);                                  
                  ?>
                </div>-->
                <div class="drp_menu">
                  <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Change password',['/user/changepassword'],
                              ['class' => '','title'=>'Change Password']);                                  
                  ?>
                </div>
                <div class="drp_menu">
                  <!-- <a href="<?php //= Url::to(['site/logout']); ?>" class="btn btn-default btn-flat">Sign out</a> -->
                  <?= Html::a('<span class="glyphicon glyphicon-log-out"></span> Sign-out',['/site/logout'],
                              ['class' => '', 'data-method'=>'post']);                                  
                  ?>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>

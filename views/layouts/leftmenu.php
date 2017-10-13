  <?php
   use yii\helpers\Url;
  ?>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php 
          $image="";
          $nick_name="";
          if(Yii::$app->user->isGuest!=1)
          {
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
          <img src="<?= $image ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $nick_name; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="<?php echo(Yii::$app->controller->id=='user' && Yii::$app->controller->action->id=='dashboard')?'active':'';?>">
          <a href="<?php echo Url::to(['user/dashboard']); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="<?php echo(Yii::$app->controller->id=='user' && Yii::$app->controller->action->id!='dashboard' && Yii::$app->controller->action->id!='outbox' && Yii::$app->controller->action->id!='mail' && Yii::$app->controller->action->id!='setting' || Yii::$app->controller->id=='amount' || Yii::$app->controller->id=='target')?'active':'';?>">
          <a href="<?php echo Url::to(['user/index']); ?>">
            <i class="fa fa-user"></i>
            User
          </a>          
        </li>
        <!-- Yii::$app->controller->action->id=='index' || Yii::$app->controller->action->id=='create' || Yii::$app->controller->action->id=='update' || Yii::$app->controller->action->id=='viewincome' || -->


           
          </ul>
        
       
        <!--
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i> 
            <span>Income Category</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php //echo Url::to(['incomecategory/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li>
            <li><a href="<?php //echo Url::to(['incomecategory/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li>
          </ul>
        </li> -->
 
        
		    <!-- <li class="<?php //echo(Yii::$app->controller->id=='groupmember')?'active':'';?>">
          <a href="<?php //echo Url::to(['groupmember/index']); ?>">
            <i class="fa fa-users"></i>
            Group Member
          </a>          
        </li> -->
        
        <!-- <li class="">
          <a href="<?php //echo Url::to(['amount/index']); ?>">
            <i class="fa fa-edit"></i> 
            Amoumt            
          </a>        
        </li>
        <li class="">
          <a href="<?php //echo Url::to(['targetamount/index']); ?>">
            <i class="fa fa-table"></i>Target Amount            
          </a>          
        </li>
        <li class="">
          <a href="<?php //echo Url::to(['targetamount/index']); ?>">
            <i class="fa fa-table"></i>Target Amount            
          </a>          
        </li> -->        
        <!-- <li class="treeview"> -->
          <!-- <a href="#"> -->
            <!-- <i class="fa fa-calendar"></i>  -->
            <!-- <span>Notice</span> -->
            <!-- <span class="pull-right-container"> -->
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <!-- <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small> -->
            <!-- </span> -->
          <!-- </a> -->
          <!-- <ul class="treeview-menu"> -->
            <!-- <li><a href="<?php //echo Url::to(['notice/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li> -->
            <!-- <li><a href="<?php //echo Url::to(['notice/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li> -->
          <!-- </ul> -->
        <!-- </li> -->
        <!-- <li class="treeview"> -->
          <!-- <a href=""> -->
            <!-- <i class="fa fa-envelope"></i>  -->
            <!-- <span>Notice Comment</span> -->
            <!-- <span class="pull-right-container"> -->
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <!-- <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small> -->
            <!-- </span> -->
          <!-- </a> -->
          <!-- <ul class="treeview-menu"> -->
            <!-- <li><a href="<?php //echo Url::to(['noticecomment/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li> -->
            <!-- <li><a href="<?php //echo Url::to(['noticecomment/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li> -->
          <!-- </ul> -->
        <!-- </li> -->
        
        <!-- <li class="<?php //echo(Yii::$app->controller->id=='notice')?'active':'';?>">
          <a href="<?php //echo Url::to(['notice/index']); ?>">
            <i class="fa fa-sticky-note-o"></i>Notice            
          </a>          
        </li> -->

        <!-- <li class="treeview"> -->
          <!-- <a href=""> -->
            <!-- <i class="fa fa-envelope"></i>  -->
            <!-- <span>Pages</span> -->
            <!-- <span class="pull-right-container"> -->
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <!-- <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small> -->
            <!-- </span> -->
          <!-- </a> -->
          <!-- <ul class="treeview-menu"> -->
            <!-- <li><a href="<?php //echo Url::to(['pages/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li> -->
            <!-- <li><a href="<?php //echo Url::to(['pages/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li> -->
          <!-- </ul> -->
        <!-- </li> -->
        <!-- <li class="treeview"> -->
          <!-- <a href=""> -->
            <!-- <i class="fa fa-envelope"></i>  -->
            <!-- <span>Ads Mgmt</span> -->
            <!-- <span class="pull-right-container"> -->
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
              <!-- <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <!-- <small class="label pull-right bg-red">5</small> --> 
            <!-- </span> -->
          <!-- </a> -->
          <!-- <ul class="treeview-menu"> -->
            <!-- <li><a href="<?php //echo Url::to(['adsmgmt/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li> -->
            <!-- <li><a href="<?php //echo Url::to(['adsmgmt/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li> -->
            <!-- <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li> -->
          <!-- </ul> -->
        <!-- </li> -->
        <!-- <li class="treeview"> -->
          <!-- <a href="#"> -->
            <!-- <i class="fa fa-folder"></i>  -->
            <!-- <span>Feedback</span> -->
            <!-- <span class="pull-right-container"> -->
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            <!-- </span> -->
          <!-- </a> -->
          <!-- <ul class="treeview-menu"> -->
            <!-- <li><a href="<?php //echo Url::to(['feedback/create']); ?>"><i class="fa fa-circle-o"></i> Create</a></li> -->
            <!-- <li><a href="<?php //echo Url::to(['feedback/index']); ?>"><i class="fa fa-circle-o"></i> View</a></li> -->
            <!-- <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li> -->
          </ul>
        </li>
        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> -->
      
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

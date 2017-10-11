<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

/*use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;*/
use app\assets\AppAsset;
use yii\helpers\Url;

//Use if condition to recognize the page is login page or not.


//AppAsset::register($this);
//$asset = app\assets\AppAsset::register($this);


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php //$this->head() ?>
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/css/custom.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/6868df04/css/bootstrap.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/bootstrap/css/bootstrap.min.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/dist/css/AdminLTE.min.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/dist/css/skins/_all-skins.min.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/iCheck/flat/blue.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/morris/morris.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/jvectormap/jquery-jvectormap-1.2.2.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/datepicker/datepicker3.css'; ?>">
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/daterangepicker/daterangepicker.css'; ?>">
      <!-- bootstrap wysihtml5 - text editor -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'; ?>">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/datatables/dataTables.bootstrap.css">
      <!-- Bootstrap Color Picker -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/colorpicker/bootstrap-colorpicker.min.css">
      <!-- Morris chart -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/morris/morris.css">
      <!-- jvectormap -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
      <!-- Date Picker -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/datepicker/datepicker3.css">
      <!-- Daterange picker -->
      <link rel="stylesheet" href="<?php echo Yii::getAlias('@web').'/assets/f45111d2/'; ?>plugins/daterangepicker/daterangepicker.css">
      <!-- Custom CSS -->
      <?php //echo Yii::getAlias('@webroot').'assets/'; ?>

      <?php $this->registerCssFile("@web/css/custom.css"); ?>
      
      <script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/jQuery/jquery-3.1.1.min.js"></script>

      <!-- jQuery UI 1.11.4 -->
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
      
      <script>
        $.widget.bridge('uibutton', $.ui.button);
      </script>
      <!-- Morris.js charts -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
      <!-- daterangepicker -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
      <style type="text/css">
      input.parsley-success,
      select.parsley-success,
      textarea.parsley-success {
        color: #468847;
        /*background-color: #DFF0D8;*/
        border: 1px solid #D6E9C6;
      }

      input.parsley-error,
      select.parsley-error,
      textarea.parsley-error {
        color: #B94A48;
       /* background-color: #F2DEDE;*/
        border: 1px solid #EED3D7;
      }

      .parsley-errors-list {
        margin: 2px 0 3px;
        padding: 0;
        list-style-type: none;
        font-size: 0.9em;
        line-height: 0.9em;
        opacity: 0;
        color:#FF0000;

        transition: all .3s ease-in;
        -o-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        -webkit-transition: all .3s ease-in;
      }

      .parsley-errors-list.filled {
        opacity: 1;
      }     
      </style>
</head>
<body class="skin-purple">
<?php $this->beginBody() ?>
<?php 
if (\Yii::$app->controller->action->id === 'login') {
    $asset = app\assets\AppAssetLogin::register($this);
	$baseUrl = $asset->baseUrl;
?>
<div class="wrap">
     <?php echo $this->render('../site/login.php', ['baseUrl' => $baseUrl]); ?>
    <div class="control-sidebar-bg"></div>
</div>

<?php 
}else{
	AppAsset::register($this);
   $asset = app\assets\AppAsset::register($this);
   $baseUrl = $asset->baseUrl;
  ?>

<div class="wrap">
    <?php echo $this->render('header.php', ['baseUrl' => $baseUrl]); ?>
    <?php echo $this->render('leftmenu.php', ['baseUrl' => $baseUrl]); ?>
    <?php echo $this->render('content.php', ['content' => $content]); ?>
    <?php echo $this->render('footer.php', ['baseUrl' => $baseUrl]); ?>
    <?php //echo $this->render('rightside.php', ['baseUrl' => $baseUrl]); ?>

    <div class="control-sidebar-bg"></div>
</div>
<?php }?>
<!-- <footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?php //= date('Y') ?></p>

        <p class="pull-right"><?php //= Yii::powered() ?></p>
    </div>
</footer> -->

<?php $this->endBody() ?>
<script type="text/javascript">
function datadelete(id,fpath)
{
  var r = confirm('Are You Sure To Delete This Record?'); 
    if(r==true)
  {   
    if(r==true)
    {   
      var string = 'id='+id;  
      var tr = $("#delete"+id).parent().parent(); 
      $.ajax({
        type: "POST",
        url: "<?php echo Yii::$app->request->baseUrl."/";?>"+fpath+"/delete?id="+id,
        data: string,
        cache: false,
        success: function(result)
        {
          tr.fadeOut('10000000');
        }
      });
    } 
    return false;
  }   
}
</script>
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>dist/parsley.min.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- FastClick -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>dist/js/demo.js"></script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>
<!-- Morris.js charts -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript">
  //INITIALIZE SPARKLINE CHARTS
  $(".sparkline").each(function () {
    var $this = $(this);
    $this.sparkline('html', $this.data());
  });
  //INITIALIZE SPARKLINE CHARTS
  $(".sparkline-group").each(function () {
    var $this = $(this);
    $this.sparkline('html', $this.data());
  });
</script>
<!-- jvectormap -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      format:'yyyy-m-d'
    });
</script>
<!-- bootstrap color picker -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<!-- ChartJS 1.0.1 -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/chartjs/Chart.min.js"></script>

<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>dist/js/pages/dashboard2.js"></script>
<!-- DataTables -->
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo Yii::getAlias('@web/assets/f45111d2/'); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
/*$(document).ready(function(){
  displaysummary('7');
});*/
</script>
<script>
  $(document).ready(function(){    
    $.fn.dataTableExt.sErrMode = 'throw';
    $(".table-striped").DataTable({
    "language": {
        "infoEmpty":"There is no record Found.",
      },
    //"scrollX": true,
    //"autoWidth": false
    });
    $(".table-striped").DataTable({    
      "scrollX": true,
    });
  });
  $(function () {
    
    $("#edit1").DataTable();
    $("#edit2").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    
    $(".my-colorpicker1").colorpicker(); 
  });
  /*$('.table-striped').DataTable({
    "language": {
        "infoEmpty":"My Custom Message On Empty Table";
    }
  });*/

</script>
<script>
  $(function () {
    "use strict";    
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data:[<?php echo (!empty($this->params["networthjson"]))?$this->params["networthjson"]:''; ?>],      
      barColors: ['#00C0EF', '#DADDE4'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Net Worth', 'Diff.'],
      hideHover: 'auto'
    });
  }); 
</script>
<script>
  $(function () {
    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas);

    var areaChartData = {
      labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      datasets: [
        {
          label: "Cash In",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: [<?php echo(!empty($this->params["cashinlist"]))?$this->params["cashinlist"]:''; ?>]
        },
        {
          label: "Cash Out",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: [<?php echo(!empty($this->params["cashoutlist"]))?$this->params["cashoutlist"]:''; ?>]
        }
      ]
    };

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);

  });
</script>
<script>
  $(function () {
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [<?php echo(!empty($this->params["analcatexpjson"]))?$this->params["analcatexpjson"]:''; ?>];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

  });
</script>
</body>
</html>

<?php $this->endPage() ?>

<?php $themeUrl = Yii::app()->theme->baseUrl ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(strtoupper(CHtml::encode($this->pageTitle))); ?></title>
    <link href="<?= $themeUrl ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!--Favicon-->
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/apple-icon-76x76.png" type="image/x-icon" />
    
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Font Awesome Icons -->
    <link href="<?= $themeUrl ?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Ionicons -->
    <link href="<?= $themeUrl ?>/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Theme style -->
    <link href="<?= $themeUrl ?>/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?= $themeUrl ?>/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $themeUrl ?>/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::app()->request->baseUrl ?>/css/site.css" rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::app()->request->baseUrl ?>/js/lobibox/css/lobibox.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/js/select2/select2/select2.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/js/select2/select2/select2-bootstrap.css">
    <!--Panel estadistico -->
    <link href="<?= Yii::app()->request->baseUrl?>/css/custom.css" rel="stylesheet">
    <!--Panel estadistico -->
    
    <!-- jQuery 2.1.4 -->
    
    <script src="<?= $themeUrl ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <!--<script src="<?php //Yii::app()->request->baseUrl; ?>/js/jQuery/jQuery-2.1.4.min.js"></script>-->
    <!--<script src="<?php //Yii::app()->request->baseUrl; ?>/js/nprogress/nprogress.js"></script>
    <script>
        NProgress.start();
    </script>-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?= $themeUrl ?>/js/html5shiv.min.js"></script>
    <script src="<?= $themeUrl ?>/js/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="skin-blue fixed sidebar-mini">

<style>
    .ui-dialog-titlebar-close {
        visibility: hidden;
    }
    .skin-yellow-light .main-header .navbar .sidebar-toggle:hover {
        background-color: #f4d62d !important;
    }
    .skin-yellow-light .main-header .navbar .nav>li>a {
        color: #000;
    }
    .skin-yellow-light .main-header .logo {
        color: #000;
    }
    .skin-yellow-light .main-header .navbar .sidebar-toggle {
        color: #000;
    }
    .navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
        color: #080808;
    }
    .breadcrumb{
        margin-bottom: 0px !important;
    }
</style>
<script>
    var baseURL = "<?= Yii::app()->request->requestUri ?>";
    var urlController = "<?= CController::createUrl('site/index') ?>";
</script>

<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= CController::createUrl('site/index') ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
           <i class="fa fa-shield"></i>
            <span>
                Activa SGSI
            </span>
                <!-- logo for regular state and mobile devices -->
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <?php echo $this->renderPartial('/sites/top-menu', compact('themeUrl')); ?>
            </div>
        </nav>
    </header>

    <!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <div class="profile">
                <div class="profile_pic">
                    <img src="<?= $themeUrl ?>/img/user7.jpg" class="img-circle profile_img" alt="User Image"/>
                    <!-- <img src="<?= $themeUrl ?>/img/avatar5.png" class="user-image" alt="User Image"/>-->
                </div>
                <div class="profile_info">
                        <span class="profile_hello">Bienvenido,</span><br>
                        <h2 class="profile_name"><?= ucwords(strtolower(Yii::app()->user->model->username)) ?></h2>
                
                </div>
            </div>
            <?php echo $this->renderPartial('/sites/menu', array('items' => Menu::model()->menuPadres())); ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" style="padding: 0px !important;">
            <?php $this->widget('application.components.Notify'); ?>
        </section>

        <!-- Main content -->
        <section class="content">
            
            <!-- Default box -->
            <?php echo $content; ?>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; <?= Date('Y')?> </strong> Todos los derechos reservados.
    </footer>
</div>

<!-- ./wrapper -->
<script src="<?= $themeUrl ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>


<!-- SlimScroll -->
<script src="<?= $themeUrl ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?= $themeUrl ?>/plugins/fastclick/fastclick.min.js'></script>
<!--Progress Bar-->

<!-- AdminLTE App -->
<script src="<?= $themeUrl ?>/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $themeUrl ?>/js/demo.js" type="text/javascript"></script>
<script src="<?= $themeUrl ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootbox/bootbox.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/inputmask/inputmask.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/inputmask/jquery.inputmask.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/inputmask/inputmask.date.extensions.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/inputmask/inputmask.numeric.extensions.js"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/js-kartik/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/js-kartik/fileinput.min.js" type="text/javascript"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/js-kartik/fileinput_locale_es.js" type="text/javascript"></script>

<script src="<?= Yii::app()->request->baseUrl ?>/js/select2/select2/select2.js" type="text/javascript"></script>
<!-- gauge js -->
<script src="<?= Yii::app()->request->baseUrl?>/js/gauge/gauge.min.js" type="text/javascript"></script>
<!-- chart js -->
<script src="<?= Yii::app()->request->baseUrl?>/js/chartjs/chart.min.js" type="text/javascript"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/progressbar/bootstrap-progressbar.min.js"></script>
<script src="<?= Yii::app()->request->baseUrl;?>/js/nicescroll/jquery.nicescroll.min.js"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/custom/custom.js" type="text/javascript"></script><
<script src="<?= Yii::app()->request->baseUrl?>/js/lobibox/js/lobibox.js" type="text/javascript"></script>
<script src="<?= Yii::app()->request->baseUrl?>/js/icheck/icheck.min.js"></script>

<script>
 

    $(document).ready(function () {
            // [17, 74, 6, 39, 20, 85, 7]
            //[82, 23, 66, 9, 99, 6, 2]
            var data1 = [[gd(2012, 1, 1), 17], [gd(2012, 1, 2), 74], [gd(2012, 1, 3), 6], [gd(2012, 1, 4), 39], [gd(2012, 1, 5), 20], [gd(2012, 1, 6), 85], [gd(2012, 1, 7), 7]];

            var data2 = [[gd(2012, 1, 1), 82], [gd(2012, 1, 2), 23], [gd(2012, 1, 3), 66], [gd(2012, 1, 4), 9], [gd(2012, 1, 5), 119], [gd(2012, 1, 6), 6], [gd(2012, 1, 7), 9]];
            $("#canvas_dahs").length && $.plot($("#canvas_dahs"), [
                data1, data2
            ], {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    verticalLines: true,
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#fff'
                },
                colors: ["rgba(38, 185, 154, 0.38)", "rgba(3, 88, 106, 0.38)"],
                xaxis: {
                    tickColor: "rgba(51, 51, 51, 0.06)",
                    mode: "time",
                    tickSize: [1, "day"],
                    //tickLength: 10,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Verdana, Arial',
                    axisLabelPadding: 10
                        //mode: "time", timeformat: "%m/%d/%y", minTickSize: [1, "day"]
                },
                yaxis: {
                    ticks: 8,
                    tickColor: "rgba(51, 51, 51, 0.06)",
                },
                tooltip: false
            });

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }
        });

        var doughnutData = [
            {
                value: 30,
                color: "#455C73"
            },
            {
                value: 30,
                color: "#9B59B6"
            },
            {
                value: 60,
                color: "#BDC3C7"
            },
            {
                value: 100,
                color: "#26B99A"
            },
            {
                value: 120,
                color: "#3498DB"
            }
        ];
        if(baseURL === urlController) {
            var myDoughnut = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(doughnutData);
        }

        var randomScalingFactor = function () {
            return Math.round(Math.random() * 100)
        };

        var barChartData = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    fillColor: "#26B99A", //rgba(220,220,220,0.5)
                    strokeColor: "#26B99A", //rgba(220,220,220,0.8)
                    highlightFill: "#36CAAB", //rgba(220,220,220,0.75)
                    highlightStroke: "#36CAAB", //rgba(220,220,220,1)
                    data: [51, 30, 40, 28, 92, 50, 45]
            },
                {
                    fillColor: "#03586A", //rgba(151,187,205,0.5)
                    strokeColor: "#03586A", //rgba(151,187,205,0.8)
                    highlightFill: "#066477", //rgba(151,187,205,0.75)
                    highlightStroke: "#066477", //rgba(151,187,205,1)
                    data: [41, 56, 25, 48, 72, 34, 12]
            }
        ],
        }
</script>


<script>

    function guardarSesionUrl(hijoId,padreId) {
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('menu/guardarMenuActivo')?>",
            data: {
                'hijoId': hijoId,
                'padreId': padreId
            },
            dataType: 'Text',

            success: function (data) {
            }
        });
    }

    function toPanel(event) {
        event.preventDefault();
        var proyecto_id = $("#eventos").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('proyecto/asignarProyecto')?>",
            data: {
                'proyecto_id': proyecto_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    window.location.replace(datos.url);
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
            }
        });
    }

    var currencyOptions = {
        'alias': 'numeric',
        'groupSeparator': '.',
        'radixPoint': ',',
        'autoGroup': true,
        'digits': 2,
        'digitsOptional': false,
        'prefix': '$ ',
        'placeholder': '0',
        'removeMaskOnSubmit': true,
        'unmaskAsNumber': true
    };

    var percentOptions = {
        'alias': 'numeric',
        'groupSeparator': '.',
        'radixPoint': ',',
        'autoGroup': true,
        'digits': 2,
        'suffix': '%',
        'digitsOptional': false,
        'placeholder': '0',
        'removeMaskOnSubmit': true,
        'unmaskAsNumber': true
    };

    var notifyOptions = {
        'soundPath': '<?= Yii::app()->request->baseUrl ?>/js/lobibox/sounds/',
        'position': 'top right',
        'size': 'mini'
    };
    Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, notifyOptions);

    $(function () {
        bootbox.setDefaults({locale: 'es'});
        $('.formatCurrency').inputmask(currencyOptions);

        $('.percent').inputmask(percentOptions);

        $('input').not('.checkbox-column *').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('.treeview-menu > li.active').parents('.treeview').addClass('active');

        $('#eventos').select2();
        $(".filter-container>select").css('height','30px');
        $(".filter-container>input").css('height','30px');
        setInterval(function () {
            $(".filter-container>select").css('height','30px');
            $(".filter-container>input").css('height','30px');
        },100)
    });
    //Esta funcion deshabilita el enter en para hacer un submit del formulario
    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });


 </script>
    
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/date.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="<?= Yii::app()->request->baseUrl?>/js/flot/jquery.flot.resize.js"></script>

 <script>

        
    

    </script>
    <!-- dashbord linegraph -->

    <script>

    </script>
    <!-- /dashbord linegraph -->
   <!-- <script>
        NProgress.done();
    </script>-->


 </body>
</html>
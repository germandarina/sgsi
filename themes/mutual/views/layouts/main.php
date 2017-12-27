<?php $themeUrl = Yii::app()->theme->baseUrl ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(strtolower(CHtml::encode($this->pageTitle))); ?></title>
    <link href="<?= $themeUrl ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/ladyeva_logo_ico.jpg" type="image/x-icon" />
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

    <!-- jQuery 2.1.4 -->
    <script src="<?= $themeUrl ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>

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
<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><?php echo ucwords(strtolower(CHtml::encode(Yii::app()->name))); ?></b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo ucwords(strtolower(CHtml::encode(Yii::app()->name))); ?></b></span>
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
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= $themeUrl ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p><?= ucwords(strtolower(Yii::app()->user->model->username)) ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> En Linea</a>
                </div>
            </div>
            <!-- search form -->
<!--            <form action="#" method="get" class="sidebar-form">-->
<!--                <div class="input-group">-->
<!--                    <input type="text" name="q" class="form-control" placeholder="Search..."/>-->
<!--              <span class="input-group-btn">-->
<!--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>-->
<!--                </button>-->
<!--              </span>-->
<!--                </div>-->
<!--            </form>-->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?php echo $this->renderPartial('/sites/menu', array('items' => Menu::model()->menuPadres())); ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
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
        <strong>Copyright &copy; 2015 <a href="http://3bytes.com.ar">3Bytes</a>.</strong> Todos los derechos reservados.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class='control-sidebar-menu'>
                    <li>
                        <a href='javascript::;'>
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                <p>nora@example.com</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class='control-sidebar-menu'>
                    <li>
                        <a href='javascript::;'>
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-waring pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href='javascript::;'>
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked/>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked/>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked/>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked/>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right"/>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class='control-sidebar-bg'></div>
</div>
<!-- ./wrapper -->

<script src="<?= $themeUrl ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!-- SlimScroll -->
<script src="<?= $themeUrl ?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?= $themeUrl ?>/plugins/fastclick/fastclick.min.js'></script>
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
<script src="<?= Yii::app()->request->baseUrl?>/js/lobibox/js/lobibox.js" type="text/javascript"></script>
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
    });
    //Esta funcion deshabilita el enter en para hacer un submit del formulario
    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });
 </script>
</body>
</html>
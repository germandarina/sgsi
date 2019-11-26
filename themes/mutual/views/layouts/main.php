<?php $themeUrl = Yii::app()->theme->baseUrl ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(strtolower(CHtml::encode($this->pageTitle))); ?></title>
    <link href="<?= $themeUrl ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/logo-chico.png" type="image/x-icon" />
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
</style>


<!-- Site wrapper -->
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= Yii::app()->getBaseUrl()?>" class="logo">
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
        <strong>Copyright &copy; <?= Date('Y')?> </strong> Todos los derechos reservados.
    </footer>
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
<script src="<?php echo Yii::app()->request->baseUrl ?>/js/select2/select2/select2.js" type="text/javascript"></script>

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

        $('.treeview-menu > li.active').parents('.treeview').addClass('active');

        $('#eventos').select2();
    });




    //Esta funcion deshabilita el enter en para hacer un submit del formulario
    $(document).on("keypress", "form", function(event) {
        return event.keyCode != 13;
    });
 </script>
</body>
</html>
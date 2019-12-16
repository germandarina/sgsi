<?php $themeUrl = Yii::app()->theme->baseUrl ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?= $themeUrl ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet"

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!--    <link rel="shortcut icon" href="--><?php //echo Yii::app()->request->baseUrl; ?><!--/images/logo-chico.png" type="image/x-icon" />-->

    <!-- Font Awesome Icons -->
    <link href="<?= $themeUrl ?>/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Theme style -->
    <link href="<?= $themeUrl ?>/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <!-- iCheck -->
    <link href="<?= $themeUrl ?>/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css"/>
    <link href="<?= Yii::app()->request->baseUrl ?>/css/site.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?= $themeUrl ?>/js/html5shiv.min.js"></script>
    <script src="<?= $themeUrl ?>/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<?php echo $content; ?>
<!-- jQuery 2.1.4 -->
<script src="<?= $themeUrl ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?= $themeUrl ?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!-- iCheck -->
<script src="<?= $themeUrl ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
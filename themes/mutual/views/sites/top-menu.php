<style type="text/css" media="screen">
    .dropdown-menu > li > a {
        background-color: #1e282c !important;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .control-sidebar-heading {
        font-weight: bold;
    }
</style>
<script>
    function asignarProyecto(event) {
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
                    Lobibox.notify('success',{msg: datos.msj});
                    setTimeout(function () {
                        window.location.replace(datos.url);
                    },300);
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
            }
        });
    }
</script>

<ul class="nav navbar-nav">
    <!-- Messages: style can be found in dropdown.less-->
        <?php  $usuario = User::model()->findByPk(Yii::app()->user->model->id);
        $proyecto = Proyecto::model()->findByPk($usuario->ultimo_proyecto_id);
        $proyecto = is_null($proyecto) ? new Proyecto() : $proyecto;
        $organizacion = $proyecto->organizacion;
        $organizacion = is_null($organizacion) ? new Organizacion() : $organizacion;
        ?>
            <li class="dropdown header">
                <a href="#"
                   style="font-family: fontAwesome; font-size: 12px; background-color: #367fa9;" class="dropdown-toggle btn">
                    <b>Organizacion: <?= ucwords(strtolower($organizacion->nombre)) ?></b>
                </a>
            </li>
        <li>
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <select name="eventos" id="eventos" onchange="asignarProyecto(event)">
                        <option disabled selected value>-- Seleccione --</option>
                        <?php
                        $proyectos =  Yii::app()->user->model->isAdmin() ? Proyecto::model()->findAll() : Proyecto::model()->getProyectosPorUsuario($usuario->id);
                        foreach ($proyectos as $pro) { ?>
                            <option value="<?= $pro->id ?>" <?= $pro->id == $proyecto->id ? 'selected="selected"' : '' ?>><?= $pro->nombre ?></option>
                        <?php } ?>
                    </select>
                </div>
            </form>
        </li>
    <!-- original -->
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= $themeUrl ?>/img/avatar5.png" class="user-image" alt="User Image"/>
            <span class="hidden-xs"><?= ucwords(strtolower(Yii::app()->user->model->username)) ?></span>
        </a>
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                <img src="<?= $themeUrl ?>/img/avatar5.png" class="img-circle" alt="User Image"/>
                <p>
                    <?= ucwords(strtolower(Yii::app()->user->model->username)) ?>
                </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="<?= Yii::app()->createUrl('user/cambiarPassword', array('id' => Yii::app()->user->model->id)) ?>"
                       class="btn btn-default btn-flat">Cambiar Password</a>
                </div>
                <div class="pull-right">
                    <a href="<?= Yii::app()->createUrl('site/logout') ?>" class="btn btn-default btn-flat">Cerrar
                        Sesion</a>
                </div>
            </li>
        </ul>
    </li>
    <!-- Control Sidebar Toggle Button -->
<!--    <li>-->
<!--        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--    </li>-->
</ul>

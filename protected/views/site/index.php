<!-- top tiles -->
                <div class="row tile_count">
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                            <div class="count">2500</div>
                            <span class="count_bottom"><i class="green">4% </i> From last Week</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
                            <div class="count">123.50</div>
                            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
                            <div class="count green">2,500</div>
                            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
                            <div class="count">4,567</div>
                            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
                            <div class="count">2,315</div>
                            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                            <div class="count">7,325</div>
                            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                        </div>
                    </div>

                </div>
                <!-- /top tiles -->
<div class="box">
   <div class="box-header">
        <h3 class="box-title"><?php echo $this->pageTitle=Yii::app()->name; ?> - Bienvenidos</h3>
   </div>
<?php  $usuario = User::model()->getUsuarioLogueado();
       $proyecto_usuario = ProyectoUsuario::model()->findByAttributes(['usuario_id'=>$usuario->id]);
       if(is_null($proyecto_usuario)){ ?>
            <div class="box-header">
                <h3 class="box-title">Ud no tiene ningun proyecto asignado para comenzar a trabajar. Comuniquese con su supervisor.</h3>
            </div>
       <?php } ?>
</div>

<?php //if(!Yii::app()->user->model->isGerencial() && !Yii::app()->user->model->isDataEntry() ) {?>
<!---->
<!--<div class="box">-->
<!---->
<!--    <div class="box box-success">-->
<!--        <h3>Proyectos Asignados</h3>-->
<!---->
<!--        --><?php
//        $proyecto = new Proyecto();
//        if(!Yii::app()->user->model->isAdmin())
//            $proyecto->usuario_id = Yii::app()->user->model->id;
//
//        $this->widget('booster.widgets.TbExtendedGridView',array(
//            'id'=>'proyecto-grid',
//            'fixedHeader' => false,
//            'headerOffset' => 10,
//            // 40px is the height of the main navigation at bootstrap
//            'type' => 'striped hover condensed',
//            'dataProvider' => $proyecto->search(),
//            'responsiveTable' => true,
//            'template' => "{summary}\n{items}\n{pager}",
//            'selectableRows' => 1,
//            'filter' => $proyecto,
//            'columns'=>array(
//                array(
//                    'type'=>'raw',
//                    'name'=>'nombre',
//                    'header'=>'Nombre',
//                    'value' => '"<a style=\"cursor:pointer\" onclick=\"asignarProyecto(event, $data->id) \" title=\"Valorar Amenaza\" class=\"linkCredito\">$data->nombre</a>"',
//                ),
//                'descripcion',
//                array(
//                    'name'=>'fecha',
//                    'header'=>'Fecha',
//                    'value'=>'Utilities::ViewDateFormat($data->fecha)',
//                    'filter'=>false,
//                ),
//                array(
//                    'name'=>'id',
//                    'header'=>'Areas',
//                    'value'=>'$data->getAreas()',
//                    'filter'=>false,
//                ),
////                'creaUserStamp',
////                'creaTimeStamp',
//            ),
//        )); ?>
<!--    </div>-->
<!---->
<!---->
<!---->
<!--</div>-->
<?php //}?>
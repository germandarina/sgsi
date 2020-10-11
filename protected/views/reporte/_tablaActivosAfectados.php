<!--Nuevo contenido-->
<div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <?php foreach ($areas as $area){?>
                                <div class="x_title">
                                    <h2 style="text-align: center;"> <strong> Area:</strong> <?= $area['nombre_area']?></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Activo</th>
                                                <th>Valor</th>
                                                <th>Proceso</th>
                                                <th>Responsable</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $resultados= Analisis::getActivosAfectadosPorArea($area['analisis_id'],$area['area_id']);?>
                                            <?php foreach ($resultados as $resultado){?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $resultado['nombre_activo'] ?></td>
                                                    <td><?= GrupoActivo::$arrayValores[$resultado['valor_activo']]?></td>
                                                    <td><?= $resultado['nombre_proceso'] ?></td>
                                                    <td><?= $resultado['responsable'] ?></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <?php foreach ($areas as $area){?>
                                <div class="x_title">
                                    <h2 style="text-align: center;"> <strong> Area:</strong> <?= $area['nombre_area']?></h2>
                                   <!-- <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">Settings 1</a>
                                                </li>
                                                <li><a href="#">Settings 2</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>-->
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Activo</th>
                                                <th>Valor</th>
                                                <th>Proceso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $resultados= Analisis::getActivosAfectadosPorArea($area['analisis_id'],$area['area_id']);?>
                                            <?php foreach ($resultados as $resultado){?>
                                                <tr>
                                                    <td></td>
                                                    <td><?= $resultado['nombre_activo'] ?></td>
                                                    <td><?= GrupoActivo::$arrayValores[$resultado['valor_activo']]?></td>
                                                    <td><?= $resultado['nombre_proceso'] ?></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php }?>
                            </div>
                        </div>
</div>
<div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Sesión Integridad </h2>
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
                                    <!--Inicio grafico-->
                                          <?php
                                            $this->widget(
                                                'chartjs.widgets.ChPie',
                                                array(
                                                    'width' => 400,
                                                    'height' => 200,
                                                    'htmlOptions' => array('id'=>'grafico1'),
                                                    'drawLabels' => true,
                                                    'datasets' => $datos['arrayGraficoIntegridad'],
                                                    'options' => array()
                                                )
                                            );
                                            ?>  
                                    <!--Fin Grafico-->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Sesión Disponibilidad</h2>
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
                                      <!--Inicio grafico-->
                                          <?php
                                            $this->widget(
                                                'chartjs.widgets.ChPie',
                                                array(
                                                    'width' => 400,
                                                    'height' => 200,
                                                    'htmlOptions' => array('id'=>'grafico2','title'=>'gay'),
                                                    'drawLabels' => true,
                                                    'datasets' => $datos['arrayGraficoDispo'],
                                                    'options' => array('title'=>'gay')
                                                )
                                            );
                                            ?>
                                    <!--Fin Grafico-->
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Sesión Confidencialidad</h2>
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
                                    <!--Inicio grafico-->
                                            <?php
                                                $this->widget(
                                                    'chartjs.widgets.ChPie',
                                                    array(
                                                        'width' => 400,
                                                        'height' => 200,
                                                        'htmlOptions' => array('id'=>'grafico3'),
                                                        'drawLabels' => true,
                                                        'datasets' => $datos['arrayGraficoConfi'],
                                                        'options' => array()
                                                    )
                                                );
                                                ?>
                                    <!--Fin Grafico-->
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2> Sesión Trazabilidad </h2>
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
                                    <!--Inicio grafico-->
                                              <?php
                                                $this->widget(
                                                    'chartjs.widgets.ChPie',
                                                    array(
                                                        'width' => 400,
                                                        'height' => 200,
                                                        'htmlOptions' => array('id'=>'grafico4'),
                                                        'drawLabels' => true,
                                                        'datasets' => $datos['arrayGraficoTraza'],
                                                        'options' => array()
                                                    )
                                                );
                                                ?>
                                    <!--Fin Grafico-->
                                </div>
                            </div>
                        </div>
                    </div>
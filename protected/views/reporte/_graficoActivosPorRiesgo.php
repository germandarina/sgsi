
<div class="box">
    <div class="row">
        <div class="col-sm-6">
            <?php
            $this->widget(
                'chartjs.widgets.ChPie',
                array(
                    'width' => 600,
                    'height' => 300,
                    'htmlOptions' => array('id'=>'grafico1'),
                    'drawLabels' => true,
                    'datasets' => $datos['arrayGraficoIntegridad'],
                    'options' => array()
                )
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->widget(
                'chartjs.widgets.ChPie',
                array(
                    'width' => 600,
                    'height' => 300,
                    'htmlOptions' => array('id'=>'grafico2','title'=>'gay'),
                    'drawLabels' => true,
                    'datasets' => $datos['arrayGraficoDispo'],
                    'options' => array('title'=>'gay')
                )
            );
            ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $this->widget(
                'chartjs.widgets.ChPie',
                array(
                    'width' => 600,
                    'height' => 300,
                    'htmlOptions' => array('id'=>'grafico3'),
                    'drawLabels' => true,
                    'datasets' => $datos['arrayGraficoConfi'],
                    'options' => array()
                )
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php
            $this->widget(
                'chartjs.widgets.ChPie',
                array(
                    'width' => 600,
                    'height' => 300,
                    'htmlOptions' => array('id'=>'grafico4'),
                    'drawLabels' => true,
                    'datasets' => $datos['arrayGraficoTraza'],
                    'options' => array()
                )
            );
            ?>
        </div>
    </div>
</div>
<br>
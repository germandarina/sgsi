<?php
$this->widget(
    'booster.widgets.TbBreadcrumbs',
    array(
        'links' => array('Analisis' => array('admin'), 'Ver Datos'),
    )
);
?>
<div class="box">
    <div class="box-header with-border">
        <h4>Datos del Analisis: <?php echo $model->nombre; ?></h4>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <br>
            <?php $this->widget(
                'booster.widgets.TbTabs',
                array(
                    'type' => 'tabs', // 'tabs' or 'pills'
                    'htmlOptions' => ['class' => 'nav-tabs-custom'],
                    'tabs' => array(
                        array('label' => 'Asociaciones',
                            'content' => $this->renderPartial('asociaciones', array('model'=>$model,'grupo_activo'=>$grupo_activo), true),
                            'active' => true,
                        ),
                        array('label' => 'Dependencias',
                            'content' => $this->renderPartial('dependencias', array('model'=>$model,'dependencia'=>$dependencia,'dependenciasPadres'=>$dependenciasPadres), true),
                        ),
                        array('label' => 'Valoración de Amenazas, Vulnerabilidades y Controles',
                            'content' => $this->renderPartial('valoraciones', array('model'=>$model,'amenaza'=>$amenaza,'grupo_activo'=>$grupo_activo), true),
                        ),
                        array('label' => 'Gestion de Riesgos',
                            'content' => $this->renderPartial('gestionDeRiesgos', array('model'=>$model,'amenaza'=>$amenaza,'grupo_activo'=>$grupo_activo,'actuacion'=>new ActuacionRiesgo()), true),
                        ),
                    ),
                )
            );
            ?>
        </div>
    </div>
</div>

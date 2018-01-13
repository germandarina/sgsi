
<?php
$this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'valoraciones-grid',
    'fixedHeader' => false,
    'headerOffset' => 10,
    // 40px is the height of the main navigation at bootstrap
    'type' => 'striped hover condensed',
    'dataProvider' => $grupo_activo->searchValoraciones(),
    'responsiveTable' => true,
    'template' => "{items}\n{pager}",
    'selectableRows' => 1,
    'filter' => $grupo_activo,
    'columns'=>array(
        array(
            'name'=>'amenaza_nombre',
            'header'=>'Amenazas',
            'value'=>'$data->amenaza_nombre',
        ),
        array(
            'name'=>'tipo_activo_nombre',
            'header'=>'Tipo Activo',
            'value'=>'$data->tipo_activo_nombre',
        ),
        array( 'name'=>'grupo_nombre',
            'header'=>'Grupo',
            'value'=>'$data->grupo_nombre'
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{valoracion}',
            'header' => 'Ver Valoracion',
            'buttons' => array(
                'valoracion' => array(
                    'label' => 'Ver Valoracion',
                    'icon' => 'fa fa-star',
                    'url' => 'Yii::app()->createUrl("/analisis/verValoracion", array("id"=>$data->amenaza_id,"analisis_id"=>$data->analisis_id))',
                ),
            ),
            'htmlOptions' => array('style' => 'width:5%;text-align:center;')
        ),
    ),
)); ?>


<div class="modal fade" id="modalAsociaciones" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Nueva Asociacion</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php echo $this->renderPartial('_formAsociaciones', array('model' => $model, 'grupo_activo' => $grupo_activo,)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarAsociacion()" class="btn btn-success" id="botonModal">
                    Agregar Asociacion
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

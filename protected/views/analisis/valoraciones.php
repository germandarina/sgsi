
<?php
$this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'valoraciones-grid',
    'fixedHeader' => false,
    'headerOffset' => 10,
    // 40px is the height of the main navigation at bootstrap
    'type' => 'striped hover condensed',
    'dataProvider' => $amenaza->searchValoraciones(),
    'responsiveTable' => true,
    'template' => "{items}\n{pager}",
    'selectableRows' => 1,
    'filter' => $amenaza,
    'columns'=>array(
        array(
            'name'=>'nombre',
            'header'=>'Amenazas',
            'value'=>'$data->nombre',
        ),
        array(
            'name'=>'activo_nombre',
            'header'=>'Activo',
            'value'=>'$data->activo_nombre',
        ),
        array(
            'name'=>'tipo_activo_id',
            'header'=>'Tipo Activo',
            'value'=>'$data->tipoActivo->nombre',
            'filter' => CHtml::listData(TipoActivo::model()->getTipoActivoDelAnalisis($model->id),'id','nombre'),

        ),
        array(
            'name'=>'grupo_nombre',
            'header'=>'Grupo',
            'value'=>'$data->getGrupo()',
            'filter' => CHtml::listData(Grupo::model()->getGruposDelAnalisis($model->id),'id','nombre'),
        ),
        array( 'name'=>'fecha_valor_amenaza',
            'header'=>'Fecha Valoracion',
            'value'=>'$data->getFechaValorAmenaza()',
            'filter'=>false,
        ),
        array( 'name'=>'valor_amenaza',
            'header'=>'Valor Amenaza',
            'value'=>'$data->getValorAmenaza()',
            'filter'=>false,
        ),
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{valoracion}',
            'header' => 'Valorar Controles / Vulnerabilidades',
            'buttons' => array(
                'valoracion' => array(
                    'label' => 'Ver Valoracion',
                    'icon' => 'fa fa-star',
                    'url' => 'Yii::app()->createUrl("/analisis/verValoracion", array("id"=>$data->id,"analisis_id"=>$data->analisis_id,"grupo_id"=>$data->grupo_id))',
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

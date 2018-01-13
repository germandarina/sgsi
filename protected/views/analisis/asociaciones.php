<script>
    function levantarModalAsociaciones() {
       $("#GrupoActivo_grupo_id").val("");
       $("#GrupoActivo_confidencialidad").val("");
       $("#GrupoActivo_confidencialidad").attr('min',0);
       $("#GrupoActivo_trazabilidad").val("");
       $("#GrupoActivo_trazabilidad").attr('min',0);
       $("#GrupoActivo_integridad").val("");
       $("#GrupoActivo_integridad").attr('min',0);
       $("#GrupoActivo_disponibilidad").val("");
       $("#GrupoActivo_disponibilidad").attr('min',0);
       $("#modalAsociaciones").modal('show');
    }
    
    function getActivos() {
        var grupo_id = $("#GrupoActivo_grupo_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/getActivosPorTipo')?>",
            data: {'grupo_id': grupo_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var activos = datos.activos;

                $("#GrupoActivo_activo_id").find('option').remove();
                $("#GrupoActivo_activo_id").select2('val', null);
                if(activos.length >0){
                    $.each(activos, function (i, activo) {
                        $("#GrupoActivo_activo_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                    });
                }
            }
        });
    }
    function guardarAsociacion() {
        var grupo_id = $("#GrupoActivo_grupo_id").val();
        var activo_id = $("#GrupoActivo_activo_id").val();
        var confidencialidad = $("#GrupoActivo_confidencialidad").val();
        var trazabilidad = $("#GrupoActivo_trazabilidad").val();
        var integridad = $("#GrupoActivo_integridad").val();
        var disponibilidad = $("#GrupoActivo_disponibilidad").val();
        var analisis_id = $("#analisis_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/crearGrupoActivo')?>",
            data: { 'grupo_id': grupo_id,
                    'analisis_id':analisis_id,
                    'activo_id':activo_id,
                    'confidencialidad':confidencialidad,
                    'trazabilidad':trazabilidad,
                    'integridad':integridad,
                    'disponibilidad':disponibilidad
                },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 1){
                    Lobibox.notify('error',{msg: datos.msj});
                }else{
                    Lobibox.notify('success',{msg: datos.msj});
                }
                $.fn.yiiGridView.update('asociaciones-grid');
            }
        });

    }
</script>

<div class="box-header">
    <?php $this->widget('booster.widgets.TbButton', array(
        'label'=> 'Asociaciones ( + )',
        'context'=>'success',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:levantarModalAsociaciones()')
    ));
    ?>
</div>

<?php
    $this->widget('booster.widgets.TbExtendedGridView',array(
    'id'=>'asociaciones-grid',
    'fixedHeader' => false,
    'headerOffset' => 10,
    // 40px is the height of the main navigation at bootstrap
    'type' => 'striped hover condensed',
    'dataProvider' => $grupo_activo->search(),
    'responsiveTable' => true,
    'template' => "{summary}\n{items}\n{pager}",
    'selectableRows' => 1,
    //'filter' => $grupo_activo,
    'columns'=>array(
        array( 'name'=>'grupo_id',
            'header'=>'Grupo',
            'value'=>function($data){
                $grupo = $data->grupo;
                if(is_null($grupo)){
                    return '---';
                }else{
                    return $grupo->nombre;
                }
            },
        ),
        array(
            'name'=>'grupo_id',
            'header'=>'Tipo Activo',
            'value'=>function($data){
                $grupo = $data->activo->tipoActivo->nombre;
                if(is_null($grupo)){
                    return '---';
                }else{
                    return $grupo;
                }
            },
        ),
        array(
            'name'=>'activo_id',
            'header'=>'Activo',
            'value'=>'$data->activo->nombre',
        ),
        array(
            'name'=>'activo_id',
            'header'=>'Descripcion',
            'value'=>'$data->activo->descripcion',
        ),
        array(
            'name'=>'activo_id',
            'header'=>'Personal',
            'value'=>'$data->activo->getPersonal()',
        ),

        'confidencialidad',
        'integridad',
        'disponibilidad',
        'trazabilidad',
        'valor',
//        array(
//            'class'=>'booster.widgets.TbButtonColumn',
//            'template'=>'{delete}'
//        ),
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

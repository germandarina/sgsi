<script>
    function levantarModalDependencias() {
       $("#GrupoActivo_grupo_id").val("");
       $("#GrupoActivo_confidencialidad").val("");
       $("#GrupoActivo_confidencialidad").attr('min',0);
       $("#GrupoActivo_trazabilidad").val("");
       $("#GrupoActivo_trazabilidad").attr('min',0);
       $("#GrupoActivo_integridad").val("");
       $("#GrupoActivo_integridad").attr('min',0);
       $("#GrupoActivo_disponibilidad").val("");
       $("#GrupoActivo_disponibilidad").attr('min',0);
       $("#modalDependencias").modal('show');
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
    function guardarDependencia() {
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
        'label'=> 'Dependencias ( + )',
        'context'=>'success',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:levantarModalDependencias()')
    ));
    ?>
</div>


<div class="modal fade" id="modalDependencias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Nueva Dependencia</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php echo $this->renderPartial('_formDependencias', array('model' => $model, 'dependencia' => $dependencia,)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarDependencia()" class="btn btn-success" id="botonModal">
                    Agregar Dependencia
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

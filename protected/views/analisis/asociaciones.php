<script>
    function levantarModalAsociaciones() {
        limpiarModalAsociacion();
       $("#modalAsociaciones").modal('show');
    }
    function limpiarModalAsociacion() {
        $("#GrupoActivo_grupo_id").val("");
        $("#grupo_activo_id").val("");
        $("#GrupoActivo_grupo_id").select2('val',"");
        $("#GrupoActivo_confidencialidad").select2('val',"");
        $("#GrupoActivo_activo_id").select2('val',"");
        $("#GrupoActivo_trazabilidad").select2('val',"");
        $("#GrupoActivo_integridad").select2('val',"");
        $("#GrupoActivo_disponibilidad").select2('val',"");
        $("#divDisponibilidad").css('display','none');
        $("#divTrazabilidad").css('display','none');
        $("#divConfidencialidad").css('display','none');
        $("#divIntegridad").css('display','none');
    }

    function getActivos() {
        var grupo_id = $("#GrupoActivo_grupo_id").val();
        var activo_id = $("#GrupoActivo_activo_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/getActivosPorTipo')?>",
            data: {'grupo_id': grupo_id,
                    'activo_id':activo_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var activos = datos.activos;
                var tipoActivo = datos.tipoActivo;

                if(activo_id != "" && activo_id != 0){
                    $("#GrupoActivo_activo_id").select2('val',activo_id);
                }else{
                    $("#GrupoActivo_activo_id").find('option').remove();
                    $("#GrupoActivo_activo_id").select2('val', null);
                    if(activos.length >0){
                        $.each(activos, function (i, activo) {
                            $("#GrupoActivo_activo_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                        });
                    }
                }

                if(tipoActivo.disponibilidad == "1"){
                    $("#divDisponibilidad").css('display','block');
                }else{
                    $("#divDisponibilidad").css('display','none');
                }
                if(tipoActivo.confidencialidad == "1"){
                    $("#divConfidencialidad").css('display','block');
                }else{
                    $("#divConfidencialidad").css('display','none');
                }
                if(tipoActivo.trazabilidad == "1"){
                    $("#divTrazabilidad").css('display','block');
                }else{
                    $("#divTrazabilidad").css('display','none');
                }
                if(tipoActivo.integridad == "1"){
                    $("#divIntegridad").css('display','block');

                }else{
                    $("#divIntegridad").css('display','none');
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
        var grupo_activo_id = $("#grupo_activo_id").val();
        if(activo_id == ""){
            return Lobibox.notify('error',{msg:'Debe seleccionar un activo'});
        }
        event.preventDefault();
        Lobibox.confirm({
            title:'Confirmar',
            msg: "Esta seguro de realizar este proceso?",
            callback: function (lobibox, type) {
                if (type === 'yes') {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo CController::createUrl('analisis/crearGrupoActivo')?>",
                        data: { 'grupo_id': grupo_id,
                            'analisis_id':analisis_id,
                            'activo_id':activo_id,
                            'confidencialidad':confidencialidad,
                            'trazabilidad':trazabilidad,
                            'integridad':integridad,
                            'disponibilidad':disponibilidad,
                            'grupo_activo_id':grupo_activo_id
                        },
                        dataType: 'Text',
                        success: function (data) {
                            var datos = jQuery.parseJSON(data);
                            if(datos.error == 1){
                                Lobibox.notify('error',{msg: datos.msj});
                            }else{
                                Lobibox.notify('success',{msg: datos.msj});
                                limpiarModalAsociacion();
                            }
                            $.fn.yiiGridView.update('asociaciones-grid');
                        }
                    });
                } else {
                    return false;
                }
            }
        });
    }

    function getGrupoActivo(event,grupo_activo_id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/getGrupoActivo')?>",
            data: { 'grupo_activo_id': grupo_activo_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var grupo_activo = datos.grupo_activo;
                $("#grupo_activo_id").val(grupo_activo.id);
                if(grupo_activo.grupo_id != null){
                    $("#GrupoActivo_grupo_id").val(grupo_activo.grupo_id);
                    $("#GrupoActivo_grupo_id").select2('val',grupo_activo.grupo_id);
                }else{
                    $("#GrupoActivo_activo_id").val(grupo_activo.activo_id);
                    $("#GrupoActivo_activo_id").select2('val',grupo_activo.activo_id);
                }
                getActivos();
                $("#analisis_id").val(grupo_activo_id.analisis_id);
                $("#GrupoActivo_confidencialidad").select2('val',grupo_activo.confidencialidad);
                $("#GrupoActivo_confidencialidad").val(grupo_activo.confidencialidad);
                $("#GrupoActivo_trazabilidad").select2('val',grupo_activo.trazabilidad);
                $("#GrupoActivo_trazabilidad").val(grupo_activo.trazabilidad);
                $("#GrupoActivo_integridad").select2('val',grupo_activo.integridad);
                $("#GrupoActivo_integridad").val(grupo_activo.integridad);
                $("#GrupoActivo_disponibilidad").select2('val',grupo_activo.disponibilidad);
                $("#GrupoActivo_disponibilidad").val(grupo_activo.disponibilidad);
                setTimeout(function () {
                    $("#GrupoActivo_activo_id").val(grupo_activo.activo_id);
                    $("#GrupoActivo_activo_id").select2('val',grupo_activo.activo_id);
                    $("#modalAsociaciones").modal('show');
                },500);



            }
        });
    }

    function eliminarGrupoActivo(event,grupo_activo_id) {
        event.preventDefault();
        Lobibox.confirm({
            title:'Confirmar',
            msg: "Esta seguro de crear esta asociacion?",
            callback: function (lobibox, type) {
                if (type === 'yes') {
                    $.ajax({
                        type: "POST",
                        url: '<?= CController::createUrl('analisis/eliminarGrupoActivo') ?>',
                        data: {
                        "grupo_activo_id": grupo_activo_id
                        },
                    success: function (data) {
                        var datos = jQuery.parseJSON(data);
                        if(datos.error == "0"){
                            Lobibox.notify('success', {msg: "El proceso se realizo con exito"});
                            $.fn.yiiGridView.update('asociaciones-grid');
                        }else{
                            Lobibox.notify('error', {msg: datos.msj});
                        }
                    }
                });
                } else {
                    return false;
                }
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
        [
        'header' => 'Acciones',
        'type' => 'raw',
        'value' => '"<a onclick=\"getGrupoActivo(event,$data->id) \" title=\"Presione para ver\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-pencil\"></i></a>&nbsp;&nbsp;<a onclick=\"eliminarGrupoActivo(event,$data->id) \" title=\"Presione para eliminar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-trash\"></i></a>"',
        ]
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
                    Guardar Asociacion
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

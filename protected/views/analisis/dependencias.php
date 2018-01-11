<script>
    function levantarModalDependencias() {
       $("#Dependencia_activo_id").select2('val',"");
       $("#Dependencia_activo_padre_id").select2('val',"");
        var analisis_id = $("#analisis_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/getPadresEHijos')?>",
            data: {'analisis_id': analisis_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var padres = datos.padres;
                var hijos = datos.hijos;

                if(padres.length >0){
                    $("#Dependencia_activo_padre_id").find('option').remove();
                    $("#Dependencia_activo_padre_id").select2('val', null);
                    $.each(padres, function (i, activo) {
                        $("#Dependencia_activo_padre_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                    });
                }

                if(hijos.length >0){
                    $("#Dependencia_activo_id").find('option').remove();
                    $("#Dependencia_activo_id").select2('val', null);
                    $.each(hijos, function (i, activo) {
                        $("#Dependencia_activo_id").append('<option value="' + activo.id + '">' + activo.nombre + '</option>');
                    });
                }
            }
        });
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
        var activo_padre_id = $("#Dependencia_activo_padre_id").val();
        var activo_id = $("#Dependencia_activo_id").val();
        var analisis_id = $("#analisis_id").val();
        if(activo_padre_id == activo_id){
            return Lobibox.notify('error',{msg: "El activo hijo no puede ser el mismo que el padre. Seleccione otro activo."})
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/crearDependencia')?>",
            data: { 'activo_padre_id': activo_padre_id,
                    'analisis_id':analisis_id,
                    'activo_id':activo_id
                },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 1){
                    Lobibox.notify('error',{msg: datos.msj});
                }else{
                    Lobibox.notify('success',{msg: datos.msj});
                    $("#modalDependencias").modal('hide');
                    setTimeout(function () {
                        levantarModalDependencias();
                    },250)
                }

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
<div class="box box-success">
    <?php if(!empty($dependenciasPadres)){?>
        <ul>
            <?php foreach ($dependenciasPadres as $dependenciaPadre){?>
                <li ><span><h4><a href="#"><icon class="fa fa-cogs"></a>&nbsp;&nbsp;&nbsp;<?= $dependenciaPadre->activo->nombre ?></h4>
                    <?php $hijos = Dependencia::model()->findAllByAttributes(array('activo_padre_id'=>$dependenciaPadre->activo_id));
                          if(count($hijos)){?>
                         <?php echo $this->renderPartial('dependenciasHijas', array('hijos'=>$hijos), true)?>
                    <?php }?>
                </li>
            <?php }?>
        </ul>
    <?php }?>
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

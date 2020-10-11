<script>
    function levantarModalAreaYProcesos() {
        limpiarModalAreaYProcesos();
        $("#modalAreaYProcesos").modal('show');
    }
    function limpiarModalAreaYProcesos() {

        $("#ActivoArea_area_id").val("");
        $("#ActivoArea_procesos").val("");
        $("#ActivoArea_area_id").select2('val',"");
        $("#ActivoArea_procesos").select2('val',"");
        $(".form-group").removeClass('has-success').removeClass('has-error');
        $("#modalAreaYProcesos .help-block.error").empty();
    }

    function getProcesosPorArea() {
        var area_id = $("#ActivoArea_area_id").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('area/getProcesos')?>",
            data: {'area_id': area_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                var procesos = datos.procesos;
                $("#ActivoArea_procesos").find('option').remove();
                $("#ActivoArea_procesos").select2('val', null);
                if(procesos.length >0){
                    $.each(procesos, function (i, proceso) {
                        $("#ActivoArea_procesos").append('<option value="' + proceso.id + '">' + proceso.nombre + '</option>');
                    });
                }
            }
        });
    }

    function guardarAreaYProcesos(){
        var area_id = $("#ActivoArea_area_id").val();
        if(area_id === ""){
            return Lobibox.notify('error',{msg: 'Seleccione el area'});
        }

        var procesos = $("#ActivoArea_procesos").val();
        if(procesos === null){
            return Lobibox.notify('error',{msg: 'Seleccione al menos un proceso'});
        }

        var activo_id = $("#activo_id").val();

        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/guardarAreaYProcesos')?>",
            data: {
                    'area_id'  : area_id,
                    'procesos' : procesos,
                    'activo_id': activo_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error === 0)
                {
                    limpiarModalAreaYProcesos();
                    $.fn.yiiGridView.update('activo-area-grid');
                    Lobibox.notify('success',{msg:datos.msj});
                }
                else
                {
                    Lobibox.notify('error',{msg:datos.msj});
                }
            }
        });
    }

    function eliminarAreaYProcesos(event,activo_area_id){
        event.preventDefault();
        Lobibox.confirm({
            title:'Confirmar',
            msg: "Está seguro de realizar esta acción ?",
            callback: function (lobibox, type) {
                if (type === 'yes') {
                    $.ajax({
                        type: "POST",
                        url: '<?= CController::createUrl('activo/eliminarAreaYProcesos') ?>',
                        data: {
                            "activo_area_id": activo_area_id
                        },
                        success: function (data) {
                            var datos = jQuery.parseJSON(data);
                            if(datos.error === 0){
                                Lobibox.notify('success', {msg: "El proceso se realizo con exito"});
                                $.fn.yiiGridView.update('activo-area-grid');
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
        'label'=> 'Areas y Procesos ( + )',
        'context'=>'success',
        'size' => 'small',
        'id'=>"botonModal",
        'htmlOptions' => array('onclick' => 'js:levantarModalAreaYProcesos()')
    ));
    ?>
</div>
<?php
    $this->widget('booster.widgets.TbExtendedGridView',array(
        'id'=>'activo-area-grid',
        'fixedHeader' => false,
        'headerOffset' => 10,
        // 40px is the height of the main navigation at bootstrap
        'type' => 'striped hover condensed',
        'dataProvider' => $activo_area->search(),
        'responsiveTable' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'selectableRows' => 1,
       // 'filter' => $model,
        'columns'=>array(
            [
                'name'=>'nombre',
                'header'=>'Area',
                'value' =>'$data->area->nombre',
            ],
            [
                'name'=>'nombre',
                'header'=>'Prcesos',
                'value' =>'$data->getProcesos()',
            ],
            [
                'header' => 'Acciones',
                'type' => 'raw',
                'value' => function($data){
                    return "<a style=\"cursor: pointer;\"  onclick=\"eliminarAreaYProcesos(event, $data->id) \" title=\"Presione para eliminar\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-trash\"></i></a>";
                }
            ]
        ),
    ));

?>

<div class="modal fade" id="modalAreaYProcesos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Agregar Area y Procesos</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php $aa = new ActivoArea(); $aa->activo_id = $model->id; ?>
                <?php echo $this->renderPartial('_formAreaYProcesos', array('model' => $aa)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarAreaYProcesos()" class="btn btn-success" id="botonModal">
                    Guardar
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

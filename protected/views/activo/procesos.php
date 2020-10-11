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

        if(procesos.length === 0){
            return Lobibox.notify('error',{msg: 'Seleccione al menos un proceso'});
        }

        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/guardarAreaYProcesos')?>",
            data: {
                    'area_id': area_id,
                    'procesos': procesos
            },
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
            'id'=>'area-grid',
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
//                [
//                    'name'=>'nombre',
//                    'header'=>'Nombre',
//                    'value' =>'$data->nombre',
//                ],
//                'descripcion',
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
                <?php echo $this->renderPartial('_formAreaYProcesos', array('model' => new ActivoArea())); ?>
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

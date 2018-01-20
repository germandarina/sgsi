
<script>
    function valorarAmenaza(event,amenaza_id,analisis_id,grupo_activo_id,activo_id) {
        event.preventDefault();
        $("#Analisis_valor_form_valoracion").val(0);
        $("#Analisis_valor_form_valoracion").select2('val',0);

        $("#amenaza_id").val(amenaza_id);
        $("#analisis_id").val(analisis_id);
        $("#grupo_activo_id_hidden").val(grupo_activo_id);
        $("#activo_id_hidden").val(activo_id);
        $("#modalValorAmenaza").modal('show');
    }
    
    function guardarValoracionAmenaza() {

        var grupo_activo_id = $("#grupo_activo_id_hidden").val();
        var analisis_id = $("#analisis_id").val();
        var amenaza_id = $("#amenaza_id").val();
        var amenaza_valor = $("#Analisis_valor_form_valoracion").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/guardarValorAmenaza')?>",
            data: {
                'amenaza_valor': amenaza_valor,
                'amenaza_id': amenaza_id,
                'analisis_id': analisis_id,
                'grupo_activo_id':grupo_activo_id
            },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    $("#modalValorAmenaza").modal('hide');
                    Lobibox.notify('success',{msg: datos.msj});
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
                $.fn.yiiGridView.update('valoraciones-grid');
            }
        });
    }
</script>

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
        [
            'header' => 'Accion',
            'type' => 'raw',
            'value' => '"<a onclick=\"valorarAmenaza(event, $data->id, $data->analisis_id, $data->grupo_activo_id,$data->activo_id) \" title=\"Valorar Amenaza\" class=\"linkCredito\"><i class=\"glyphicon glyphicon-pencil\"></i></a>"',
        ],
        array(
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{valoracion}',
            'header' => 'Valorar Controles / Vulnerabilidades',
            'buttons' => array(
                'valoracion' => array(
                    'label' => 'Ver Valoracion',
                    'icon' => 'fa fa-star',
                    'url' => 'Yii::app()->createUrl("/analisis/verValoracion", array("id"=>$data->id,"analisis_id"=>$data->analisis_id,
                                                                                     "grupo_activo_id"=>$data->grupo_activo_id,
                                                                                     "grupo_id"=>$data->grupo_id,"activo_id"=>$data->activo_id
                                                                                      ))',
                ),
            ),
            'htmlOptions' => array('style' => 'width:5%;text-align:center;')
        ),
    ),
)); ?>


<div class="modal fade" id="modalValorAmenaza" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog" id="modalAmenaza">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Nueva Valoracion</h4>
            </div>
            <div class="modal-body" id="cuerpoDetalleCredito">
                <?php echo $this->renderPartial('_formValoracion', array('analisis'=>$model)); ?>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="js:guardarValoracionAmenaza()" class="btn btn-success" id="botonModal">
                    Valorar Amenaza
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>

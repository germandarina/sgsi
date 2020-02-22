<script>
    function mostrarProcesos(event,area_id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('area/getProcesosModal')?>",
            data: {'area_id': area_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                $("#cuerpo").empty().html(datos.html);
                $("#modalProcesos").modal('show');
            }
        });
    }
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
            Areas
        </h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Crear</a>
            </div>
        </div>
    </div>

	<?php
       if(Yii::app()->user->model->isAdmin() || Yii::app()->user->model->isGerencial() || Yii::app()->user->model->isAuditor()) {
            $this->widget('booster.widgets.TbExtendedGridView',array(
                'id'=>'area-grid',
                'fixedHeader' => false,
                'headerOffset' => 10,
                // 40px is the height of the main navigation at bootstrap
                'type' => 'striped hover condensed',
                'dataProvider' => $model->search(),
                'responsiveTable' => true,
                'template' => "{summary}\n{items}\n{pager}",
                'selectableRows' => 1,
                'filter' => $model,
                'columns'=>array(
                    [
                        'name'=>'nombre',
                        'header'=>'Nombre',
                        'type'=>'raw',
                        'value'=>function($data){
                            return "<a title='Ver Procesos' style='cursor: pointer' onclick='mostrarProcesos(event,".$data->id.")'>".$data->nombre."</a>";
                        }
                    ],
                    'descripcion',
                    array(
                        'name'=>'organizacion_id',
                        'header'=>'Organizacion',
                        'value'=>'$data->organizacion->nombre',
                    ),
                    array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'afterDelete' => 'function(link,success,data){ 
                                  var datos = jQuery.parseJSON(data);
                                  if(success){
                                        if(datos.error == 0){
                                            Lobibox.notify(\'success\', {msg: datos.msj }); 
                                        }else{
                                         Lobibox.notify(\'error\', {msg: datos.msj }); 
                                        }
                                  }else{
                                    Lobibox.notify(\'error\', {msg: datos.msj }); 
                                  }
                              }'
                    ),
                ),
            ));
	}?>
</div>

<div class="modal fade" id="modalProcesos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Procesos Relacionados</h4>
            </div>
            <div class="modal-body" id="cuerpo">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>




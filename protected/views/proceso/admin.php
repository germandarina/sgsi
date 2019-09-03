<script>
    function mostrarActivos(event,proceso_id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('proceso/getActivosModal')?>",
            data: {'proceso_id': proceso_id},
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                $("#cuerpo").empty().html(datos.html);
                $("#modalActivos").modal('show');
            }
        });
    }
</script>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Gestion de Procesos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Proceso/create')),
						)
					),
				),
			)
		); ?>
	</div>

	<?php
		if(Yii::app()->user->model->isAdmin() || Yii::app()->user->model->isGerencial() || Yii::app()->user->model->isAuditor()) {
			$this->widget('booster.widgets.TbExtendedGridView',array(
				'id'=>'proceso-grid',
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
                       return "<a title='Ver Activos' style='cursor: pointer' onclick='mostrarActivos(event,".$data->id.")'>".$data->nombre."</a>";
                    }
                ],
					'descripcion',
					array(
						'name'=>'area_id',
						'header'=>'Area',
						'value'=>'$data->area->nombre',
					),
					'creaUserStamp',
					'creaTimeStamp',
					/*
                    'modUserStamp',
                    'modTimeStamp',
                    */
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

<div class="modal fade" id="modalActivos" tabindex="-1" role="dialog" aria-hidden="true" style="padding-right: 15px;">
    <div class="modal-dialog" style="width: 900px !important;">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title" id="cabeceraModal">Activos Relacionados</h4>
            </div>
            <div class="modal-body" id="cuerpo">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            </div>
        </div>
    </div>
</div>




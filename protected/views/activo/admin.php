<script>
    function mostrarProcesos(event,activo_id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('activo/getProcesosModal')?>",
            data: {'activo_id': activo_id},
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
	<div class="box-header">
		<h3 class="box-title">Admin Activos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Activo/create')),
						)
					),
				),
			)
		); ?>	</div>
	<?php
	    $usuario = User::model()->findByPk(Yii::app()->user->model->id);
		if(!is_null($usuario->ultimo_proyecto_id)){ ?>
			<?php $this->widget('booster.widgets.TbExtendedGridView',array(
				'id'=>'activo-grid',
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
						'header'=>'Tipo Activo',
						'name'=>'tipo_activo_id',
						'value'=>'$data->tipoActivo->nombre',
						'filter'=>CHtml::listData(TipoActivo::model()->findAll(),'id','nombre'),
					),
					array(
						'header'=>'Areas',
						'name'=>'areas',
						'value'=>function($data){
							$activo_area = $data->activoAreas;
							$areas = "";
							foreach ($activo_area as $relacion){
								$areas .= $relacion->area->nombre.' / ';
							}
							return trim($areas,' / ');
						},
						'filter'=>false,
					),
					array(
						'header'=>'Personal',
						'name'=>'personal_id',
						'value'=>'$data->getPersonal();',
					),
					'cantidad',
					'ubicacion',
					'creaUserStamp',

					array(
						'class'=>'booster.widgets.TbButtonColumn',
						'template'=>'{update}{delete}',
						'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
					),
				),
			));
	} ?>

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




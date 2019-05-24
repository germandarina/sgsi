<script>
    function mostrarActivos(event,grupo_id) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('grupo/getActivosModal')?>",
            data: {'grupo_id': grupo_id},
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
		<h3 class="box-title">Gestion de Grupos</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Grupo/create')),
						)
					),
				),
			)
		); ?>	</div>
	<?php
	if(Yii::app()->user->model->isAdmin()){
		$this->widget('booster.widgets.TbExtendedGridView',array(
			'id'=>'grupo-grid',
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
                        return "<a style='cursor: pointer' onclick='mostrarActivos(event,".$data->id.")'>".$data->nombre."</a>";
                    }
                ],
				'criterio',
				array(
					'name'=>'tipo_activo_id',
					'header'=>'Tipo Activo',
					'value'=>'$data->tipoActivo->nombre',
					'filter'=>CHtml::listData(TipoActivo::model()->findAll(),'id','nombre'),
				),
				array(
					'header'=>'Proyecto',
					'name'=>'proyecto_id',
					'value'=>'$data->proyecto->nombre',
					'filter'=>CHtml::listData(Proyecto::model()->findAll(),'id','nombre'),
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
					'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'

				),
			),
		));
	}else{
		$usuario = User::model()->findByPk(Yii::app()->user->model->id);
		if(!is_null($usuario->ultimo_proyecto_id)){
			$this->widget('booster.widgets.TbExtendedGridView',array(
				'id'=>'grupo-grid',
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
                            return "<a style='cursor: pointer' onclick='mostrarActivos(event,".$data->id.")'>".$data->nombre."</a>";
                        }
                    ],
					'criterio',
					array(
						'name'=>'tipo_activo_id',
						'header'=>'Tipo Activo',
						'value'=>'$data->tipoActivo->nombre',
						'filter'=>CHtml::listData(TipoActivo::model()->findAll(),'id','nombre'),
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
						'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
					),
				),
			));
		}
	}
	 ?>
</div>


<div class="modal fade" id="modalActivos" tabindex="-1" role="dialog" aria-hidden="true" style="padding-right: 15px;">
    <div class="modal-dialog" style="width: 900px !important;">
        <div class="modal-content">
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





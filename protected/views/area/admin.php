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
	<div class="box-header">
		<h3 class="box-title">Gestion de Areas</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Area/create')),
						)
					),
				),
			)
		); ?>
	</div>

	<?php
	if(Yii::app()->user->model->isAdmin() || Yii::app()->user->model->isGerencial()){
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
                       return "<a style='cursor: pointer' onclick='mostrarProcesos(event,".$data->id.")'>".$data->nombre."</a>";
                    }
                ],
                'descripcion',
                array(
                    'name'=>'organizacion_id',
                    'header'=>'Organizacion',
                    'value'=>'$data->organizacion->nombre',
                ),
                'creaUserStamp',
                'creaTimeStamp',
            array(
            'class'=>'booster.widgets.TbButtonColumn',
                'template'=>'{update}{delete}',
                'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
            ),
            ),
            ));
	}else{
        $usuario = User::model()->findByPk(Yii::app()->user->model->id);
        if(!is_null($usuario->ultimo_proyecto_id)) {
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
                            return "<a style='cursor: pointer' onclick='mostrarProcesos(event,".$data->id.")'>".$data->nombre."</a>";
                        }
                    ],
                    'descripcion',
                    array(
                        'name'=>'organizacion_id',
                        'header'=>'Organizacion',
                        'value'=>'$data->organizacion->nombre',
                    ),
                    'creaUserStamp',
                    'creaTimeStamp',
                    array(
                        'class'=>'booster.widgets.TbButtonColumn',
                        'template'=>'{update}{delete}',
                        'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
                    ),
                ),
            ));
        }
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




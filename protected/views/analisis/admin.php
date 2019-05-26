<script>
	$(function () {
		$("#analisis-grid_c8").empty().html('Crear Plan Tratamiento');
		$("#analisis-grid_c9").empty().html('Ver Planes Tratamiento');
	});
</script>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Admin Analisis</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Analisis/create')),
						)
					),
				),
			)
		); ?>	</div>
	<?php
	if(Yii::app()->user->model->isAdmin()){
		$this->widget('booster.widgets.TbExtendedGridView',array(
			'id'=>'analisis-grid',
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
				'nombre',
				'descripcion',
				array(
					'name'=>'fecha',
					'header'=>'Fecha',
					'value'=>'Utilities::ViewDateFormat($data->fecha)',
				),
				array(
					'name'=>'personal_id',
					'header'=>'Personal',
					'value'=>'$data->getPersonal()',
				),
				array(
					'header'=>'Proyecto',
					'name'=>'proyecto_id',
					'value'=>'$data->proyecto->nombre',
					'filter'=>CHtml::listData(Proyecto::model()->findAll(),'id','nombre'),
				),
				'creaUserStamp',
				'creaTimeStamp',
				array(
					'class'=>'booster.widgets.TbButtonColumn',
					'template'=>'{update}{delete}',
					'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
				),
				array('class' => 'booster.widgets.TbButtonColumn',
					'template' => '{crear}',
					'buttons' => array(
						'crear' => array(
							'label' => 'Crear Plan de Tratamiento',
							//'click' => 'function () {if(!confirm("Esta seguro de anular la factura?")) {return false;}}',
							'url' => 'Yii::app()->createUrl("/plan/create", array("analisis_id"=>$data->id))',
//							'visible' => function ($row, Factura $data) {
//								return $data->puedeAnularFacturaCompra();
//							},
							'icon' => 'fa fa-plus-square',
						),
					),
					),
				array('class' => 'booster.widgets.TbButtonColumn',
					'template' => '{ver}',
					'buttons' => array(
						'ver' => array(
							'label' => 'Ver/Actualizar Plan de Tratamiento',
							'url' => 'Yii::app()->createUrl("/plan/verPlanes", array("analisis_id"=>$data->id))',
							'visible' => '$data->tienePlanDeTratamiento()',
							'icon' => 'fa fa-eye',
						),
					),
					),
			),
		));
	}else{
		$usuario = User::model()->findByPk(Yii::app()->user->model->id);
		if(!is_null($usuario->ultimo_proyecto_id)){
			$this->widget('booster.widgets.TbExtendedGridView',array(
				'id'=>'analisis-grid',
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
					'nombre',
					'descripcion',
					array(
						'name'=>'fecha',
						'header'=>'Fecha',
						'value'=>'Utilities::ViewDateFormat($data->fecha)',
					),
					array(
						'name'=>'personal_id',
						'header'=>'Personal',
						'value'=>'$data->getPersonal()',
					),
					'creaUserStamp',
					'creaTimeStamp',
					array(
						'class'=>'booster.widgets.TbButtonColumn',
						'template'=>'{update}{delete}',
						'afterDelete' => 'function(link,success,data) { if (success && data) Lobibox.notify(\'info\', {msg: data }); }'
					),
					array('class' => 'booster.widgets.TbButtonColumn',
						'template' => '{crear}',
						'buttons' => array(
							'crear' => array(
								'header'=>'Crear',
								'title'=>'Crear',
								'label' => 'Crear Plan de Tratamiento',
								'url' => 'Yii::app()->createUrl("/plan/create", array("analisis_id"=>$data->id))',
								'icon' => 'fa fa-plus-square',
							),
						),
						),
					array('class' => 'booster.widgets.TbButtonColumn',
						'template' => '{ver}',
						'buttons' => array(
							'ver' => array(
								'label' => 'Ver/Actualizar Planes de Tratamiento',
								'url' => 'Yii::app()->createUrl("/plan/verPlanes", array("analisis_id"=>$data->id))',
								'visible' => '$data->tienePlanDeTratamiento()', //  SI NO TIENE PLAN NO MOSTRAR EL ICONO;
								'icon' => 'fa fa-eye',
							),
						),
						),
				),
			));
		}
	}
	 ?>

</div>




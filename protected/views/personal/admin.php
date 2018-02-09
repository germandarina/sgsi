

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Personal</h3>
		<?php $this->widget(
			'booster.widgets.TbButtonGroup',
			array(
				'size' => 'medium',
				'context' => 'primary',
				'buttons' => array(
					array(
						'label' => 'Acciones',
						'items' => array(
							array('label' => 'Crear', 'url' => Yii::app()->createUrl('Personal/create')),
						)
					),
				),
			)
		); ?>
	</div>

	<?php
	if(Yii::app()->user->model->isAdmin() || Yii::app()->user->model->isGerencial()){
		$this->widget('booster.widgets.TbExtendedGridView',array(
			'id'=>'personal-grid',
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
				'apellido',
				'nombre',
				'dni',
				'telefono',
				array(
					'name'=>'area_id',
					'header'=>'Area',
					'value'=>'$data->area->nombre',
				),
				array(
					'name'=>'proceso_id',
					'header'=>'Proceso',
					'value'=>'$data->proceso->nombre',
				),
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
				'id'=>'personal-grid',
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
					'apellido',
					'nombre',
					'dni',
					'telefono',
					array(
						'name'=>'area_id',
						'header'=>'Area',
						'value'=>'$data->area->nombre',
					),
					array(
						'name'=>'proceso_id',
						'header'=>'Proceso',
						'value'=>'$data->proceso->nombre',
					),
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






<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Activos</h3>
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
			'nombre',
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
			/*
			'creaTimeStamp',
			'modUserStamp',
			'modTimeStamp',
			*/
		array(
		'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{update}{delete}'
		),
		),
		)); ?>

	<?php }?>
</div>




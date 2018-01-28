

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Admin Analisis</h3>
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
					'template'=>'{update}{delete}'
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
						'template'=>'{update}{delete}'
					),
				),
			));
		}
	}
	 ?>

</div>




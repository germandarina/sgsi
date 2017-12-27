<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Usuarios' => array('admin'), 'Datos del Usuario'),
	)
); ?>

<?php $this->widget(
	'booster.widgets.TbPanel',
	array(
		'title' => 'Datos del Usuario',
		'headerIcon' => 'th-list',
		'headerButtons' => array(
			array(
				'buttonType' => 'link',
				'class' => 'booster.widgets.TbButton',
				'label' => 'Actualizar',
				'icon'=>'fa fa-edit',
				'context' => 'primary',
				'url' => $this->createUrl('update',array('id'=>$model->id)),
				'size' => 'small'
			),
		),
		'content' => $this->renderPartial(
			'datosDelUsuario',
			array('model' => $model), TRUE)
	)

);
?>

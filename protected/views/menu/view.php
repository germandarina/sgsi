<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('ABM Menu' => array('admin'), 'Datos del Menu'),
	)
); ?>

<?php $this->widget(
	'booster.widgets.TbPanel',
	array(
		'title' => 'Datos del Menu',
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
			'detalleDeMenu',
			array('model' => $model), TRUE)
	)

);
?>

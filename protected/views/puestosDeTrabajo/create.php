<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Puestos De Trabajos' => array('admin'), 'Crear'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Crear Puesto De Trabajo</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
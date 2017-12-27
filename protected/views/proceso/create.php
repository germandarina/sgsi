<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Procesos' => array('admin'), 'Crear'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Crear Proceso</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
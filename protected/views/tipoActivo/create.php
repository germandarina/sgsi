<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Tipo Activos' => array('admin'), 'Crear'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Crear TipoActivo</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
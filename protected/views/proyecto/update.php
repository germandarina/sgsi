
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Proyectos' => array('admin'), 'Actualizar'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Proyecto</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
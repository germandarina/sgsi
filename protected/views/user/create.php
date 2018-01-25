<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Usuarios' => array('admin'), 'Crear'),
	)
);
 ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Crear Usuario</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model, "perfiles" => $perfiles,'perfilAuditor'=>$perfilAuditor)); ?>
</div>
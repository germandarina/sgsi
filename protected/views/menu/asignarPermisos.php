<?php

	$this->widget(
	    'booster.widgets.TbBreadcrumbs',
	    array(
	        'links' => array('Menu' => array('admin'), 'Asignar Permisos'),
	    )
	);

?>

<div class="box">

	<div class="box-header with-border">
		<h3>Asignar Permisos</h3>
	</div>

	<?php echo $this->renderPartial('_asignar', array('model' => $model, 'perfiles' => $perfiles,'controllerList'=>$controllerList)); ?>

</div>

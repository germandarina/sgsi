<?php

	$this->widget(
	    'booster.widgets.TbBreadcrumbs',
	    array(
	        'links' => array('Menu' => array('admin'), 'Editar Menu'),
	    )
	);

?>

<div class="box">

	<div class="box-header with-border">
		<h3>Editar Menu</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model' => $model, 'perfiles' => $perfiles)); ?>

</div>

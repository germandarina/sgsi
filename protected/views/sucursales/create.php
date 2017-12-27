<?php

	$this->widget(
	    'booster.widgets.TbBreadcrumbs',
	    array(
	        'links' => array('Sucursales' => array('admin')),
	    )
	);

?>

<fieldset>
 
	<legend>Crear Sucursal</legend>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>

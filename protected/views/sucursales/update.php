<?php

	$this->widget(
	    'booster.widgets.TbBreadcrumbs',
	    array(
	        'links' => array('Sucursales' => array('admin'), 'Editar Menu'),
	    )
	);

?>

<fieldset>
 
	<legend>Editar Sucursales</legend>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</fieldset>

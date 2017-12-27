<?php

	$this->widget(
	    'booster.widgets.TbBreadcrumbs',
	    array(
	        'links' => array('Sucursales' => array('admin'), 'Vista Sucursal'),
	    )
	);

?>

<fieldset>
 
	<legend>Sucursal Nro: <?php echo $model->id;?></legend>

<?php
$this->widget(
'booster.widgets.TbDetailView',
array(
'type'=>'bordered condensed',
'data' =>$model,
'attributes' => array(
array('name' => 'id', 'label' => 'Nro Sucursal'),
array('name' => 'nombre', 'label' => 'Nombre'),
array('name' => 'direccion', 'label' => 'Direccion'),
array('name' => 'email', 'label' => 'Email'),
array('name' => 'comisionGeneral', 'label' => 'Comision General'),
array('name' => 'tasaDescuentoGeneral', 'label' => 'Tasa Desc. General'),
array('name' => 'tasaInversores', 'label' => 'Tasa Inversores'),
array('name' => 'tasaPesificacion', 'label' => 'Tasa Pesificacion'),
array('name' => 'diasClearing', 'label' => 'Dias Clearing'),
array('name' => 'userStamp', 'label' => 'User Stamp'),
array('name' => 'timeStamp', 'label' => 'Time Stamp'),
),
)
);
?>

</fieldset>
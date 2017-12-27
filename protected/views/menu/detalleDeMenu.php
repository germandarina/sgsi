<?php
$this->widget('booster.widgets.TbDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
	     array('label' => 'Padre', 'value' => function($data){
			 if($data->padreId == 0){
				 return '---';
			 }else{
				 $padre = Menu::model()->findByPk($data->padreId);
				 return $padre->label;
			 }
		 }),
		array('label' => 'Label', 'value' => $model->label),
		'titulo',
		'url',
		'creaTimeStamp',
		'creaUserStamp',
	),
));
?>
<br><br>
<?php $this->widget('booster.widgets.TbButton', array(
	//'buttonType'=>'submit',
	'label' => 'Volver',
	'size' => 'small',
	'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
)); ?>

<?php
/*$this->widget(
'booster.widgets.TbDetailView',
array(
'type'=>'bordered condensed striped',
'data' =>$model,
'attributes' => array(
array('name' => 'id', 'label' => 'Nro Item'),
array('name' => 'padreId', 'label' => 'PadreId'),
array('name' => 'label', 'label' => 'Label'),
array('name' => 'titulo', 'label' => 'Titulo'),
array('name' => 'url', 'label' => 'Url'),
array('name' => 'userStamp', 'label' => 'User Stamp'),
array('name' => 'timeStamp', 'label' => 'Time Stamp'),
array('name' => 'sucursalId', 'label' => 'Sucursal'),
array('name' => 'visible', 'label' => 'Visible'),
array('name' => 'orden', 'label' => 'Orden'),
),
)
);*/
?>

<?php
$this->breadcrumbs=array(
	'Puestos De Trabajos'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List PuestosDeTrabajo','url'=>array('index')),
array('label'=>'Create PuestosDeTrabajo','url'=>array('create')),
array('label'=>'Update PuestosDeTrabajo','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete PuestosDeTrabajo','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage PuestosDeTrabajo','url'=>array('admin')),
);
?>

<h1>View PuestosDeTrabajo #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'area_id',
		'nombre',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>

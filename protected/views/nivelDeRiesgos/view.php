<?php
$this->breadcrumbs=array(
	'Nivel De Riesgoses'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List NivelDeRiesgos','url'=>array('index')),
array('label'=>'Create NivelDeRiesgos','url'=>array('create')),
array('label'=>'Update NivelDeRiesgos','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete NivelDeRiesgos','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage NivelDeRiesgos','url'=>array('admin')),
);
?>

<h1>View NivelDeRiesgos #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'valor_minimo',
		'valor_maximo',
		'concepto',
		'creaUserStamp',
		'creaTimeStamp',
		'modUserStamp',
		'modTimeStamp',
),
)); ?>

<?php
$this->breadcrumbs=array(
	'Vulnerabilidads',
);

$this->menu=array(
array('label'=>'Create Vulnerabilidad','url'=>array('create')),
array('label'=>'Manage Vulnerabilidad','url'=>array('admin')),
);
?>

<h1>Vulnerabilidads</h1>

<?php $this->widget('booster.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>

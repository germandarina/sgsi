

<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Valoraciones para la Amenaza: <?= $vulnerabilidad->amenaza->nombre; ?></h3>
	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'vulnerabilidad-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	'type' => 'striped hover condensed',
	'dataProvider' => $vulnerabilidad->search(),
	'responsiveTable' => true,
	'template' => "{summary}\n{items}\n{pager}",
	'selectableRows' => 1,
	'filter' => $vulnerabilidad,
	'columns'=>array(
		'nombre',
		'descripcion',
	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}'
	),
	),
	)); ?>
</div>




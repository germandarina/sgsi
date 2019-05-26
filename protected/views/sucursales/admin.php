<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sucursales-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Administracion de Sucursales</h3>
<?php
$this->widget(
    'booster.widgets.TbButtonGroup',
    array(
        'size' => 'medium',
        'context' => 'primary',
        'buttons' => array(
            array(
                'label' => 'Acciones',
                'items' => array(
                    array('label' => 'Nueva Sucursal', 'url' => Yii::app()->createUrl('sucursales/create')),
                )
            ),
        ),
    )
);
?>

<?php $this->widget(
    'booster.widgets.TbExtendedGridView',
    array(
        'fixedHeader' => false,
        'headerOffset' => 40,
        // 40px is the height of the main navigation at bootstrap
        'type' => 'striped hover',
        'dataProvider' => $model->search(),
        'responsiveTable' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'selectableRows' => 1,
        'filter'=>$model,
		'columns'=>array(
			'id',
			'nombre',
			'direccion',
			'email',
			'comisionGeneral',
			'tasaDescuentoGeneral',
			'tasaPromedioColocacion',
			array(
				'class'=>'booster.widgets.TbButtonColumn'
			)
	),
)); ?>
</div>
</div>
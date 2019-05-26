<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('menu-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Admin Menu</h3>
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
                            array('label' => 'Nuevo Item', 'url' => $this->createUrl('create')),
                        )
                    ),
                ),
            )
        );
        ?>
    </div>


    <?php $this->widget(
        'booster.widgets.TbExtendedGridView',
        array(
            'fixedHeader' => false,
            'headerOffset' => 10,
            // 40px is the height of the main navigation at bootstrap
            'type' => 'striped hover condensed bordered',
            'dataProvider' => $model->search(),
            'responsiveTable' => true,
            'template' => "{summary}\n{items}\n{pager}",
            'selectableRows' => 1,
            'filter' => $model,
            'columns' => array(
                'id',
                array('name' => 'padreId',
                    'header' => 'Padre',
                    'value' => '($data->padreId!=0)?strtoupper(Menu::model()->getPadre($data->padreId)):"ES PADRE"',
                    'filter' => CHtml::listData(Menu::model()->findPadre(), 'id', 'label'),
                ),
                array(
                    'name' => 'label',
                    'header' => 'Label',
                    'value' => 'strtoupper($data->label)'
                ),
                array(
                    'name' => 'titulo',
                    'header' => 'Titulo',
                    'value' => 'strtoupper($data->titulo)'
                ),
                'url',
                'orden',
                array(
                    'class' => 'booster.widgets.TbButtonColumn'
                )
            ),
        )); ?>
</div>



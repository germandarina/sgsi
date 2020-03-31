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
    <div class="box-header with-border">
        <h3 class="box-title">
          Administración de menú
        </h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Crear</a>
            </div>
        </div>
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
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template'=>'{update}{delete}',
                    'afterDelete' => 'function(link,success,data){ 
                                  var datos = jQuery.parseJSON(data);
                                  if(success){
                                        if(datos.error == 0){
                                            Lobibox.notify(\'success\', {msg: datos.msj }); 
                                        }else{
                                         Lobibox.notify(\'error\', {msg: datos.msj }); 
                                        }
                                  }else{
                                    Lobibox.notify(\'error\', {msg: datos.msj }); 
                                  }
                              }'
                )
            ),
        )); ?>
</div>



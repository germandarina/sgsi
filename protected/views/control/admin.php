

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
          Administración de Controles
        </h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Crear</a>
            </div>
        </div>
    </div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'control-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	'type' => 'striped hover condensed',
	'dataProvider' => $model->search(),
	'responsiveTable' => true,
	'template' => "{summary}\n{items}\n{pager}",
	'selectableRows' => 1,
	'filter' => $model,
	'columns'=>array(
		'numeracion',
		'nombre',
		'descripcion',
        array(
            'name'=>'tipo_activo_id',
            'header'=>'Tipo Activo',
            'value'=>'$data->tipoActivo->nombre',
        ),
        array(
            'name'=>'amenaza_id',
            'header'=>'Amenaza',
            'value'=>'$data->amenaza->nombre',
        ),
		array(
			'name'=>'vulnerabilidad_id',
			'header'=>'Vulnerabilidad',
			'value'=>'$data->vulnerabilidad->nombre',
		),
//		'creaUserStamp',
//		'creaTimeStamp',
	array(
	'class'=>'booster.widgets.TbButtonColumn',
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
	),
	),
	)); ?>
</div>




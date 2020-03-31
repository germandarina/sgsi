<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
           Administración de Proyectos
        </h3>
        <div class="box-tools">
            <div class="btn-group pull-right">
                <a href="<?= $this->createUrl('create') ?>" class="btn btn-sm btn-success"><i
                            class="fa fa-plus-circle"></i> Crear</a>
            </div>
        </div>
    </div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'proyecto-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	//'type' => 'striped hover condensed',
	'type' => 'striped hover condensed',
	'dataProvider' => $model->search(),
	'responsiveTable' => true,
	'template' => "{summary}\n{items}\n{pager}",
	'selectableRows' => 1,
	'filter' => $model,
	'columns'=>array(
		'nombre',
		'descripcion',
		array(
			'name'=>'fecha',
			'header'=>'Fecha',
			'value'=>'Utilities::ViewDateFormat($data->fecha)',
			'filter'=>false,
		),
        array(
            'name'=>'organizacion_id',
            'header'=>'Organizacion',
            'value'=>'$data->organizacion != null ? $data->organizacion->nombre : "" ',
            'filter'=>false,
        ),
		array(
			'name'=>'usuario_id',
			'header'=>'Usuario',
			'value'=>'$data->getUsuarios()',
			'filter'=>false,
		),

		array(
			'name'=>'id',
			'header'=>'Areas',
			'value'=>'$data->getAreas()',
			'filter'=>false,
		),
		//'creaUserStamp',
	//	'creaTimeStamp',

	array(
	'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{update}{delete}',
        'afterDelete' => 'function(link,success,data){ 
                                  var datos = jQuery.parseJSON(data);
                                  if(success){
                                        if(datos.error == 0){
                                            Lobibox.notify(\'success\', {msg: datos.msj });
                                            setTimeout(function(){
                                            window.location.reload();
                                        }, 500); 
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




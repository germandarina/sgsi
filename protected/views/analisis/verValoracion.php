
<script>
	function valorarControl(control_id) {
		$("#Analisis_valor_form_valoracion").val(0);
		$("#Analisis_valor_form_valoracion").select2('val',0);
		$("#control_id").val(control_id);
		$("#modalValoraciones").modal('show');
	}
	
	function guardarValoracion() {
       var valor_control = $("#Analisis_valor_form_valoracion").val();
       var control_id = $("#control_id").val();
       var analisis_id = $("#analisis_id").val();
       var grupo_activo_id = $("#grupo_activo_id_hidden").val();
	   var analisis_amenaza_id = $("#analisis_amenaza_id").val();
       $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/guardarValorControl')?>",
            data: { 'valor_control': valor_control,
                    'control_id': control_id,
                    'analisis_id': analisis_id,
                    'grupo_activo_id':grupo_activo_id,
					'analisis_amenaza_id':analisis_amenaza_id
                },
            dataType: 'Text',
            success: function (data) {
                var datos = jQuery.parseJSON(data);
                if(datos.error == 0){
                    $("#modalValoraciones").modal('hide');
                    Lobibox.notify('success',{msg: datos.msj});
                }else{
                    Lobibox.notify('error',{msg: datos.msj});
                }
                $.fn.yiiGridView.update('vulnerabilidad-grid');
            }
        });
    }
</script>
<div class="box">
	<div class="box-header">
        <?php
        $this->widget(
            'booster.widgets.TbPanel',
            array(
                'title' => 'Datos del Analisis',
                'headerIcon' => 'th-list',
                'context' => 'primary',
                'content' => $this->renderPartial(
                    '_cabecera',
                    array('analisis' => $analisis,'grupo'=>$grupo,'activo'=>$activo,'amenaza'=>$amenaza), TRUE)
            )
        );
        ?>
        <?php $this->widget('booster.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => 'Volver',
            'size' => 'medium',
            'buttonType' => 'link',
            'context'=>'success',
            'url' => $this->createUrl("analisis/".$analisis->id),
        )); ?>
	</div>

       <h4 style="margin-left: 3%;">Listado de Vulnerabilidades</h4>

    <?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'vulnerabilidad-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	//'type' => 'striped condensed',
	'dataProvider' => $vulnerabilidad->search($amenaza->id),
	'responsiveTable' => true,
	'htmlOptions'=>array('class'=>'table-responsive'),
	'template' => "{items}\n{pager}",
	//'selectableRows' => 1,
	'filter' => $vulnerabilidad,
	'columns'=>array_merge(array(
		array(
			'class' => 'booster.widgets.TbRelationalColumn',
			'name' => 'id',
			'type'=>'raw',
			'url' => $this->createUrl('analisis/gridControles',array('analisis_id'=>$analisis->id,'grupo_activo_id'=>$grupo_activo->id,'analisis_amenaza_id'=>$analisis_amenaza->id)),
			'value' => '"<span class = \"fa fa-plus-square\"></span>"',
			'filter'=>false,
		)
	), array(
	    array(
	        'name'=>'nombre',
            'header'=>'Nombre Vulnerabilidad',
            'value'=>'$data->nombre',
        ),
        array(
            'name'=>'descripcion',
            'header'=>'Descripcion Vulnerabilidad',
            'value'=>'$data->descripcion',
        ),
        array( 'name'=>'fecha_valor_vulnerabilidad',
            'header'=>'Fecha Valoracion',
            'value'=>function($data)use($analisis,$grupo_activo,$analisis_amenaza){
                return $data->getFechaValorVulnerabilidad($analisis->id,$grupo_activo->id,$analisis_amenaza->id);
            },
            'filter'=>false,
        ),
        array( 'name'=>'valor_vulnerabilidad',
            'header'=>'Valor Vulnerabilidad',
            'value'=>function($data)use($analisis,$grupo_activo,$analisis_amenaza){
                return $data->getValorVulnerabilidad($analisis->id,$grupo_activo->id,$analisis_amenaza->id);
            },
            'filter'=>false,
        ),
	)),
	)); ?>
</div>


<div class="modal fade" id="modalValoraciones" tabindex="-1" role="dialog" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="cabeceraModal">Nueva Valoracion</h4>
			</div>
			<div class="modal-body" id="cuerpoDetalleCredito">
				<?php echo $this->renderPartial('_formValoracion', array('analisis'=>$analisis,'grupo_activo'=>$grupo_activo,'analisis_amenaza'=>$analisis_amenaza)); ?>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="js:guardarValoracion()" class="btn btn-success" id="botonModal">
					Valorar Control
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
			</div>
		</div>
	</div>
</div>



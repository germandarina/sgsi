<link href="<?= Yii::app()->request->baseUrl ?>/js/jquery-bar-rating-master/dist/themes/bars-square.css" rel="stylesheet" type="text/css"/>
<script src="<?= Yii::app()->request->baseUrl?>/js/jquery-bar-rating-master/dist/jquery.barrating.min.js" type="text/javascript"></script>
<script>
	$(function () {

		$('#rating').barrating('show', {
			theme: 'bars-square',
			showValues: true,
			showSelectedRating: false
		});
	});
	function valorarControl(control_id) {
		$(".br-widget > a").removeClass('br-selected');
		$("#rating").val(0);
		$("#control_id").val(control_id);
		$("#modalValoraciones").modal('show');
	}
	
	function guardarValoracion() {
       var valor_control = $("#rating").val();
       var control_id = $("#control_id").val();
       var analisis_id = $("#analisis_id").val();
       $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('analisis/guardarValorControl')?>",
            data: { 'valor_control': valor_control,
                    'control_id': control_id,
                    'analisis_id': analisis_id
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
<style>
	.modal-dialog {
		width: 300px !important;
		margin: 30px auto !important;
	}

</style>
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
                    array('analisis' => $analisis,'vulnerabilidad'=>$vulnerabilidad,'grupo'=>$grupo), TRUE)
            )
        );
        ?>
        <?php $this->widget('booster.widgets.TbButton', array(
            //'buttonType'=>'submit',
            'label' => 'Volver',
            'size' => 'medium',
            'buttonType' => 'link',
            'context'=>'success',
            'url' => $this->createUrl("analisis/update",array('id'=>$analisis->id)),
        )); ?>
	</div>

	<?php $this->widget('booster.widgets.TbExtendedGridView',array(
	'id'=>'vulnerabilidad-grid',
	'fixedHeader' => false,
	'headerOffset' => 10,
	// 40px is the height of the main navigation at bootstrap
	//'type' => 'striped condensed',
	'dataProvider' => $vulnerabilidad->search(),
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
			'url' => $this->createUrl('analisis/gridControles'),
			'value' => '"<span class = \"fa fa-plus-square\"></span>"',
			'filter'=>false,
		)
	), array(
		'nombre',
		'descripcion',
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
				<?php echo $this->renderPartial('_formValoracion', array('analisis'=>$analisis)); ?>
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



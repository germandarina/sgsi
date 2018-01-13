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
</script>
<style>
	.modal-dialog {
		width: 300px !important;
		margin: 30px auto !important;
	}

</style>
<div class="box">
	<div class="box-header">
		<h3 clas="box-title">Valoraciones para la Amenaza: <?= $vulnerabilidad->amenaza->nombre; ?></h3>
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



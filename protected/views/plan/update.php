<script>
	function levantarModalPlanDetalle(event,plan_detalle_id) {
		event.preventDefault();
		$.ajax({
			type: 'POST',
			url: "<?php echo CController::createUrl('plan/getPlanDetalle')?>",
			data: {
				'plan_detalle_id': plan_detalle_id
			},
			dataType: 'Text',
			success: function (data) {
				var datos = jQuery.parseJSON(data);
				var plan_detalle = datos.plan_detalle;
				$("#plan_detalle_id").val(plan_detalle.id);
				$("#PlanDetalle_fecha_posible_inicio").val(plan_detalle.fecha_posible_inicio);
				$("#PlanDetalle_fecha_posible_fin").val(plan_detalle.fecha_posible_fin);
				$("#PlanDetalle_fecha_real_inicio").val(plan_detalle.fecha_real_inicio);
				$("#PlanDetalle_fecha_real_fin").val(plan_detalle.fecha_real_fin);
				$("#modalPlanDetalle").modal('show');
			}
		});
	}

	function guardarValores() {
		var plan_detalle_id = $("#plan_detalle_id").val();
		var fecha_posible_inicio = $("#PlanDetalle_fecha_posible_inicio").val();
		var fecha_posible_fin = $("#PlanDetalle_fecha_posible_fin").val();
		var fecha_real_inicio = $("#PlanDetalle_fecha_real_inicio").val();
		var fecha_real_fin = $("#PlanDetalle_fecha_real_fin").val();

		if(fecha_posible_fin == "" || fecha_posible_inicio == ""){
			return Lobibox.notify('error',{msg: 'Debe ingresar una fecha posible de inicio o fin'});
		}
		$.ajax({
			type: 'POST',
			url: "<?php echo CController::createUrl('plan/guardarValoresDetalle')?>",
			data: {
				'plan_detalle_id': plan_detalle_id,
				'fecha_posible_inicio':fecha_posible_inicio,
				'fecha_posible_fin':fecha_posible_fin,
				'fecha_real_inicio':fecha_real_inicio,
				'fecha_real_fin':fecha_real_fin
			},
			dataType: 'Text',
			success: function (data) {
				var datos = jQuery.parseJSON(data);
				if(datos.error == 0){
					Lobibox.notify('success',{msg:datos.msj});
					$.fn.yiiGridView.update('plan-detalle-grid');
					$("#modalPlanDetalle").modal('hide');
				}else{
					Lobibox.notify('error',{msg: datos.msj});
				}
			}
		});
	}
</script>
<?php
//$this->widget(
//	'booster.widgets.TbBreadcrumbs',
//	array(
//		'links' => array('Plans' => array('admin'), 'Actualizar'),
//	)
//);
// ?>
<div class="box">

	<div class="box-header with-border">
		<h3>Editar Plan</h3>
	</div>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>




<div class="modal fade" id="modalPlanDetalle" tabindex="-1" role="dialog" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="cabeceraModal">Cargar Valores</h4>
			</div>
			<div class="modal-body" >
				<?php echo $this->renderPartial('/planDetalle/_form', array('model'=>$model),true); ?>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="js:guardarValores()" class="btn btn-success" id="botonModal">
					Guardar Datos
				</button>
				<button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
			</div>
		</div>
	</div>
</div>
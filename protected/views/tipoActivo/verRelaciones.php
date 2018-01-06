<script>
	function ocultarMostrarHijos(event,nombreModelo,id) {
		event.preventDefault();
		var visible = $("#"+nombreModelo+"_"+id+"").attr('data-visible');
		if(visible == 1){
			$("#"+nombreModelo+"_"+id+"").attr('data-visible','0');
			$("#"+nombreModelo+"_"+id+" > span > ul" ).children().css('display','none');
		}else{
			$("#"+nombreModelo+"_"+id+"").attr('data-visible','1');
			$("#"+nombreModelo+"_"+id+" > span > ul" ).children().css('display','block');
		}
	}
//	//*[@id="vulnerabilidad_1"]
//	#vulnerabilidad_1
//	#amenaza_1 > span > ul
</script>
<style>
	ul {
		list-style-type: none;
	}
</style>
<?php
$this->widget(
	'booster.widgets.TbBreadcrumbs',
	array(
		'links' => array('Tipo Activos' => array('admin'), 'Crear'),
	)
);
 ?>
<div class="box box-primary">

	<div class="box-header with-border">
		<h3>Relaciones del Tipo Activo:  <span><icon class="fa fa-laptop"></icon></span> <?= $model->nombre ?></h3>
	</div>
	<div class="box-body">
			<?php foreach ($amenazas as $amenaza){?>
				<ul>
					<li data-visible="1" id="amenaza_<?= $amenaza->id?>"><span><h4><a href="#" onclick="ocultarMostrarHijos(event,'amenaza',<?= $amenaza->id?>)"><icon class="fa fa-cloud"></a>&nbsp;&nbsp;&nbsp;<?= $amenaza->nombre?></h4>
						<ul>
							<?php $vulnerabilidades = $amenaza->vulnerabilidades;
							foreach ($vulnerabilidades as $vulnerabilidad){ ?>
								<li data-visible="1" id="vulnerabilidad_<?= $vulnerabilidad->id?>"><span><h4><a href="#" onclick="ocultarMostrarHijos(event,'vulnerabilidad',<?= $vulnerabilidad->id?>)" ><icon class="fa fa-bolt"></a>&nbsp;&nbsp;&nbsp;<?= $vulnerabilidad->nombre?></h4>
									<ul>
										<?php $controles = $vulnerabilidad->controles;
										foreach ($controles as $control){
											?>
											<li><h4><span><icon class="fa fa-cogs">&nbsp;&nbsp;&nbsp;<?= $control->numeracion?>&nbsp;-&nbsp;<?= $control->nombre?></h4></li>
										<?php }?>
									</ul>
								</li>
							<?php }?>
						</ul>
					</li>
				</ul>
			<?php }?>
	</div>
</div>
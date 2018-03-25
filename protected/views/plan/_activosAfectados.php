<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Analisis</th>
				<th>Activo</th>
				<th>Tipo</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($resultados as $resultado){?>
				<tr>
					<td><?= $resultado['nombre_analisis']?></td>
					<td><?= $resultado['nombre_activo']?></td>
					<td><?= $resultado['nombre_tipo_activo']?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
</div>
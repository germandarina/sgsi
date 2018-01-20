<div class="grid-view">
	<table class="items table table-striped table-hover table-condensed">
		<thead>
			<tr style="background-color: #8cd688;">
				<th>Analisis</th>
				<th>Activo</th>
				<th>Amenaza</th>
				<th>Grupo </th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= $analisis->nombre?></td>
				<td><?= $activo->nombre ?></td>
				<td><?= $vulnerabilidad->amenaza->nombre ?></td>
				<td><?= !is_null($grupo) ? $grupo->nombre : "Sin Grupo Asignado" ?></td>
			</tr>
		</tbody>
	</table>
</div>

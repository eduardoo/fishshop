Showing Page <?php echo $paginator->counter(); ?>
<table class="tablapeces">
    <tr>
        <th><?php echo $paginator->sort('Nombre', 'nombre');?></th>
		 <th><?php echo $paginator->sort('Especie', 'nombrecientifico');?></th>
		 <th><?php echo $paginator->sort('Familia', 'familia');?></th>
		 <th><?php echo $paginator->sort('Descripcion', 'descripcion');?></th>
		<th><?php echo $paginator->sort('Imagen', 'imagen');?></th>
		<th><?php echo $paginator->sort('Stock', 'stock');?></th>
        <th><?php echo $paginator->sort('Precio', 'precio');?></th>
    </tr>
<?php foreach($peces as $discos): ?>
    <tr>
        <td><?php echo $discos['Fish']['nombre']; ?></td>
        <td><?php echo $discos['Fish']['nombrecientifico']; ?></td>
		<td><?php echo $discos['Fish']['familia']; ?></td>
		<td><?php echo $discos['Fish']['descripcion']; ?></td>
		<td><img src=<? echo '"/cake/app/webroot/img/pecesdisco/'.$discos['Fish']['imagen'].'"'; ?> ></td>
		<td><?php echo $discos['Fish']['stock']; ?></td>
		<td><?php echo $discos['Fish']['precio']; ?></td>
    </tr>
<?php endforeach; ?>
</table>
<?php echo $paginator->prev(); ?>
<?php echo $paginator->numbers(); ?>
<?php echo $paginator->next(); ?>
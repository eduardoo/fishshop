<?echo $form->create('User', array('action' => 'registrar'));?>
<table align="center" width="225" cellspacing="2" cellpadding="2" border="0">
<tr>
<td align="right">Nombre:</td>
<td><? echo $form->input('nombre',array('label'=>false)); ?> </td>
</tr>
<tr>
<td align="right">Primer apellido:</td>
<td><? echo $form->input('primer_apellido',array('label'=>false)); ?></td>
</tr>
<tr>
<td align="right">Segundo apellido:</td>
<td><? echo $form->input('segundo_apellido',array('label'=>false)); ?></td>
</tr>
<tr>
<td align="right">Correo:</td>
<td><? echo $form->input('correo',array('label'=>false)); ?></td>
</tr>
<tr>
<td align="right">Dirección:</td>
<td><? echo $form->input('direccion',array('label'=>false)); ?></td>
</tr>
<tr>
<td align="right">Usuario:</td>
<td><? echo $form->input('usuario',array('label'=>false)); ?></td>
</tr>
<tr>
<td align="right">Password:</td>
<td><? echo $form->input('clave',array('type'=>'password','label'=>false)); ?></td>
</tr>
<tr>
<td colspan="2" align="center"><? echo $form->submit('registrame'); ?></td>
</tr>
</table>
<?php echo $form->end(); ?>
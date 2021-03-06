<?php
	include_once 'conexion.php';

	$sentencia_select=$con->prepare('SELECT *FROM archivos ORDER BY id ASC');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$con->prepare('
			SELECT *FROM archivos WHERE titulo LIKE :campo OR descripcion LIKE :campo;'
		);

		$select_buscar->execute(array(
			':campo' =>"%".$buscar_text."%"
		));

		$resultado=$select_buscar->fetchAll();

	}





	

?>

<!DOCTYPE html> 
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Gestion</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>GESTION INTERNA DE ARCHIVOS</h2>
		<div class="barra__buscador">
			<form action="" class="formulario" method="post" enctype="multipart/form-data">
				<input type="text" name="buscar" placeholder="buscar nombre o apellidos" 
				value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="input__text">
				<input type="submit" class="btn" name="btn_buscar" value="Buscar">
				<a href="insert.php" class="btn btn__nuevo">Nuevo</a>
			</form>
		</div>
		<table method="post" enctype="multipart/form-data">
			<tr class="head">
				<td>Id</td>
				<td>Titulo</td>
				<td>Descripcion</td>
				<td>Fecha</td>
				<td>Archivo</td>
				<td>Correo</td>
				<td colspan="2">Acción</td>
				
			</tr>
			<?php foreach($resultado as $fila):?>
				<tr >
					<td><?php echo $fila['id']; ?></td>
					<td><?php echo $fila['titulo']; ?></td>
					<td><?php echo $fila['descripcion']; ?></td>
					<td><?php echo $fila['fecha']; ?></td>
					<td><a href="<?php echo $fila['ruta']?>"><?php echo $fila['archivo']; ?></td>
					<td ><?php echo $fila['correo']; ?></td>
					<td><a href="update.php?id=<?php echo $fila['id']; ?>"  class="btn__update" >Editar</a></td>
					<td><a href="delete.php?id=<?php echo $fila['id']; ?>" class="btn__delete">Eliminar</a></td>
				</tr>
			<?php endforeach ?>

		</table>
	</div>
</body>
</html>
<?php
	include_once 'conexion.php';

	if(isset($_GET['id'])){
		$id=(int) $_GET['id'];

		$buscar_id=$con->prepare('SELECT * FROM archivos WHERE id=:id LIMIT 1');
		$buscar_id->execute(array(
			':id'=>$id
		));
		$resultado=$buscar_id->fetch();
	}else{
		header('Location: index.php');
	}


	if(isset($_POST['guardar'])){
		$titulo=$_POST['titulo'];
		$descripcion=$_POST['descripcion'];
		$fecha=$_POST['fecha'];
		$archivo=$_POST['archivo'];
		$correo=$_POST['correo'];
		$id=(int) $_GET['id'];

		if(!empty($titulo) && !empty($descripcion) && !empty($fecha) && !empty($archivo) && !empty($correo) ){
			if(!filter_var($correo,FILTER_VALIDATE_EMAIL)){
				echo "<script> alert('Correo no valido');</script>";
			}else{
				$consulta_update=$con->prepare(' UPDATE archivos SET  
					titulo=:titulo,
					descripcion=:descripcion,
					fecha=:fecha,
					archivo=:archivo,
					correo=:correo
					WHERE id=:id;'
				);
				$consulta_update->execute(array(
					':titulo' =>$titulo,
					':descripcion' =>$descripcion,
					':fecha' =>$fecha,
					':archivo' =>$archivo,
					':correo' =>$correo,
					':id' =>$id
				));
				header('Location: index.php');
			}
		}else{
			echo "<script> alert('Los campos estan vacios');</script>";
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editar Cliente</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>CRUD EN PHP CON MYSQL</h2>
		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="titulo" value="<?php if($resultado) echo $resultado['titulo']; ?>" class="input__text">
				<input type="text" name="descripcion" value="<?php if($resultado) echo $resultado['descripcion']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<input type="date" name="fecha" value="<?php if($resultado) echo $resultado['fecha']; ?>" class="input__text">
				<input type="text" name="archivo" value="<?php if($resultado) echo $resultado['archivo']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<input type="text" name="correo" value="<?php if($resultado) echo $resultado['correo']; ?>" class="input__text">
			</div>
			<div class="btn__group">
				<a href="index.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>
</body>
</html>

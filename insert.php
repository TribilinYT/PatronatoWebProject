<?php 
	include_once 'conexion.php';
	
	if(isset($_POST['guardar'])){
		$titulo=$_POST['titulo'];
		$descripcion=$_POST['descripcion'];
		$fecha=$_POST['fecha'];
		$archivo=$_POST['archivo'];
		$correo=$_POST['correo'];
		$rutas=$_POST['file'];

		// creamos las variables para subir a la db
        $ruta = "upload/"; 
        $nombrefinal= trim ($_FILES['file']['name']); //Eliminamos los espacios en blanco
        $nombrefinal= ereg_replace (" ", "", $nombrefinal);//Sustituye una expresión regular
		$upload= $ruta . $nombrefinal; 



		
		if(!empty($titulo) && !empty($descripcion) && !empty($fecha) && !empty($archivo) && !empty($correo) ){

			if(move_uploaded_file($_FILES['file']['tmp_name'], $upload)) {
			if(!filter_var($correo,FILTER_VALIDATE_EMAIL)){
				echo "<script> alert('Correo no valido');</script>";
			}else{
				$consulta_insert=$con->prepare('INSERT INTO archivos(titulo,descripcion,fecha,archivo,correo,ruta) 
				VALUES(:titulo,:descripcion,:fecha,:archivo,:correo,:ruta)');
				$consulta_insert->execute(array(
					':titulo' =>$titulo,
					':descripcion' =>$descripcion,
					':fecha' =>$fecha,
					':archivo' =>$archivo,
					':correo' =>$correo,
					':ruta' =>$upload
				));
				header('Location: index.php');
			}

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
	<title>NUEVO DOCUMENTO</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>CRUD EN PHP CON MYSQL</h2>
		<BR>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<input type="text" name="titulo" placeholder="Titulo del archivo" class="input__text">
			</div>

			<div class="form-group">
				<input type="text" name="descripcion" placeholder="Descripcion  del archivo" class="input__text">
			</div>

			<div class="form-group">
				<input type="date" name="fecha" placeholder="Fecha" class="input__text">
			</div>

			<div class="form-group">
				<input type="text" name="archivo"  placeholder="Ingrese nombre del archivo" class="input__text">
			</div>

			<div class="form-group">
				<input type="email" name="correo" placeholder="Ingrese correo electrónico" class="input__text">
			</div>

			<div class="form-group">
				<input type="file" name="file" placeholder="Subir Archivo"  class="input__text">
			</div>

			<div class="btn__group">
				<a href="index.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>

	<br>

</body>
</html>

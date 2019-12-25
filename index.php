<?php
	include_once 'conexion.php';

	$sentencia_select=$con->prepare('SELECT *FROM archivos ORDER BY id ASC');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

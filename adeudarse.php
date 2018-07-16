<?php
if(isset($_POST['enviar']))
{
	if(!empty($_POST['nombre']) && !empty($_POST['deuda']))
	{
		include "conexion.php";
		$nombre=$_POST['nombre'];
		$debe=$_POST['deuda'];
		$descrip=$_POST['descrip'];
		$conexion = conectar();
		$bus=$conexion -> query("select *from operaciones where nombre='$nombre'") or die("error: ".mysqli_error());
		$identi=$conexion -> query("select *from operaciones order by id_operacion desc") or die ("consulta id: ".mysqli_error());
		$idbono=$conexion -> query("select *from adeudos order by id_abono desc") or die("consulta id bono: ".mysqli_error());
		$conta=$bus -> num_rows;
		if($conta>0)
		{
			header("location:index.php?msj= YA ESTA EN SISTEMA Y DEBE: ".strtoupper($nombre));
			exit();
		}
		else
		{
		    $iden=$identi -> fetch_assoc();
		    $auxiliar=$iden['id_operacion'];
		    $ide=$auxiliar+1;
		    $bono=$idbono -> fetch_assoc();
		    $auxiliar2=$bono['id_abono'];
		    $boni=$auxiliar2+1;
   			$fecha=date("Y-m-d");
   			if (empty($descrip)) {
   				$descrip="Otra";
   			}
			$op=$conexion-> query("INSERT INTO operaciones(id_operacion,nombre,debe,fecha)VALUES('$ide','$nombre','$debe','$fecha')") or die ("error ingreso: ".mysqli_error());
			
			//prueba
			$ne=$conexion -> query("INSERT INTO adeudos(id_abono,id_op,saldo,agrego,fecha_op,descrip,estado)VALUES('$boni','$ide','0','$debe','$fecha','$descrip','2')")or die("error guardar op: ".mysqli_error());
			if($op)
			{
				header("location:index.php?msj=INGRESO CON EXITO");
				exit();
			}
			else
			{
				header("location:index.php?msj=OCURRIO ALGUN ERROR EN LO QUE GUARDABA, INTENTE DE NUEVO");
				exit();
			}
			mysqli_free_result($bus);
			mysqli_free_result($identi);
			mysqli_free_result($idbono);
		}
		desconectar($conexion);
	}
	else
	{
		header("location:index.php?msj= FALTA NOMBRE O CANTIDAD, NO SE GUARDA SI FALTA ALGUNO DE LOS 2 CAMPOS");
		exit();
	}
}
else
{
	header("location:index.php?msj=DEBES INGRESAR ALGO EN CAMPOS");
	exit();
}
?>
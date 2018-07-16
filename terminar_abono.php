<?php
if (isset($_POST['enviar']))
{
	if(!empty($_POST['abonar']) && !empty($_POST['id_op']))
	{
		include "conexion.php";
		$oper=$_POST['abonar'];
		$id=$_POST['id_op'];
		$conexion = conectar();
		$bus=$conexion -> query("select *from operaciones where id_operacion='$id'") or die ("error: ".mysqli_error());
		$idbono=$conexion -> query("select *from adeudos order by id_abono desc") or die("consulta id bono: ".mysqli_error());
		$contar=$bus -> num_rows;
		if($contar>0)
		{
			$con=$bus -> fetch_assoc();
			$idnw=$con['id_operacion'];
			$nombre=$con['nombre'];
			$debe=$con['debe'];
			$deuda=$debe-$oper;
			$bono=$idbono -> fetch_assoc();
		    $auxiliar2=$bono['id_abono'];
		    $boni=$auxiliar2+1;
			$fecha=date("Y-m-d");
			if (empty($descrip)) {
				$descrip="Abono Cuenta";
			}
			if ($deuda>=0)
			{
			    $estado="1";//1 es abono y 2 es deuda
				$checa=$conexion -> query("INSERT INTO adeudos(id_abono,id_op,saldo,agrego,fecha_op,descrip,estado)VALUE('$boni','$idnw','$debe','$oper','$fecha','$descrip','$estado')") or die ("error guardado: ".mysqli_error());
			    $checa1=$conexion -> query("UPDATE operaciones SET debe='$deuda' where id_operacion='$idnw'") or die ("error guardado1: ".mysqli_error());
		    	mysqli_free_result($bus);
		    	desconectar($conexion);
    			if($checa && $checa1)
    			{
    				header("location:abono.php?msj=OPERACION REALIZADA CON EXITO,SALDO: $".$deuda);
    				exit();
    			}
    			else
    			{
    				header("location:abono.php?msj=ALGO SALIO MUY MAL, CHECA SI SE ABONO ALGO");
    				exit();
    			}
     
			}
			else 
			{
			    header("location:abono.php?msj=YA NO TE DEBE, LO ESTAS ESTAFANDO");
			    exit();
			}
		}
		else
		{
			header("location:abono.php?msj=NO SE ENCONTRARON DATOS Y NO PUDO TERMINAR, VUELVE A INTENTAR");
			exit();	
		}
	}
	else
	{
		header("location:abono.php?msj=ALGO PASO, NO SE PUDO REALIZAR LA OPERACION");
		exit();
	}
}
else
{
	header("location:abono.php?msj=OCCURRIO PROBLEMA VUELVE A INTENTAR LO PASADO");
	exit();
}
?>
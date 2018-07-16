<?php
if(isset($_POST['enviar']))
{
	if(!empty($_POST['fecha']))
	{
		include "conexion.php";
		$fecha=$_POST['fecha'];
		$deuda=$_POST['opcion'];
		$conexion = conectar();
		$bus=$conexion -> query("SELECT SUM(agrego) totales FROM adeudos where fecha_op='$fecha' AND estado='$deuda'") or die ("error: ".mysqli_error());
		$con=$bus -> fetch_assoc();
		$aux=$con['totales'];
		$fecha1=explode("-", $fecha);
		$fecha=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0];
		if($aux>0)
		{?>
		<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="control de deudas" />
	<title>deudoras 1.0</title>
	<meta charset="utf-8">
	<meta name="description" content="control de deudas" />
	<title>deudoras 1.0</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link type="image/x-icon" href="image/favicon.ico" rel="icon" />
	<link type="image/x-icon" href="image/favicon.ico" rel="shortcut icon" />
	<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Istok+Web|Esteban|Open+Sans' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="estilo.css">
	<link rel="stylesheet" href="fonts.css">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="main.js"></script>
	<script src="prefixfree.js"></script>
</head>
<body>
	<header>
	
		<div class="menu_bar">
			<a href="#" class="bt-menu"><span class="icon-list2"></span>Menu</a>
		</div>
		<nav>
			<ul>
				<li><a href="index.php"><span class="icon-pencil"></span>INGRESAR</a></li>
				<li><a href="abono.php"><span class="icon-coin-dollar"></span>ABONAR</a></li>
				<li><a href="deudoras.php"><span class="icon-credit-card"></span>VER DEUDORAS</a></li>
				<li><a href="total.php"><span class="icon-coin-pound"></span>TOTAL</a></li>
				<li><a href="mas.php"><span class="icon-folder-plus"></span>MAS</a></li>
			</ul>
		</nav>
	</header>
	<?php
	if(!empty($_GET['msj']))
	{
	?>
		<aside>
			<?php echo "<h4>".$_GET['msj']."</h4>";?>
		</aside>
	<?php
	}
	?>
	<section id="contenido">
					<article class="item">
						<h2>TOTAL</h2> 
						<?php

						echo "<div class='tutol cuadritos'> DIA: ".$fecha."</div>";
						echo "<div class='tutol cuadritos'>$ ". number_format($con['totales'],'2','.',',')."</div>";
						mysqli_free_result($bus);
						desconectar($conexion);
						?>
					</article>
				</section>	
	<footer>
		<p>
			<strong>Control de deudoras bolsas</strong>
		</p>
		<p>
			Creado por @dcreate
		</p>
	</footer>
</body>
</html>

<?php
		}
		else
		{
			header("location:mas.php?msj=NO EXISTEN DATOS DE ESE DIA VUELVE A INTENTARLO");
			exit();
		}
	}
	else
	{
		header("location:mas.php?msj=DEBE SELECCIONAR FECHA");
		exit();
	}
}
else
{
	header("location:mas.php?msj=FALTAN DATOS");
	exit();
}
?>
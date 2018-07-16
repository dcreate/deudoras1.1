<?php
if(!empty($_GET['id']))
{
	include "conexion.php";
	$id=$_GET['id'];
	$conexion = conectar();
	$bus=$conexion -> query("select *from operaciones where id_operacion='$id'") or die("error: ".mysqli_error());
	$contar=$bus -> num_rows;
	if($contar>0)
	{
		$con=$bus -> fetch_assoc();
	?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="description" content="control de deudas" />
	<title>deudoras 1.0</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link type="image/x-icon" href="image/favicon.ico" rel="icon" />
	<link type="image/x-icon" href="image/favicon.ico" rel="shortcut icon" />
	<link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Istok+Web|Esteban|Open+Sans|Galada' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="estilo_ver.css">
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
					<h2>VER TODAS DEUDAS</h2>
					<p>NOMBRE:</p>
						<div><?php echo strtoupper($con['nombre']);?></div>
						<p>DEBE:</p>
						<div><?php echo "$ ". number_format($con['debe'],2, '.', ',');?></div>
						<?php
							$aux=$con['id_operacion'];
							$b=$conexion -> query("select *from adeudos where id_op='$aux' order by fecha_op DESC") or die("error busquyeda: ".mysqli_error());
							$conteo=$b -> num_rows;
							if($conteo>0)
							{
								echo "<table align='center' border=1 class='tabla'>";
								echo "<thead>";
								echo "<tr>";
								echo "<th>MOVIMIENTO</th>";
								echo "<th>FECHA</th>";
								echo "<th>SALDO ANTERIOR</th>";
								echo "<th>CUANTO ABONO/ENDEUDO</th>";
								echo "<th>DESCRIPCION</th>";
								echo "</tr>";
								echo "</thead>";
								echo "<tbody>";
								while ($c=$b -> fetch_assoc())
								{
									echo "<tr>";
									$au=$c['estado'];
									if($au==1)
									{
										$new="ABONO";
										$carater="-";
										$status="libre";
									}
									else if ($au==2)
									{
										$new="A DEUDA";
										$carater="+";
										$status="deberas";
									}
									else
									{
										$new="no info";
										$carater=" ";
									}
									echo "<td class='".$status."'>".$new."</td>";
									$fecha=explode("-", $c['fecha_op']);
									$fecha1=$fecha[2]."/".$fecha[1]."/".$fecha[0];
									echo "<td>".$fecha1."</td>";
									echo "<td> $".number_format($c['saldo'],2,'.',',')."</td>";									
									echo "<td>". $carater."$".number_format($c['agrego'],2,'.',',')."</td>";
									echo "<td>".$c['descrip']."</td>";									
									echo "</tr>";
								}
								echo "</tbody>";
								echo "</table>";
								mysqli_free_result($bus);
								mysqli_free_result($b);
								desconectar($conexion);
							}
							else
							{
								echo "<h4>No existen mas movimientos</h4>";
							}
						?>
				</article>
			</section>
	<footer>
		<p>
			<strong>Control de creditos Pacientes</strong>
		</p>
		<p class="cursivas">
			Meraki Spa
		</p>
	</footer>
</body>
</html>
<?php
	}	
	else
	{
		header("location:deudoras.php?msj=NO EXISTEN DATOS PARA MOSTRAR");
		exit();
	}
}
else
{
	header("deudoras.php?msj=ALGO SALIO MAL, VUELVE A INTERNARLO");
	exit();
}
?>
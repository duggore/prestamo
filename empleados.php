<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
/*Funcion para fechas*/
$fecha=$_POST['fecha_nac'];
 list($dia, $year, $mes)=explode("/", $fecha);
  
  $fecha=$mes."-".$dia."-".$year;
  
  

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO clientes (rfc, nombre, paterno, materno, direccion, fecha_nac, celular, telefono) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rfc'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['paterno'], "text"),
                       GetSQLValueString($_POST['materno'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($_POST['celular'], "int"),
                       GetSQLValueString($_POST['telefono'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "empleados.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexion, $conexion);
$query_Clientes = "SELECT clientes.rfc, clientes.nombre, clientes.paterno, clientes.materno, clientes.direccion, clientes.fecha_nac, clientes.celular, clientes.telefono FROM clientes";
$Clientes = mysql_query($query_Clientes, $conexion) or die(mysql_error());
$row_Clientes = mysql_fetch_assoc($Clientes);
$totalRows_Clientes = mysql_num_rows($Clientes);
?>
<!--Inicia Listar Trabajadores-->


<!DOCTYPE html>
<html lang="en"><!-- InstanceBegin template="/Templates/plantillaBase.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	
	<meta charset="utf-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>NOMITEKH - Sistema de control de Prestamos</title>
	<!-- InstanceEndEditable -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	
	<link rel="shortcut icon" href="images/favicon.ico">
    
	<!-- CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/flexslider.css" rel="stylesheet" type="text/css" />
	<link href="css/prettyPhoto.css" rel="stylesheet" type="text/css" />
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/owl.carousel.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css" />
     <link href="css/ui-lightness/jquery-ui-1.10.0.custom.css" rel="stylesheet"/>
    
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500italic,700,500,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">	
    
	<!-- SCRIPTS -->
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if IE]><html class="ie" lang="en"> <![endif]-->
    <script type="text/javascript"></script>
    <script src="js/jquery.js"></script>
	<script src="js/jquery-ui.custom.js"></script>
	<script src="js/modernizr.js"></script>
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script src="js/bootstrap.min.js" type="text/javascript"></script>
	<script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
	<script src="js/jquery.nicescroll.min.js" type="text/javascript"></script>
	<script src="js/superfish.min.js" type="text/javascript"></script>
	<script src="js/jquery.flexslider-min.js" type="text/javascript"></script>
	<script src="js/owl.carousel.js" type="text/javascript"></script>
	<script src="js/animate.js" type="text/javascript"></script>
	<script src="js/jquery.BlackAndWhite.js"></script>
	<script src="js/myscript.js" type="text/javascript"></script>
    <script src="js/operaciones.js" type="text/javascript"></script>
	<!-- InstanceBeginEditable name="head" -->
    <script>
	Modernizr.load({
		test: Modernizr.inputtypes.date,
		nope: "js/jquery-ui.custom.js",
		callback: function() {
		  $("input[type=date]").datepicker();
		}
	  });
	</script>
	<!-- InstanceEndEditable -->
</head>
<body>

<!-- PRELOADER -->
<img id="preloader" src="images/preloader.gif" alt="" />
<!-- //PRELOADER -->
<div class="preloader_hide">

	<!-- PAGE -->
	<div id="page">
	
		<!-- HEADER -->
		<header>
			
			<!-- MENU BLOCK -->
			<div class="menu_block">
			
				<!-- CONTAINER -->
				<div class="container clearfix">
					
					<!-- LOGO -->
					<div class="logo pull-left">
						<h4 class="titulo">NOMBRE DE LA EMPRESA</h4>
					</div><!-- //LOGO -->
					
										
					<!-- MENU -->
					<div class="pull-right">
						<nav class="navmenu center">
							<ul>
								<li class="first active scroll_btn"><a href="index.php" >Inicio</a></li>
								<li class="sub-menu"><a href="javascript:void(0);">Procesos</a>
									<ul>
										<li><a href="bonificacionInteres.php">Bonificacion Interes</a></li>
										<li><a href="capturaAbono.php">Captura Abono</a></li>
										<li><a href="capturaPrestamo.php">Captura Prestamos</a></li>
                                        <li><a href="empleados.php" >Empleados</a></li>
                                        <li><a href="devoluciones.php">Devoluciones</a></li>
                                        <li><a href="modificacionAbonos.php">Modificacion Abonos</a></li>
                                        <li><a href="modificacionPrestamos.php">Modificacion Prestamos</a></li>
                                        <li><a href="generarArchivo.php">Generar Archivo</a></li>
                                        <li><a href="importarArchivo.php">Importar Archivo</a></li>
									</ul>
								</li>
                                <li class="sub-menu"><a href="javascript:void(0);">Consultas</a>
									<ul>
										<li><a href="consultaDinamica.php">Consulta Dinámica</a></li>
										<li><a href="consultaFichas.php">Consulta Fichas</a></li>
										<li><a href="consultaCatorcena.php">Por Catorcena</a></li>
                                        <li><a href="consultaInteresBonificado.php">Intereses Bonificado</a></li>
                                        <li><a href="consultaSaldoTotal.php">Saldo Totales</a></li>
                                        <li><a href="prestamoEmpleado.php">Prestamo Empleado</a></li>
                                        <li><a href="prestamoLiquidado.php">Prestamos Líquidados</a></li>
									</ul>
								</li>
                                <li class="sub-menu"><a href="javascript:void(0);">Administración</a>
									<ul>
										<li><a href="tipoPago.php" >Tipo Pago</a></li>
                                        <li><a href="limiteCredito.php" >Limite Crédito</a></li>
									</ul>
								</li>
							</ul>
						</nav>
					</div><!-- //MENU -->
				</div><!-- //MENU BLOCK -->
			</div><!-- //CONTAINER -->
		</header><!-- //HEADER --><!-- InstanceBeginEditable name="EditRegion3" -->
        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
          <table align="left" id="AltaCliente" class="AltaCliente">
            <tr valign="baseline">
              <td nowrap align="right">RFC:</td>
              <td><input type="text" name="rfc" value="" size="15" required></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Nombre:</td>
              <td><input type="text" name="nombre" value="" size="15" required></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Paterno:</td>
              <td><input type="text" name="paterno" value="" size="20" required></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Materno:</td>
              <td><input type="text" name="materno" value="" size="20"></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Direccion:</td>
              <td><textarea name="direccion" cols="29" required></textarea> </td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Fecha_nac:</td>
              <td><input type="date" name="fecha_nac" value=<?php echo date('m/d/Y'); ?> size="12" required></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Celular:</td>
              <td><input type="text" name="celular" value="" size="15"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Telefono:</td>
              <td><input type="text" name="telefono" value="" size="15"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input name="Enviar" type="submit" value="Insertar registro"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
        <p>&nbsp;         </p>
        <table width="1000" border="1" align="center" cellpadding="2" cellspacing="2" class="registrosClientes" id="RegistroClientes">
          <tr>
            <td width="102" align="center">RFC</td>
            <td width="103" align="center">Nombre</td>
            <td width="175" align="center">Apellido Paterno</td>
            <td width="132" align="center">Apellido Materno</td>
            <td width="170" align="center">Direccion</td>
            <td width="103" align="center">Fecha Nacimiento</td>
            <td width="68" align="center">Celular</td>
            <td width="79" align="center">Telefono</td>
          </tr>
         
          <?php do { ?>
          <tr>
            <td><?php echo $row_Clientes['rfc']; ?></td>
            <td><?php echo $row_Clientes['nombre']; ?></td>
            <td><?php echo $row_Clientes['paterno']; ?></td>
            <td><?php echo $row_Clientes['materno']; ?></td>
            <td><?php echo $row_Clientes['direccion']; ?></td>
            <td><?php echo $row_Clientes['fecha_nac']; ?></td>
            <td><?php echo $row_Clientes['celular']; ?></td>
            <td><?php echo $row_Clientes['telefono']; ?></td>
          </tr>
            <?php } while ($row_Clientes = mysql_fetch_assoc($Clientes)); ?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <!-- InstanceEndEditable -->
		
			
		<!-- CONTAINER -->
		<div class="container">
		<footer>
        <p>© 2017 HSNet Solutions | Diseñado por  julioa.iglesias@outlook.com </p>	
	</footer><!-- //FOOTER -->
	</div><!-- //CONTAINER -->
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Clientes);
?>

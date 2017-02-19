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
$fecha=$_POST['fecha'];
 list($dia, $year, $mes)=explode("/", $fecha);
  
  $fecha=$mes."-".$dia."-".$year;

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO prestamos (CodPrestamo, FkCliente, fecha, Principal, Interes, Cuota, Plazo, TipoPago) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CodPrestamo'], "int"),
                       GetSQLValueString($_POST['FkCliente'], "int"),
                       GetSQLValueString($fecha, "date"),
                       GetSQLValueString($_POST['Principal'], "double"),
                       GetSQLValueString($_POST['Interes'], "double"),
                       GetSQLValueString($_POST['Cuota'], "double"),
                       GetSQLValueString($_POST['Plazo'], "int"),
                       GetSQLValueString($_POST['TipoPago'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "capturaPrestamo.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
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
     var mipopup;
	 function popup()
     {
		 mipopup = window.open("popup.php","BuscaCliente","width=1000,height=300,menubar=si");
		 mipopup.focus()
		 
     }
	 
	 </script>
	 
	 
	 
	 <script>
	Modernizr.load({
		test: Modernizr.inputtypes.date,
		nope: "js/jquery-ui.custom.js",
		callback: function() {
		  $("input[type=date]").datepicker();
		}
	  });
	</script>
    
    <script>
	function CantidadTotal(){
	cantidad = document.getElementById("cantPrestamo").value;
interes = document.getElementById("intereses").value;
cantTotal = parseInt(cantidad) + parseInt(interes);
document.getElementById("total").value = cantTotal;	
		}
</script>
    
    <script type="text/javascript">
function calculate() {
  var montoprincipal = document.getElementById("Principal").value;
  var interes  = document.getElementById("Interes").value / 100 ;
  var tiempo  = document.getElementById("Plazo").value;
  var x         = Math.pow(1 + interes, tiempo);
  var monthly   = (montoprincipal*x*interes)/(x-1);
  if (!isNaN(monthly) &&
      (monthly != Number.POSITIVE_INFINITY) &&
	  (monthly != Number.NEAGTIVE_INFINITY)) {
    document.getElementById("Cuota").value=Math.round(monthly);
	/*document.getElementById("Cuota").value=Math.round(monthly*payments);*/
	/*document.loandata.totalinterest.value=Math.round((monthly*payments) - principal);*/
  }
  else {
    document.getElementById("Plazo").value="";
	document.getElementById("Cuota").value="";
	/*document.loandata.totalinterest.value="";*/
  }
}
function round(x) {return Math.round(x *100)/100;}
</script>

<script>

function extraer(){
var CodCliente = document.getElementById("FkCliente").value;
var cadena = document.getElementById("fecha").value;
    patron = "/";
    nuevoValor    = "";
var nuevaCadena = cadena.replace(patron, nuevoValor);
var cadena2 = nuevaCadena;
    patron = "/";
    nuevoValor    = "";
    final = cadena2.replace(patron, nuevoValor);
var resultado = CodCliente.concat(final);

document.getElementById("CodPrestamo").value= resultado; // la consola devolverá: cad3na d3 t3xto
}

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
          <table align="left" id="AltaPrestamo">
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Código Préstamo:</td>
              <td><input type="text" id="CodPrestamo" name="CodPrestamo" value="" size="15" required></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Código Cliente:</td>
              <td><input type="text" id="FkCliente" name="FkCliente" value="" size="10" required readonly> <input type="button" value="Buscar" onClick="popup()">
</td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Fecha:</td>
              <td><input type="date" id="fecha" name="fecha" value=<?php echo date('m/d/Y'); ?> size="12" required></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Tipo Pago:</td>
              <td><select name="TipoPago">
                <option value="mensual">Mensual</option>
                <option value="semanal">Semanal</option>
                <option value="quincenal">Quincenal</option>
                 </select></td>
              </tr>
            <tr valign="baseline">
              <td align="center" valign="middle" nowrap>Monto Principal:</td>
              <td><input type="text" id="Principal" name="Principal" value="" size="15"  onBlur="calculate()" onChange="extraer()" required></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Monto Interes:</td>
              <td><input type="text" id="Interes" name="Interes" value="" size="15" onBlur="calculate()" required></td>
            </tr>
            <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Plazo:</td>
              <td><input type="text" id="Plazo" name="Plazo" value="" size="32" onBlur="calculate()" required></td>
            </tr>
             <tr valign="baseline">
              <td align="right" valign="middle" nowrap>Cuota:</td>
              <td><input type="text" id="Cuota" name="Cuota" value="" size="15" required></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Insertar registro"></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
          
        </form>
        
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
mysql_free_result($CapturaPrestamo);
?>

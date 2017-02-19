<?php require_once('Connections/conexion.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script>
/*function datos(cod,nom,lug,nro){*/
function datos(cod,nom,lug,nro){
    opener.document.form1.FkCliente.value = cod;
   /* opener.document.BuscaCliente.origen.value = nom;
    opener.document.BuscaCliente.lugar.value = lug;
    opener.document.BuscaCliente.lstname.value = nro;*/
    window.close();
}


function Resaltar_On(GridView)
{
    if(GridView != null)
    {
    GridView.originalBgColor = GridView.style.backgroundColor;
    GridView.style.backgroundColor='#DBE7F6';
    GridView.style.cursor = 'hand'; 
    }
}

function Resaltar_Off(GridView)
{
    if(GridView != null)
    {
    GridView.style.backgroundColor = GridView.originalBgColor;    
    }
}
function Close() {    
    window.close();
}

//]]>
</script>

<?php
if($_GET{"enviar"}<>""){
    if($_GET{"seleccion"}==2){
        $valor="selected";
        $qq="codigo";
    }else
        $qq="nombre";
}
?>
<strong>Buscar Cliente</strong>
<form id="form1" name="form1" method="get" action="?">
  <label for="seleccion"></label>
  <select name="seleccion" id="seleccion">
    <option value="1">Por Nombre</option>
    <option value="2" <?php echo $valor; ?>>Por Codigo</option>
  </select>
  <label for="q"></label>
  <input type="text" name="q" id="q" />
  <input type="submit" name="enviar" id="enviar" value="Buscar" />
</form>
<FORM onkeypress="javascript:return WebForm_FireDefaultButton(event, &#39;ctl00_ContentPlaceMain_btnBuscar&#39;)">

<table   border="1" cellspacing="0" cellpadding="0">
  <tr bgcolor="#AEE4FF">
    <td  width="66">ID</td>
    <td  width="120">RFC</td>
    <td width="240">NOMBRE</td>
    <td width="150">PATERNO</td>
    <td width="150">MATERNO</td>
    <td width="208">DIRECCION</td>
    <td width="208">FECHA NAC</td>
    <td width="208">CELULAR</td>
    <td width="208">TELEFONO</td>
  </tr>

<?php
    if($_GET['q']<>""){
    $i=0;
        // Connect to the database and checks if the user / password
        // combinaison matches any existing database entry
        mysql_select_db($database_conexion, $conexion) or die ("falla!");
        $query = "SELECT * FROM clientes WHERE ".$qq." LIKE '%".$_GET['q']."%' ";
        //echo $query;
        // $r_query = mysql_query($query, $mysql_link);// or mysql_error() and die("Failed to execute_query");
        $r_query = mysql_query($query, $conexion) or die("Failed to execute_query");
        
        while ($row = mysql_fetch_array($r_query)) {
            $i++;
            $rfc=$row{'rfc'};
            $nombre=$row{'nombre'};
            $paterno=$row{'paterno'};
            $materno=$row{'materno'};
            $direccion=$row{'direccion'};
            $direccion=str_replace(" ", "&nbsp;", $direccion);
			$fecha=$row{'fecha_nac'};
			$celular=$row{'celular'};
			$telefono=$row{'telefono'};
            $id=$row{'id'};
            /*echo "<tr OnMouseOver='Resaltar_On(this);' OnMouseOut='Resaltar_Off(this);' OnClick=datos('$codigo','$colegio','$lugar','$id')><td>$i</td><td>$codigo</td><td>$colegio</td><td>".$row{'nivel'}."</td><td>$lugar</td></tr>";*/
			echo "<tr OnMouseOver='Resaltar_On(this);' OnMouseOut='Resaltar_Off(this);' OnClick=datos('$id')>
			<td>$i</td><td>$rfc</td><td>$nombre</td><td>$paterno</td><td>$materno</td><td>$direccion</td><td>$fecha</td><td>$celular</td><td>$telefono</td></tr>";
      }
    }
?>
</table>
</FORM>




























</head>

<body>
</body>
</html>
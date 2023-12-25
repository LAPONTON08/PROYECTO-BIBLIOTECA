<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'");?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO multa (valor_multa, id_prestamo, dias_multa, estado) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['valor_multa'], "int"),
                       GetSQLValueString($_POST['id_prestamo'], "int"),
                       GetSQLValueString($_POST['dias_multa'], "int"),
                       GetSQLValueString($_POST['estado'], "text"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());

//mysql_select_db($database_conexionBD, $conexionBD);
$query_estado = "UPDATE  ejeemplar SET  disponibilidad = 0 WHERE id_ejemplar =" . $_POST['id_ejemplar'];
//echo $query_estado;
$estado = mysql_query($query_estado, $conexionBD) or die(mysql_error());

}

$colname_prestamos = "-1";
if (isset($_GET['id_prestamo'])) {
  $colname_prestamos = (get_magic_quotes_gpc()) ? $_GET['id_prestamo'] : addslashes($_GET['id_prestamo']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_prestamos = sprintf("SELECT * FROM prestamos1 WHERE id_prestamo = %s", $colname_prestamos);
$prestamos = mysql_query($query_prestamos, $conexionBD) or die(mysql_error());
$row_prestamos = mysql_fetch_assoc($prestamos);
$totalRows_prestamos = mysql_num_rows($prestamos);

mysql_select_db($database_conexionBD, $conexionBD);
$query_valor_multa = "SELECT * FROM variables_globales";
$valor_multa = mysql_query($query_valor_multa, $conexionBD) or die(mysql_error());
$row_valor_multa = mysql_fetch_assoc($valor_multa);
$totalRows_valor_multa = mysql_num_rows($valor_multa);

$colname_Multas = "-1";
if (isset($_GET['id_prestamo'])) {
  $colname_Multas = (get_magic_quotes_gpc()) ? $_GET['id_prestamo'] : addslashes($_GET['id_prestamo']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_Multas = sprintf("SELECT * FROM multa WHERE id_prestamo = %s", $colname_Multas);
$Multas = mysql_query($query_Multas, $conexionBD) or die(mysql_error());
$row_Multas = mysql_fetch_assoc($Multas);
$totalRows_Multas = mysql_num_rows($Multas);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />

<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 2px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	border-top-color: #666666;
	border-right-color: #666666;
	border-bottom-color: #666666;
	border-left-color: #666666;
}
.Estilo5 {font-size: 14px; font-weight: bold; }
.Estilo6 {
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {font-size: 10px; font-weight: bold; }
.Estilo10 {font-size: 10; }
.Estilo11 {
	font-size: 16px;
	font-weight: bold;
}
.Estilo12 {font-size: 12px}
</style>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<table style="border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="213" rowspan="3" align="center" valign="middle"><img src="images/Logo.png" width="203" height="90" hspace="5" vspace="5" align="middle" /></td>
    <td width="440">
    <h2 align="center">FORMATO  DE MULTA </h2>    </td>
  </tr>
  <tr>
    <td>  <div align="center">N°:&nbsp; <?php echo $row_Multas['id_multa']; ?></div></td>
  </tr>
</table>
<table style="border-bottom:#333333 solid 1PX; border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX" width="100%" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">DATOS DEL PR&Eacute;STAMO </span> </div></td>
  </tr>
  <tr>
    <td width="190"><span class="Estilo6">Nombre Libro: </span></td>
    <td colspan="3"><?php echo $row_prestamos['nombre_libro']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE PR&Eacute;STAMO </div></td>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE DEVOLUCI&Oacute;N </div></td>
    <td colspan="2" align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE ENTREGA </div></td>
  </tr>
  <tr>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_prestamos['fecha_prestamo']; ?></div></td>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_prestamos['fecha_devolucion']; $fecha_devolucion = $row_prestamos['fecha_devolucion'];?></div></td>
    <td colspan="2" valign="top"><div align="center" class="Estilo10"><?php echo date("Y-m-d H:i:s"); $fecha_entrega = date("Y-m-d H:i:s"); ?>
        <?php 
			$fecha_devolucion=strtotime('now') - strtotime($fecha_devolucion);
			$diferencia_dias = intval($fecha_devolucion/60/60/24);
			if ($diferencia_dias>0) { /*echo "Tiene " . $diferencia_dias . " dias de multa por $ " . (1702*$diferencia_dias);  */  } ;?>
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="5" style="border-bottom:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX">
  <tr>
    <td colspan="2"><span class="Estilo6">Datos Estudiante</span> </td>
    <td colspan="2"><span class="Estilo6">Datos Multa</span></td>
  </tr>
  <tr>
    <td width="93"><span class="Estilo8">Identificaci&oacute;n:</span></td>
    <td width="576"><?php echo $row_prestamos['doc']; ?></td>
    <td width="80"><span class="Estilo8">Multa x D&iacute;a: </span></td>
    <td width="275"><?php echo $row_valor_multa['valor_multa']; ?></td>
  </tr>
  <tr>
    <td><span class="Estilo8">Nombre:</span></td>
    <td><?php echo $row_prestamos['nombre_comp']; ?></td>
    <td><span class="Estilo8">N&deg; D&iacute;as:</span></td>
    <td><?php echo $diferencia_dias;    ?></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <?php if ($totalRows_Multas==0) { ?>  
	  <input name="submit" type="submit" value="                        Multa de Biblioteca                        " />
      <?php } else { echo "Multa generada con exito"; }?>
	</div></td>
    <td><span class="Estilo8">Total a Pagar: </span></td>
    <td><div align="center" class="Estilo11">&nbsp;$
        <?php  
		$valor_multa = $diferencia_dias* $row_valor_multa['valor_multa'];
		echo $valor_multa;  ?>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><HR></td>
  </tr>
  <tr>
    <td style="font-style:italic" colspan="4"><div align="center" class="Estilo12">
      <p>P&Aacute;GUESE EN COOMULTRASAN - CUENTA DE AHORROS N&deg; 0208169792 - FORMATO MULTA DE BIBLIOTECA . </p>
      <p>CONSEJO DIRECTIVO ACUERDO N&deg;. 01-053 (Bucaramanga, Noviembre 21 2014) </p>
      <p>Por medio del cual se establecen los Derechos Pecuniarios y Complementarios vigencia 2015 de las Unidades Tecnol&oacute;gicas de Santander. </p>
    </div></td>
  </tr>
</table>
  <input type="hidden" name="valor_multa" value="<?php echo $valor_multa;?>">
  <input type="hidden" name="id_prestamo" value="<?php echo $row_prestamos['id_prestamo']; ?>">
  <input type="hidden" name="dias_multa" value="<?php echo $diferencia_dias;?>">
  <input type="hidden" name="id_ejemplar" value="<?php echo $row_prestamos['id_ejemplar']; ?>">
  <input type="hidden" name="estado" value="0">
  <input type="hidden" name="MM_insert" value="form1">
</form><br />
<br />

<table style="border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX" width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="213" rowspan="3" align="center" valign="middle"><img src="images/Logo.png" width="203" height="90" hspace="5" vspace="5" align="middle" /></td>
    <td width="440"><h2 align="center">FORMATO DE MULTA </h2></td>
  </tr>
  <tr>
    <td><div align="center">N&deg;:&nbsp;<?php echo $row_Multas['id_multa']; ?></div></td>
  </tr>
</table>
<table style="border-bottom:#333333 solid 1PX; border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX" width="100%" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">DATOS DEL PR&Eacute;STAMO </span> </div></td>
  </tr>
  <tr>
    <td width="190"><span class="Estilo6">Nombre Libro: </span></td>
    <td colspan="3"><?php echo $row_prestamos['nombre_libro']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE PR&Eacute;STAMO </div></td>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE DEVOLUCI&Oacute;N </div></td>
    <td colspan="2" align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE ENTREGA </div></td>
  </tr>
  <tr>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_prestamos['fecha_prestamo']; ?></div></td>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_prestamos['fecha_devolucion']; $fecha_devolucion = $row_prestamos['fecha_devolucion'];?></div></td>
    <td colspan="2" valign="top"><div align="center" class="Estilo10"><?php echo date("Y-m-d H:i:s"); $fecha_entrega = date("Y-m-d H:i:s"); ?>
            <?php 
			$fecha_devolucion=strtotime('now') - strtotime($fecha_devolucion);
			$diferencia_dias = intval($fecha_devolucion/60/60/24);
			if ($diferencia_dias>0) { /*echo "Tiene " . $diferencia_dias . " dias de multa por $ " . (1702*$diferencia_dias);  */  } ;?>
    </div></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="5" style="border-bottom:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX">
  <tr>
    <td colspan="2"><span class="Estilo6">Datos Estudiante</span> </td>
    <td colspan="2"><span class="Estilo6">Datos Multa</span></td>
  </tr>
  <tr>
    <td width="93"><span class="Estilo8">Identificaci&oacute;n:</span></td>
    <td width="576"><?php echo $row_prestamos['doc']; ?></td>
    <td width="80"><span class="Estilo8">Multa x D&iacute;a: </span></td>
    <td width="275"><?php echo $row_valor_multa['valor_multa']; ?></td>
  </tr>
  <tr>
    <td><span class="Estilo8">Nombre:</span></td>
    <td><?php echo $row_prestamos['nombre_comp']; ?></td>
    <td><span class="Estilo8">N&deg; D&iacute;as:</span></td>
    <td><?php echo $diferencia_dias;    ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td><span class="Estilo8">Total a Pagar: </span></td>
    <td><div align="center" class="Estilo11">&nbsp;$
      <?php  echo $diferencia_dias* $row_valor_multa['valor_multa'];  ?>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><hr /></td>
  </tr>
  <tr>
    <td style="font-style:italic" colspan="4"><div align="center" class="Estilo12">
      <p>P&Aacute;GUESE EN COOMULTRASAN - CUENTA DE AHORROS N&deg; 0208169792 - FORMATO MULTA DE BIBLIOTECA . </p>
      <p>CONSEJO DIRECTIVO ACUERDO N&deg;. 01-053 (Bucaramanga, Noviembre 21 2014) </p>
      <p>Por medio del cual se establecen los Derechos Pecuniarios y Complementarios vigencia 2015 de las Unidades Tecnol&oacute;gicas de Santander. </p>
    </div></td>
  </tr>
</table>
<p align="center"><a href="javascript:history.back()"><img src="images/Volver.png" width="40" height="40" /></a></p>
</body>
</html>
<?php
mysql_free_result($prestamos);

//mysql_free_result($valor_multa);

mysql_free_result($Multas);
?>

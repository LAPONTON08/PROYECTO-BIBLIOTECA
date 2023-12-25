<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'"); ?>
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
  $insertSQL = sprintf("INSERT INTO prestamos (id_alumno, fecha_prestamo, fecha_devolucion, id_ejemplar) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['bus'], "int"),
                       GetSQLValueString($_POST['fecha_prestamo'], "date"),
                       GetSQLValueString($_POST['fecha_devolucion'], "date"),
                       GetSQLValueString($_POST['id_ejemplar'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());

  $insertGoTo = "modificar_estado.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexionBD, $conexionBD);
$query_usuarios = "SELECT * FROM alumno";
$usuarios = mysql_query($query_usuarios, $conexionBD) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

$colname_ejemplar_detalle = "-1";
if (isset($_GET['id_ejemplar'])) {
  $colname_ejemplar_detalle = (get_magic_quotes_gpc()) ? $_GET['id_ejemplar'] : addslashes($_GET['id_ejemplar']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_ejemplar_detalle = sprintf("SELECT * FROM ejemplar_detalle WHERE id_ejemplar = %s", $colname_ejemplar_detalle);
$ejemplar_detalle = mysql_query($query_ejemplar_detalle, $conexionBD) or die(mysql_error());
$row_ejemplar_detalle = mysql_fetch_assoc($ejemplar_detalle);
$totalRows_ejemplar_detalle = mysql_num_rows($ejemplar_detalle);

$colname_librodetalle = "-1";
if (isset($_GET['id_libro'])) {
  $colname_librodetalle = (get_magic_quotes_gpc()) ? $_GET['id_libro'] : addslashes($_GET['id_libro']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_librodetalle = sprintf("SELECT * FROM libro_detalle WHERE id_libro = %s", $colname_librodetalle);
$librodetalle = mysql_query($query_librodetalle, $conexionBD) or die(mysql_error());
$row_librodetalle = mysql_fetch_assoc($librodetalle);
$totalRows_librodetalle = mysql_num_rows($librodetalle);

$colname_usuario_activo = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usuario_activo = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_usuario_activo = sprintf("SELECT * FROM usuarios WHERE cod_usuario = %s", $colname_usuario_activo);
$usuario_activo = mysql_query($query_usuario_activo, $conexionBD) or die(mysql_error());
$row_usuario_activo = mysql_fetch_assoc($usuario_activo);
$totalRows_usuario_activo = mysql_num_rows($usuario_activo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="ajax.js"></script>
<script src="JSCal2-1.9/src/js/jscal2.js"></script>
<script src="JSCal2-1.9/src/js/lang/es.js"></script>
	<link rel="stylesheet" type="text/css" href= "JSCal2-1.9/src/css/jscal2.css">
	<link rel="stylesheet" type="text/css" href= "JSCal2-1.9/src/css/border-radius.css">
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/steel/steel.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
}
</style>
<script language='javascript'>
function msj() {
alert ("Prestamo realizado con exito")
}

</script>

</head>

<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FBDD">
    <td><H1 class="titulos">&nbsp; PR&Eacute;STAMOS</H1></td>
  </tr>
</table>
<table width="90%" border="1"  align="center" cellpadding="4" cellspacing="0" >
  <tr> 
    <th >C&Oacute;DIGO:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['id_libro']); ?></td>
    <th>AUTOR 1:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_autor']); ?></td>
    <th>IDIOMA :</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['idioma']); ?></td>
  </tr>
  <tr>
    <th>ISBN:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['cod_isbn']); ?></td>
    <th>AUTOR 2:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_autor1']); ?></td>
    <th>EDICI&Oacute;N:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['edicion']); ?></td>
  </tr>
  <tr>
    <th>NOMBRE: </th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_libro']); ?></td>
    <th>AUTOR 3:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_autor2']); ?></td>
    <th>LUGAR :</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['lugar']); ?></td>
  </tr>
  <tr>
    <th>EDITORIAL:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_editorial']); ?></td>
    <th>AUTOR 4:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_autor3']); ?></td>
    <th>A&Ntilde;O:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['anio']); ?></td>
  </tr>
  <tr>
    <th>TEMA:</th>
    <td bgcolor="#FFFFFF"><?php echo $row_librodetalle['tema']; ?></td>
    <th>AUTOR 5:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_autor4']); ?></td>
    <th>AREA:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_area']); ?></td>
  </tr>
  <tr>
    <th>N&deg; DE P&Aacute;GINAS:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['n_paginas']); ?></td>
    <th>SIGNATURA TOPOGR&Aacute;FICA:</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['signatura_top']); ?></td>
    <th> RECURSO :</th>
    <td bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_recurso']); ?></td>
  </tr>
  <tr>
    <th>COLECCI&Oacute;N: </th>
    <td colspan="5" bgcolor="#FFFFFF"><?php echo strtoupper ($row_librodetalle['nombre_coleccion']); ?></td>
  </tr>
</table>
</p>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="80%" align="center" cellpadding="2" cellspacing="1">
    <tr valign="baseline">
      <tH width="293" align="right" nowrap><div align="right">EJEMPLAR:</div></tH>
      <td colspan="2" bgcolor="#F4F5F2"><input readonly="yes" type="text" name="id_ejemplar" value="<?php echo $row_ejemplar_detalle['id_ejemplar']; ?>" size="28"></td>
    </tr>
    <tr valign="baseline">
      <tH nowrap align="right"><div align="right">ESTUDIANTE:</div></tH>
      <td width="172" bgcolor="#F4F5F2"><input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required placeholder="Digite N&deg; de Documento" /></td>
      <td width="391" bgcolor="#F4F5F2"><div id="myDiv"></div></td>
    </tr>
    <tr valign="baseline">
      <tH nowrap align="right"><div align="right">FECHA PR&Eacute;STAMO:</div></tH>
      <td colspan="2" align="right" nowrap="nowrap" bgcolor="#F4F5F2"><input name="fecha_prestamo" id="f_date1" value="<?php echo date("Y-m-d H:m:s" );?>" size="20" />
        <button id="f_btn1">...</button>
      <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : "%Y-%m-%d %H:%m"
      });
    //]]></script></td>
    </tr>
    <tr valign="baseline">
      <tH align="right" nowrap><div align="right">FECHA DEVOLUCI&Oacute;N: </div></tH>
      <td colspan="2" bgcolor="#F4F5F2"><input readonly="yes" name="fecha_devolucion" type="text" id="fecha_devolucion" value="<?php $fecha=date("Y-m-d H:m:s") ; $nuevafecha= strtotime('+7 day', strtotime($fecha)); $nuevafecha = date('Y-m-j H:m:s',$nuevafecha); echo $nuevafecha; ?>" size="28" /></td>
    </tr>
    <tr valign="baseline">
      <tH align="right" nowrap><div align="right">RENOVACI&Oacute;N:</div></tH>
      <td colspan="2" bgcolor="#F4F5F2"><input type="checkbox" name="checkbox" value="1" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right"></td>
      <td colspan="2" bordercolor="#CCCCCC"><div align="right">
       <!--<input class="boton" type="submit" value="Nuevo registro" onClick="msj()"> -->
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p align="center"><a href="javascript:history.back()"><img src="images/Volver.png" width="40" height="40" /></a></p>
</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($ejemplar_detalle);

mysql_free_result($librodetalle);

mysql_free_result($usuario_activo);
?>
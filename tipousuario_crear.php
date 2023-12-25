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
  $insertSQL = sprintf("INSERT INTO tipo_usuario (nombre_tipo_usuario) VALUES (%s)",
                       GetSQLValueString($_POST['nombre_tipo_usuario'], "text"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());
}

mysql_select_db($database_conexionBD, $conexionBD);
$query_tipo_usuario = "SELECT * FROM tipo_usuario";
$tipo_usuario = mysql_query($query_tipo_usuario, $conexionBD) or die(mysql_error());
$row_tipo_usuario = mysql_fetch_assoc($tipo_usuario);
$totalRows_tipo_usuario = mysql_num_rows($tipo_usuario);
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
	text-align: right;
	padding-top: 2px;
}
</style>

</head>

<body onload="document.form1.nombre_tipo_usuario.focus()">
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table class="form" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <th colspan="2" nowrap class="color-textotabla">NUEVO TIPO DE USUARIO </th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>NOMBRE DE USUARIO:</td>
      <td><input name="nombre_tipo_usuario" type="text" value="" size="32" required></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  >&nbsp;</td>
      <td>        <input class="boton" type="submit" value="Nuevo registro">
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($tipo_usuario);
?>

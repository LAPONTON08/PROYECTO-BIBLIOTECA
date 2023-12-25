<?php require('/Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'"); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO proveedor (nombre_proveedor, direccion, telefono, ciudad) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre_proveedor'], "text"),
                       GetSQLValueString($_POST['direccion_proveedor'], "text"),
                       GetSQLValueString($_POST['telefono_proveedor'], "int"),
                       GetSQLValueString($_POST['ciudad_proveedor'], "text"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());

  $insertGoTo = "mensaje.php?mensaje=REGISTRO ADICIONADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
font-family: "myriad Pro";
	font-size: 14px;
	text-align: right;
	padding-top: 2px;
	background-color: #FFFFFF;
}
</style>


</head>
<body onload="document.form1.nombre_proveedor.focus();" >
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table  align="center" cellpadding="5" cellspacing="0" class="form" >
    <tr valign="baseline">
      <th  colspan="2"  nowrap="nowrap" class="color-textotabla">REGISTRO DE PROVEEDORES</strong></span></th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap"  class="texto_tabla">NOMBRE:</td>
      <td  nowrap="nowrap" class="texto_tabla">
        <input name="nombre_proveedor" type="text"  value="" size="32" required /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap"class="texto_tabla"> DIRECCI&Oacute;N:</span></td>
      <td  nowrap="nowrap" class="texto_tabla">
        <input name="direccion_proveedor" type="text"  id="direccion_proveedor" value="" size="32" required  /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla"> TELÉFONO:</td>
      <td  nowrap="nowrap" class="texto_tabla">
        <input name="telefono_proveedor" type="text"  id="telefono_proveedor" value="" size="32" required pattern="[0-9]"  /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">CIUDAD:</td>
      <td nowrap="nowrap" class="texto_tabla">
        <input name="ciudad_proveedor" type="text"   id="ciudad_proveedor" value="" size="32" required /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td nowrap="nowrap" bgcolor="#FEFFEE">&nbsp;</td>
      <td nowrap="nowrap"  class="texto_tabla">
        <input type="submit" value="Nuevo registro" class="boton" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
</form>
<p ></p>
</body>
</html>
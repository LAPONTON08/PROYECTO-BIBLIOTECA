<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'"); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE proveedor SET nombre_proveedor=%s, direccion=%s, telefono=%s, ciudad=%s WHERE id_proveedor=%s",
                       GetSQLValueString($_POST['nombre_proveedor'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['ciudad'], "text"),
                       GetSQLValueString($_POST['id_proveedor'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_proveedor = "-1";
if (isset($_GET['id_proveedor'])) {
  $colname_proveedor = $_GET['id_proveedor'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedor = sprintf("SELECT * FROM proveedor WHERE id_proveedor = %s", GetSQLValueString($colname_proveedor, "int"));
$proveedor = mysql_query($query_proveedor, $conexionBD) or die(mysql_error());
$row_proveedor = mysql_fetch_assoc($proveedor);
$totalRows_proveedor = "-1";
if (isset($_GET['id_proveedor'])) {
  $totalRows_proveedor = $_GET['id_proveedor'];
}

$colname_proveedor = "-1";
if (isset($_GET['id_proveedor'])) {
  $colname_proveedor = $_GET['id_proveedor'];
}
$colname_proveedor = "-1";
if (isset($_GET['id_proveedor'])) {
  $colname_proveedor = (get_magic_quotes_gpc()) ? $_GET['id_proveedor'] : addslashes($_GET['id_proveedor']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedor = sprintf("SELECT * FROM proveedor WHERE id_proveedor = %s", $colname_proveedor);
$proveedor = mysql_query($query_proveedor, $conexionBD) or die(mysql_error());
$row_proveedor = mysql_fetch_assoc($proveedor);
$totalRows_proveedor = mysql_num_rows($proveedor);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" cellpadding="5" cellspacing="0" class="form">
    <tr>
      <th   colspan="2" nowrap="nowrap" class="color-textotabla">ACTUALIZAR PROVEEDORES</th>
    </tr>
    <tr valign="baseline">
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">C&Oacute;DIGO:</td>
      <td bgcolor="#FEFFEE" ><?php echo $row_proveedor['id_proveedor']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">NOMBRE:</td>
      <td bgcolor="#FEFFEE" ><input name="nombre_proveedor" type="text" id="nombre_proveedor"  value="<?php echo htmlentities($row_proveedor['nombre_proveedor'], ENT_COMPAT, 'utf-8'); ?>" size="32"nombre_proveedor /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">DIRECCION:</td>
      <td nowrap="nowrap" bgcolor="#FEFFEE"><input name="direccion" type="text" id="direccion"    value="<?php echo htmlentities($row_proveedor['direccion'], ENT_COMPAT, 'utf-8'); ?>" size="32"direccion /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">TELÉFONO:</td>
      <td nowrap="nowrap" bgcolor="#FEFFEE"><input name="telefono" type="text" id="telefono"  value="<?php echo htmlentities($row_proveedor['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32"telefono /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">CIUDAD:</td>
      <td nowrap="nowrap" bgcolor="#FEFFEE"><input name="ciudad" type="text" id="ciudad"  value="<?php echo htmlentities($row_proveedor['ciudad'], ENT_COMPAT, 'utf-8'); ?>" size="32"ciudad /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE">&nbsp;</td>
      <td nowrap="nowrap" bgcolor="#FEFFEE"><input type="submit" value="Actualizar registro" class="boton" /></td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="id_proveedor" value="<?php echo $row_proveedor['id_proveedor']; ?>" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($proveedor);
?>

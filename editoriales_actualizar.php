<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'");  ?>
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
  $updateSQL = sprintf("UPDATE editorial SET nombre_editorial=%s WHERE id_editorial=%s",
                       GetSQLValueString($_POST['nombre_editorial'], "text"),
                       GetSQLValueString($_POST['id_editorial'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editorial = "-1";
if (isset($_GET['id_editorial'])) {
  $colname_editorial = $_GET['id_editorial'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_editorial = sprintf("SELECT * FROM editorial WHERE id_editorial = %s", GetSQLValueString($colname_editorial, "int"));
$editorial = mysql_query($query_editorial, $conexionBD) or die(mysql_error());
$row_editorial = mysql_fetch_assoc($editorial);
$totalRows_editorial = "-1";
if (isset($_GET['id_editorial'])) {
  $totalRows_editorial = $_GET['id_editorial'];
}

$colname_editorial = "-1";
if (isset($_GET['id_editorial'])) {
  $colname_editorial = $_GET['id_editorial'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_editorial = sprintf("SELECT * FROM editorial WHERE id_editorial = %s", GetSQLValueString($colname_editorial, "int"));
$editorial = mysql_query($query_editorial, $conexionBD) or die(mysql_error());
$row_editorial = mysql_fetch_assoc($editorial);
$totalRows_editorial = mysql_num_rows($editorial);
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
  <table align="left" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline">
      <th colspan="2"  nowrap="nowrap"  class="color-textotabla">ACTUALIZAR EDITORIALES</th>
    </tr>
    <tr valign="baseline">
      <td align="left" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">C&Oacute;DIGO:</td>
      <td bgcolor="#FEFFEE"><?php echo $row_editorial['id_editorial']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">NOMBRE:</td>
      <td bgcolor="#FEFFEE"><input name="nombre_editorial" type="text" id="nombre_editorial"  value="<?php echo htmlentities($row_editorial['nombre_editorial'], ENT_COMPAT, 'utf-8'); ?>" size="32"nombre_editorial /></td>
    </tr>
    <tr valign="baseline">
      <td  nowrap="nowrap" bgcolor="#FEFFEE">&nbsp;</td>
      <td  nowrap="nowrap" bgcolor="#FEFFEE"><input type="submit" value="Actualizar registro"  class="boton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_editorial" value="<?php echo $row_editorial['id_editorial']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($editorial);
?>

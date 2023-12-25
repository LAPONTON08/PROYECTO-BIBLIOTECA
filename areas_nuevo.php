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
  $insertSQL = sprintf("INSERT INTO area (nombre_area) VALUES (%s)",
                       GetSQLValueString($_POST['nombre_area'], "text"));

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
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<title>Documento sin título</title>

<style type="text/css">
body {
	background-color: #FFFFFF;
}
</style>

</head>
<body onload="document.form1.nombre_area.focus();">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="left" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline">
      <th  colspan="2" align="center" nowrap="nowrap" class="color-textotabla">REGISTRO DE AREAS</th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE"><span class="texto_tabla">NOMBRE:</span></td>
      <td align="left" nowrap="nowrap" bgcolor="#FEFFEE"><input name="nombre_area" type="text"  size="32" required /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td height="35" align="left" nowrap="nowrap" bgcolor="#FEFFEE">&nbsp;</td>
      <td width="114" align="left" nowrap="nowrap" bgcolor="#FEFFEE"><input name="submit" type="submit" value="Nuevo registro"  class="boton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p class="TH" style="text-decoration: line-through; padding: 10px; margin: 20px; font-family: 'MYRIADPRO REGULAR';"><span class="texto_tabla"></span></p>
</body>
</html>
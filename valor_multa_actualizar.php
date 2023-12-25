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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE variables_globales SET valor_multa=%s WHERE id=%s",
                       GetSQLValueString($_POST['valor_multa'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_conexionBD, $conexionBD);
$query_valor_multa = "SELECT * FROM variables_globales";
$valor_multa = mysql_query($query_valor_multa, $conexionBD) or die(mysql_error());
$row_valor_multa = mysql_fetch_assoc($valor_multa);
$totalRows_valor_multa = mysql_num_rows($valor_multa);
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
}
</style>


<style type="text/css">
<!--
.Estilo1 {font-family: "MYRIADPRO REGULAR"}
-->
</style>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table class="form" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <th colspan="2"  nowrap class="color-textotabla"> VALOR DE LA MULTA </th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>$ MULTA POR DÍA:</td>
      <td><input type="text" name="valor_multa" value="<?php echo $row_valor_multa['valor_multa']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>&nbsp;</td>
      <td><span class="Estilo1"></span>
      <input class="boton" type="submit" value="Actualizar registro" ></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_valor_multa['id']; ?>">
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($valor_multa);
?>

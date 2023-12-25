<?php require_once('Connections/conexionBD.php'); <link href="CSS/estilos.css" rel="stylesheet" type="text/css" /> ?>
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
  $updateSQL = sprintf("UPDATE multa SET estado=%s, n_consig=%s WHERE id_multa=%s",
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['n_consig'], "text"),
                       GetSQLValueString($_POST['id_multa'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());
}

mysql_select_db($database_conexionBD, $conexionBD);
$query_detalle_multa = "SELECT * FROM detalle_multas";
$detalle_multa = mysql_query($query_detalle_multa, $conexionBD) or die(mysql_error());
$row_detalle_multa = mysql_fetch_assoc($detalle_multa);
$totalRows_detalle_multa = mysql_num_rows($detalle_multa);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo10 {font-size: 10; }
.Estilo5 {font-size: 14px; font-weight: bold; }
.Estilo6 {	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {font-size: 10px; font-weight: bold; }
.Estilo11 {	font-size: 16px;
	font-weight: bold;
}
.Estilo12 {font-size: 12px}
-->
</style>

</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX">
  <tr>
    <td width="213" rowspan="3" align="center" valign="middle"><img src="images/Logo.png" width="203" height="90" hspace="5" vspace="5" align="middle" /></td>
    <td width="440"><h2 align="center">REGISTRO  PAGO DE MULTA </h2></td>
  </tr>
  <tr>
    <td><div align="center">N&deg;:&nbsp;<?php echo $row_detalle_multa['id_multa']; ?></div></td>
  </tr>
</table>
<table style="border-bottom:#333333 solid 1PX; border-TOP:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX" width="100%" border="0" cellpadding="5" cellspacing="5">
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><div align="center"><span class="Estilo5">DATOS DEL PR&Eacute;STAMO </span> </div></td>
  </tr>
  <tr>
    <td width="190"><span class="Estilo6">Nombre Libro: </span></td>
    <td colspan="3"><?php echo $row_detalle_multa['nombre_libro']; ?></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE PR&Eacute;STAMO </div></td>
    <td align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE DEVOLUCI&Oacute;N </div></td>
    <td colspan="2" align="center" valign="middle" bgcolor="#999999"><div align="center" class="Estilo8">FECHA DE ENTREGA </div></td>
  </tr>
  <tr>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_detalle_multa['fecha_prestamo']; ?></div></td>
    <td width="33%" valign="top"><div align="center" class="Estilo10"><?php echo $row_detalle_multa['fecha_devolucion']; ?></div></td>
    <td colspan="2" valign="top"><div align="center" class="Estilo10"></div></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="5" cellspacing="5" style="border-bottom:#333333 solid 1PX; border-left:#333333 solid 1PX; border-right:#333333 solid 1PX">
  <tr>
    <td colspan="4"><span class="Estilo6">Datos Estudiante</span> </td>
    <td><span class="Estilo6">Detalle de Consignaci&oacute;n </span></td>
  </tr>
  <tr>
    <td width="93"><span class="Estilo8">Identificaci&oacute;n:</span></td>
    <td width="576" colspan="3"><?php echo $row_detalle_multa['doc']; ?></td>
    <td rowspan="4"><div align="center" class="Estilo11">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td width="65" align="right" nowrap="nowrap">&nbsp;</td>
            <td width="510"><?php echo $row_detalle_multa['id_multa']; ?></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">Estado:</td>
            <td><label>
                <select name="estado" id="estado">
                  <option value="1" <?php if (!(strcmp(1, $row_detalle_multa['estado']))) {echo "selected=\"selected\"";} ?>>CANCELADA</option>
                  <option value="0" <?php if (!(strcmp(0, $row_detalle_multa['estado']))) {echo "selected=\"selected\"";} ?>>EN DEUDA</option>
                </select>
              </label></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">N_consig:</td>
            <td><input type="text" name="n_consig" value="<?php echo $row_detalle_multa['n_consig']; ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input name="submit" type="submit" value="Registrar Pago" class="boton" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="id_multa" value="<?php echo $row_detalle_multa['id_multa']; ?>" />
      </form>
    </div></td>
  </tr>
  <tr>
    <td><span class="Estilo8">Nombre:</span></td>
    <td colspan="3"><?php echo $row_detalle_multa['nombre_comp']; ?></td>
  </tr>
  <tr>
    <td colspan="4"><div align="left"><span class="Estilo6">Datos Multa</span></div></td>
  </tr>
  <tr>
    <td><span class="Estilo8">N&deg; D&iacute;as:</span></td>
    <td><?php echo $row_detalle_multa['dias_multa']; ?></td>
    <td><span class="Estilo8">Total a Pagar: </span></td>
    <td><span class="Estilo11">&nbsp;$ <?php echo $row_detalle_multa['valor_multa']; ?></span></td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
</table>
<p align="center"><img src="images/Volver.png" width="40" height="40" /></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($detalle_multa);
?>

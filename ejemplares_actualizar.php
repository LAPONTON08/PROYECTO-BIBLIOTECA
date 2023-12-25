<?php require_once('Connections/conexionBD.php'); ?>
<?php require_once('Connections/conexionBD.php'); ?>
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
  $updateSQL = sprintf("UPDATE ejeemplar SET n_ejemplar=%s, id_ubicacion=%s, cod_uts=%s, cod_rb=%s, id_adquisicion=%s, fecha_adquisicion=%s, valor=%s, id_proveedor=%s, estado=%s WHERE id_ejemplar=%s",
                       GetSQLValueString($_POST['n_ejemplar'], "int"),
                       GetSQLValueString($_POST['id_ubicacion'], "int"),
                       GetSQLValueString($_POST['cod_uts'], "int"),
                       GetSQLValueString($_POST['cod_rb'], "int"),
                       GetSQLValueString($_POST['id_adquisicion'], "int"),
                       GetSQLValueString($_POST['fecha_adquisicion'], "date"),
                       GetSQLValueString($_POST['valor'], "int"),
                       GetSQLValueString($_POST['id_proveedor'], "int"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['id_ejemplar'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "mensaje.php?mensaje=SU RESGISTRO HA SIDO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Ejemplares = "-1";
if (isset($_GET['id_ejemplar'])) {
  $colname_Ejemplares = (get_magic_quotes_gpc()) ? $_GET['id_ejemplar'] : addslashes($_GET['id_ejemplar']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_Ejemplares = sprintf("SELECT * FROM ejeemplar WHERE id_ejemplar = %s", $colname_Ejemplares);
$Ejemplares = mysql_query($query_Ejemplares, $conexionBD) or die(mysql_error());
$row_Ejemplares = mysql_fetch_assoc($Ejemplares);
$totalRows_Ejemplares = mysql_num_rows($Ejemplares);

mysql_select_db($database_conexionBD, $conexionBD);
$query_ubicacion = "SELECT * FROM ubicacion ORDER BY id_ubicacion ASC";
$ubicacion = mysql_query($query_ubicacion, $conexionBD) or die(mysql_error());
$row_ubicacion = mysql_fetch_assoc($ubicacion);
$totalRows_ubicacion = mysql_num_rows($ubicacion);

mysql_select_db($database_conexionBD, $conexionBD);
$query_adquisicion = "SELECT * FROM adquisicion ORDER BY nombre_adquisicion ASC";
$adquisicion = mysql_query($query_adquisicion, $conexionBD) or die(mysql_error());
$row_adquisicion = mysql_fetch_assoc($adquisicion);
$totalRows_adquisicion = mysql_num_rows($adquisicion);

mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedores = "SELECT * FROM proveedor";
$proveedores = mysql_query($query_proveedores, $conexionBD) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="/biblioteca/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
}
</style>
<script src="JSCal2-1.9/src/js/jscal2.js"></script>
<script src="JSCal2-1.9/src/js/lang/es.js"></script>
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/jscal2.css">
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/border-radius.css">
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/steel/steel.css">
    <link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline">
      <th colspan="2"  nowrap="nowrap"  class="color-textotabla">ACTUALIZAR EJEMPLARES</th>
    </tr>
    <tr valign="baseline bgcolor=" bgcolor="#FEFFEE"#FEFFEE"">
      <td align="RIGHT" nowrap>EJEMPLAR:</td>
      <td><?php echo $row_Ejemplares['id_ejemplar']; ?></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>N&deg;_EJEMPLAR:</td>
      <td><input type="text" name="n_ejemplar" value="<?php echo $row_Ejemplares['n_ejemplar']; ?>" size="4"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>UBICACI&Oacute;N:</td>
      <td><select name="id_ubicacion" id="id_ubicacion">
        <?php
do {  
?>
        <option value="<?php echo $row_ubicacion['id_ubicacion']?>"<?php if (!(strcmp($row_ubicacion['id_ubicacion'], $row_Ejemplares['id_ubicacion']))) {echo "selected=\"selected\"";} ?>><?php echo $row_ubicacion['descripcion']?></option>
        <?php
} while ($row_ubicacion = mysql_fetch_assoc($ubicacion));
  $rows = mysql_num_rows($ubicacion);
  if($rows > 0) {
      mysql_data_seek($ubicacion, 0);
	  $row_ubicacion = mysql_fetch_assoc($ubicacion);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>COD_UTS:</td>
      <td><input type="text" name="cod_uts" value="<?php echo $row_Ejemplares['cod_uts']; ?>"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>COD_RB</td>
      <td><input type="text" name="cod_rb" value="<?php echo $row_Ejemplares['cod_rb']; ?>"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>ADQUISICI&Oacute;N:</td>
      <td><select name="id_adquisicion" id="id_adquisicion">
        <?php
do {  
?><option value="<?php echo $row_adquisicion['id_adquisicion']?>"<?php if (!(strcmp($row_adquisicion['id_adquisicion'], $row_Ejemplares['id_adquisicion']))) {echo "selected=\"selected\"";} ?>><?php echo $row_adquisicion['nombre_adquisicion']?></option>
        <?php
} while ($row_adquisicion = mysql_fetch_assoc($adquisicion));
  $rows = mysql_num_rows($adquisicion);
  if($rows > 0) {
      mysql_data_seek($adquisicion, 0);
	  $row_adquisicion = mysql_fetch_assoc($adquisicion);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap bgcolor="#FEFFEE">FECHA ADQUISICI&Oacute;N:</td>
      <td align="right" nowrap="nowrap"><input name="fecha_adquisicion" id="f_date1" value="<?php echo date("Y-m-d H:m:s" );?>" size="20" />
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
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>VALOR:</td>
      <td><input type="text" name="valor" value="<?php echo $row_Ejemplares['valor']; ?>"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>PROVEEDOR:</td>
      <td><label>
        <select name="id_proveedor" id="id_proveedor">
          <?php
do {  
?>
          <option value="<?php echo $row_proveedores['id_proveedor']?>"<?php if (!(strcmp($row_proveedores['id_proveedor'], $row_proveedores['nombre_proveedor']))) {echo "selected=\"selected\"";} ?>><?php echo $row_proveedores['nombre_proveedor']?></option>
          <?php
} while ($row_proveedores = mysql_fetch_assoc($proveedores));
  $rows = mysql_num_rows($proveedores);
  if($rows > 0) {
      mysql_data_seek($proveedores, 0);
	  $row_proveedores = mysql_fetch_assoc($proveedores);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>ESTADO:</td>
      <td><input type="text" name="estado" value="<?php echo $row_Ejemplares['estado']; ?>"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>&nbsp;</td>
      <td><div align="right">
        <input class="boton" type="submit" value="Actualizar registro">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_ejemplar" value="<?php echo $row_Ejemplares['id_ejemplar']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Ejemplares);

mysql_free_result($ubicacion);

mysql_free_result($adquisicion);

mysql_free_result($proveedores);
?>

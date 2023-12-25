<?php require('/Connections/conexionBD.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO ejeemplar (id_libro, n_ejemplar, id_ubicacion, cod_uts, cod_rb, id_adquisicion, fecha_adquisicion, valor, id_proveedor, estado) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['id_libro'], "int"),
                       GetSQLValueString($_POST['n_ejemplar'], "int"),
                       GetSQLValueString($_POST['id_ubicacion'], "int"),
                       GetSQLValueString($_POST['cod_uts'], "int"),
                       GetSQLValueString($_POST['cod_rb'], "int"),
                       GetSQLValueString($_POST['id_adquisicion'], "int"),
                       GetSQLValueString($_POST['fecha_adquisicion'], "date"),
                       GetSQLValueString($_POST['valor'], "int"),
                       GetSQLValueString($_POST['id_proveedor'], "int"),
                       GetSQLValueString($_POST['estado'], "text"));

  //echo $insertSQL;
  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());

  $insertGoTo = "mensaje.php?mensaje=REGISTRO ADICIONADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexionBD, $conexionBD);
$query_libros = "SELECT * FROM libro_detalle ORDER BY libro_detalle.nombre_libro";
$libros = mysql_query($query_libros, $conexionBD) or die(mysql_error());
$row_libros = mysql_fetch_assoc($libros);
$totalRows_libros = mysql_num_rows($libros);

mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedores = "SELECT * FROM proveedor ORDER BY proveedor.nombre_proveedor";
$proveedores = mysql_query($query_proveedores, $conexionBD) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);

mysql_select_db($database_conexionBD, $conexionBD);
$query_adquisiciones = "SELECT * FROM adquisicion ORDER BY adquisicion.nombre_adquisicion";
$adquisiciones = mysql_query($query_adquisiciones, $conexionBD) or die(mysql_error());
$row_adquisiciones = mysql_fetch_assoc($adquisiciones);
$totalRows_adquisiciones = mysql_num_rows($adquisiciones);

mysql_select_db($database_conexionBD, $conexionBD);
$query_ejemplares = "SELECT * FROM ejeemplar ORDER BY ejeemplar.id_ejemplar";
$ejemplares = mysql_query($query_ejemplares, $conexionBD) or die(mysql_error());
$row_ejemplares = mysql_fetch_assoc($ejemplares);
$totalRows_ejemplares = mysql_num_rows($ejemplares);

mysql_select_db($database_conexionBD, $conexionBD);
$query_ubicacion = "SELECT * FROM ubicacion ORDER BY ubicacion.id_ubicacion";
$ubicacion = mysql_query($query_ubicacion, $conexionBD) or die(mysql_error());
$row_ubicacion = mysql_fetch_assoc($ubicacion);
$totalRows_ubicacion = mysql_num_rows($ubicacion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
}
</style>
<script src="JSCal2-1.9/src/js/jscal2.js"></script>
<script src="JSCal2-1.9/src/js/lang/es.js"></script>
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/jscal2.css">
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/border-radius.css">
	<link rel="stylesheet" type="text/css" href="JSCal2-1.9/src/css/steel/steel.css">
<script>
<!--


function abrir(url) { 
open(url,'','top=200,left=900,width=400,height=150') ; 
}
//-->
</script> 

</head>
<body onload="document.form1.n_ejemplar.focus();">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center" cellpadding="5" cellspacing="0" class= "form">
    <tr valign="baseline" bgcolor="#CCCCCC" class="color-textotabla">
      <th colspan="2" align="left" nowrap="nowrap">REGISTRO DE EJEMPLARES </th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">C&Oacute;DIGO LIBRO:</td>
      <td align="left" nowrap="nowrap"><?php echo $_GET['id_libro']; ?></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">N° EJEMPLAR:</td>
      <td height="18" align="left" nowrap="nowrap" class="texto_tabla"><label for="id_editorial">
      <input name="n_ejemplar" type="text" id="n_ejemplar"  value="" size="10" maxlength="10"  required pattern="[0-9]"/>
</label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">UBICACI&Oacute;N: </td>
      <td height="18" align="left" nowrap="nowrap" class="texto_tabla"><label>
        <select  name="id_ubicacion" id="id_ubicacion">
          <option value="0">Seleccione ubicacion</option>
          <?php
do {  
?>
          <option value="<?php echo $row_ubicacion['id_ubicacion']?>"><?php echo $row_ubicacion['descripcion']?></option>
          <?php
} while ($row_ubicacion = mysql_fetch_assoc($ubicacion));
  $rows = mysql_num_rows($ubicacion);
  if($rows > 0) {
      mysql_data_seek($ubicacion, 0);
	  $row_ubicacion = mysql_fetch_assoc($ubicacion);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">COD_UTS:</td>
      <td width="196" height="18" align="left" nowrap="nowrap" class="texto_tabla"><input name="cod_uts" type="text" id="cod_uts"  value="" size="10" maxlength="10" required  pattern="[0-9]" title="Ingrese solo n&uacute;meros"/></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">COD_RB:</td>
      <td height="18" align="left" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla"><input name="cod_rb" type="text" id="cod_rb"  value="" size="10" maxlength="10" required pattern="[0-9]" title="Ingrese solo n&uacute;meros"/></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">ADQUISICI&Oacute;N: </td>
      <td height="18" align="left" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla"><label>
        <select name="id_adquisicion" id="id_adquisicion">
          <option value="0">Seleccione adquisicion</option>
          <?php
do {  
?><option value="<?php echo $row_adquisiciones['id_adquisicion']?>"><?php echo $row_adquisiciones['nombre_adquisicion']?></option>
          <?php
} while ($row_adquisiciones = mysql_fetch_assoc($adquisiciones));
  $rows = mysql_num_rows($adquisiciones);
  if($rows > 0) {
      mysql_data_seek($adquisiciones, 0);
	  $row_adquisiciones = mysql_fetch_assoc($adquisiciones);
  }
?>
        </select>
      </label>        <label for="id_coleccion"></label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">FECHA ADQUISICI&Oacute;N :</td>
      <td  nowrap="nowrap" bgcolor="#FEFFEE"><div align="left">
        <input name="fecha_adquisicion" id="f_date1" value="<?php echo date("Y-m-d H:m:s" );?>" size="20" />
        <button id="f_btn1">...</button>
        <script type="text/javascript">//<![CDATA[
      Calendar.setup({
        inputField : "f_date1",
        trigger    : "f_btn1",
        onSelect   : function() { this.hide() },
        showTime   : 12,
        dateFormat : "%Y-%m-%d %H:%m"
      });
    //]]></script>
      </div></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">VALOR: </td>
      <td height="18" align="left" nowrap="nowrap" class="texto_tabla"><input name="valor" type="text" id="valor"  value="" required  pattern="[0-9]" title="Ingrese el valor sin puntos ni comas"/></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">PROVEEDOR:</td>
      <td height="18" align="left" nowrap="nowrap" class="texto_tabla"><label>
        <select  name="id_proveedor" id="id_proveedor">
          <option value="0">Seleccione Proveedor</option>
          <?php
do {  
?>
          <option value="<?php echo $row_proveedores['id_proveedor']?>"><?php echo $row_proveedores['nombre_proveedor']?></option>
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
      <td  nowrap="nowrap" class="texto_tabla">ESTADO:</td>
      <td height="18" align="left" nowrap="nowrap" class="texto_tabla"><select  name="estado" id="estado">
        <option value="BUENO">BUENO</option>
        <option value="REGULAR">REGULAR</option>
        <option value="MALO">MALO</option>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">&nbsp;</td>
      <td  nowrap="nowrap" class="texto_tabla"><label>
        <input class="boton" type="submit"  name="Submit" value="Nuevo Registro" />
          </label></td>
    </tr>
  </table>
  
  <input name="hiddenField" type="hidden" value="<?php echo $_GET['id_libro']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p class="TH" style="text-decoration: line-through; padding: 10px; margin: 20px; font-family: 'MYRIADPRO REGULAR';"><span class="color-textotabla"></span></p>
</body>
</html>
<?php
mysql_free_result($libros);

mysql_free_result($proveedores);

mysql_free_result($adquisiciones);

mysql_free_result($ejemplares);

mysql_free_result($ubicacion);
?>

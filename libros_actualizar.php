<?php require_once('Connections/conexionBD.php'); mysql_query("SET NAMES 'UTF8'");
?>
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
  $updateSQL = sprintf("UPDATE libro SET cod_isbn=%s, nombre_libro=%s, id_autor1=%s, id_autor2=%s, id_autor3=%s, id_autor4=%s, id_autor5=%s, id_editorial=%s, idioma=%s, id_area=%s, tema=%s, edicion=%s, anio=%s, lugar=%s, n_paginas=%s, signatura_top=%s, id_recurso=%s, id_coleccion=%s WHERE id_libro=%s",
                       GetSQLValueString($_POST['cod_isbn'], "text"),
                       GetSQLValueString($_POST['nombre_libro'], "text"),
                       GetSQLValueString($_POST['id_autor1'], "int"),
                       GetSQLValueString($_POST['id_autor2'], "int"),
                       GetSQLValueString($_POST['id_autor3'], "int"),
                       GetSQLValueString($_POST['id_autor4'], "int"),
                       GetSQLValueString($_POST['id_autor5'], "int"),
                       GetSQLValueString($_POST['id_editorial'], "int"),
                       GetSQLValueString($_POST['idioma'], "text"),
                       GetSQLValueString($_POST['id_area'], "int"),
                       GetSQLValueString($_POST['tema'], "text"),
                       
                       GetSQLValueString($_POST['edicion'], "int"),
                       GetSQLValueString($_POST['anio'], "int"),
                       GetSQLValueString($_POST['lugar'], "text"),
                       GetSQLValueString($_POST['n_paginas'], "int"),
                       GetSQLValueString($_POST['signatura_top'], "text"),
                       GetSQLValueString($_POST['id_recurso'], "int"),
                       GetSQLValueString($_POST['id_coleccion'], "int"),
                       GetSQLValueString($_GET['id_libro'], "int"));

//echo $updateSQL;
  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

   $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  
}

$colname_libro = "-1";
if (isset($_GET['id_libro'])) {
  $colname_libro = $_GET['id_libro'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_libro = sprintf("SELECT * FROM libro WHERE id_libro = %s", GetSQLValueString($colname_libro, "int"));
$libro = mysql_query($query_libro, $conexionBD) or die(mysql_error());
$row_libro = mysql_fetch_assoc($libro);
$totalRows_libro = "-1";
if (isset($_GET['id_libro'])) {
  $totalRows_libro = $_GET['id_libro'];
}

$colname_libro = "-1";
if (isset($_GET['id_libro'])) 
{
  $colname_libro = $_GET['id_libro']
  ;
}
$colname_libro = "-1";
if (isset($_GET['id_libro'])) {
  $colname_libro = (get_magic_quotes_gpc()) ? $_GET['id_libro'] : addslashes($_GET['id_libro']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_libro = sprintf("SELECT * FROM libro WHERE id_libro = %s ORDER BY nombre_libro ASC", $colname_libro);
$libro = mysql_query($query_libro, $conexionBD) or die(mysql_error());
$row_libro = mysql_fetch_assoc($libro);
$totalRows_libro = mysql_num_rows($libro);

mysql_select_db($database_conexionBD, $conexionBD);
$query_colecciones = "SELECT * FROM coleccion ORDER BY coleccion.nombre_coleccion";
$colecciones = mysql_query($query_colecciones, $conexionBD) or die(mysql_error());
$row_colecciones = mysql_fetch_assoc($colecciones);
$totalRows_colecciones = mysql_num_rows($colecciones);

mysql_select_db($database_conexionBD, $conexionBD);
$query_autores = "SELECT * FROM autor ORDER BY autor.nombre_autor";
$autores = mysql_query($query_autores, $conexionBD) or die(mysql_error());
$row_autores = mysql_fetch_assoc($autores);
$totalRows_autores = mysql_num_rows($autores);

mysql_select_db($database_conexionBD, $conexionBD);
$query_recursos = "SELECT * FROM recurso ORDER BY  recurso.id_recurso";
$recursos = mysql_query($query_recursos, $conexionBD) or die(mysql_error());
$row_recursos = mysql_fetch_assoc($recursos);
$totalRows_recursos = mysql_num_rows($recursos);

mysql_select_db($database_conexionBD, $conexionBD);
$query_editoriales = "SELECT * FROM editorial ORDER BY editorial.nombre_editorial";
$editoriales = mysql_query($query_editoriales, $conexionBD) or die(mysql_error());
$row_editoriales = mysql_fetch_assoc($editoriales);
$totalRows_editoriales = mysql_num_rows($editoriales);

mysql_select_db($database_conexionBD, $conexionBD);
$query_areas = "SELECT * FROM area ORDER BY nombre_area ASC";
$areas = mysql_query($query_areas, $conexionBD) or die(mysql_error());
$row_areas = mysql_fetch_assoc($areas);
$totalRows_areas = mysql_num_rows($areas);

mysql_select_db($database_conexionBD, $conexionBD);
$query_proveedores = "SELECT * FROM proveedor ORDER BY nombre_proveedor ASC";
$proveedores = mysql_query($query_proveedores, $conexionBD) or die(mysql_error());
$row_proveedores = mysql_fetch_assoc($proveedores);
$totalRows_proveedores = mysql_num_rows($proveedores);
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
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_libro" value="<?php echo $row_libro['id_libro']; ?>" />
  <table align="center" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline">
      <th   colspan="4"  nowrap="nowrap" class="color-textotabla">ACTUALIZAR  LIBROS</th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">C&Oacute;DIGO:</td>
      <td  nowrap="nowrap" class="texto_tabla"><?php echo $row_libro['id_libro']; ?></td>
      <td  nowrap="nowrap" class="texto_tabla">AUTOR1: </td>
      <td  nowrap="nowrap" class="texto_tabla"><select name="id_autor1" id="id_autor1">
        <?php
do {  
?>
        <option value="<?php echo $row_autores['id_autor']?>"<?php if (!(strcmp($row_autores['id_autor'], $row_libro['id_autor1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autores['nombre_autor']?></option><?php
} while ($row_autores = mysql_fetch_assoc($autores));
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">ISBN:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="cod_isbn" type="text" id="cod_isbn"  value="<?php echo $row_libro['cod_isbn']; ?>" size="32"  /></td>
      <td  nowrap="nowrap" class="texto_tabla">AUTOR2:</td>
      <td  nowrap="nowrap" class="texto_tabla"><label for="select">
        <select  name="id_autor2" id="id_autor2">
          <?php
do {  
?>
          <option value="<?php echo $row_autores['id_autor']?>"<?php if (!(strcmp($row_autores['id_autor'], $row_libro['id_autor2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autores['nombre_autor']?></option>
<?php
} while ($row_autores = mysql_fetch_assoc($autores));
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">NOMBRE:</td>
      <td  nowrap="nowrap" class="texto_tabla">
        <input name="nombre_libro"  type="text" id="nombre_libro"  value="<?php echo $row_libro['nombre_libro']; ?>" size="32"  /></td>
      <td  nowrap="nowrap" class="texto_tabla">AUTOR3:</td>
      <td  nowrap="nowrap" class="texto_tabla">
        <select name="id_autor3" id="id_autor3">
          <?php
do {  
?>
          <option value="<?php echo $row_autores['id_autor']?>"<?php if (!(strcmp($row_autores['id_autor'], $row_libro['id_autor3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autores['nombre_autor']?></option>
<?php
} while ($row_autores = mysql_fetch_assoc($autores));
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">EDITORIAL:</td>
      <td  nowrap="nowrap" class="texto_tabla"><label>
        <select  name="id_editorial" id="id_editorial">
          <?php
do {  
?><option value="<?php echo $row_editoriales['id_editorial']?>"<?php if (!(strcmp($row_editoriales['id_editorial'], $row_libro['id_editorial']))) {echo "selected=\"selected\"";} ?>><?php echo $row_editoriales['nombre_editorial']?></option><?php
} while ($row_editoriales = mysql_fetch_assoc($editoriales));
  $rows = mysql_num_rows($editoriales);
  if($rows > 0) {
      mysql_data_seek($editoriales, 0);
	  $row_editoriales = mysql_fetch_assoc($editoriales);
  }
?>
        </select>
      </label></td>
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">AUTOR4: </td>
      <td align="left" nowrap="nowrap" class="texto_tabla"><select  name="id_autor4" id="id_autor4">
        <?php
do {  
?>
        <option value="<?php echo $row_autores['id_autor']?>"<?php if (!(strcmp($row_autores['id_autor'], $row_libro['id_autor4']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autores['nombre_autor']?></option>
<?php
} while ($row_autores = mysql_fetch_assoc($autores));
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">TEMA:</td>
      <td align="left" nowrap="nowrap" class="texto_tabla"><textarea style="width:225px" name="tema" cols="28" rows="1" id="tema"><?php echo $row_libro['tema']; ?></textarea></td>
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">AUTOR5:</td>
      <td  nowrap="nowrap" class="texto_tabla"><select name="id_autor5" id="id_autor5">
        <?php
do {  
?>
        <option value="<?php echo $row_autores['id_autor']?>"<?php if (!(strcmp($row_autores['id_autor'], $row_libro['id_autor5']))) {echo "selected=\"selected\"";} ?>><?php echo $row_autores['nombre_autor']?></option>
        <?php
} while ($row_autores = mysql_fetch_assoc($autores));
  $rows = mysql_num_rows($autores);
  if($rows > 0) {
      mysql_data_seek($autores, 0);
	  $row_autores = mysql_fetch_assoc($autores);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">AREA:</td>
      <td align="left" nowrap="nowrap" class="texto_tabla"><label>
        <select  name="id_area" id="id_area">
          <?php
do {  
?><option value="<?php echo $row_areas['id_area']?>"<?php if (!(strcmp($row_areas['id_area'], $row_libro['id_area']))) {echo "selected=\"selected\"";} ?>><?php echo $row_areas['nombre_area']?></option>
          <?php
} while ($row_areas = mysql_fetch_assoc($areas));
  $rows = mysql_num_rows($areas);
  if($rows > 0) {
      mysql_data_seek($areas, 0);
	  $row_areas = mysql_fetch_assoc($areas);
  }
?>
        </select>
      </label></td>
      <td  nowrap="nowrap" class="texto_tabla">SIGNATURA TOPOGRÁFICA:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="signatura_top" type="text"   id="signatura_top" value="<?php echo $row_libro['signatura_top']; ?>" size="28" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap"  class="texto_tabla">N° DE PAGINAS:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="n_paginas" type="text" value="<?php echo $row_libro['n_paginas']; ?>" size="32"  /></td>
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">IDIOMA:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="idioma" type="text"   id="idioma" value="<?php echo $row_libro['idioma']; ?>" size="28"  /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" class="texto_tabla">EDICI&Oacute;N:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="edicion" type="text"  id="edicion" value="<?php echo $row_libro['edicion']; ?>" size="28"  /></td>
      <td  nowrap="nowrap"  class="texto_tabla">RECURSO:</td>
      <td  nowrap="nowrap" class="texto_tabla"><label>
      <select  name="id_recurso" id="id_recurso">
        <?php
do {  
?>
        <option value="<?php echo $row_recursos['id_recurso']?>"><?php echo $row_recursos['nombre_recurso']?></option>
        <?php
} while ($row_recursos = mysql_fetch_assoc($recursos));
  $rows = mysql_num_rows($recursos);
  if($rows > 0) {
      mysql_data_seek($recursos, 0);
	  $row_recursos = mysql_fetch_assoc($recursos);
  }
?>
      </select>
      </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td nowrap="nowrap" class="texto_tabla">LUGAR:</td>
      <td nowrap="nowrap" class="texto_tabla"><input name="lugar" type="text" id="lugar" value="<?php echo $row_libro['lugar']; ?>" size="28" /></td>
      <td nowrap="nowrap" class="texto_tabla">COLECCI&Oacute;N:</td>
      <td nowrap="nowrap" class="texto_tabla"><select  name="id_coleccion" id="id_coleccion">
        <?php
do {  
?>
        <option value="<?php echo $row_colecciones['id_coleccion']?>"><?php echo $row_colecciones['nombre_coleccion']?></option>
        <?php
} while ($row_colecciones = mysql_fetch_assoc($colecciones));
  $rows = mysql_num_rows($colecciones);
  if($rows > 0) {
      mysql_data_seek($colecciones, 0);
	  $row_colecciones = mysql_fetch_assoc($colecciones);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap"  class="texto_tabla">AÑO:</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="anio" type="text"   id="anio" value="<?php echo $row_libro['anio']; ?>" size="28"  /></td>
      <td  nowrap="nowrap" class="texto_tabla">&nbsp;</td>
      <td  nowrap="nowrap" class="texto_tabla"><input name="submit" type="submit" class="boton"  value="Actualizar registro" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($libro);

mysql_free_result($colecciones);

mysql_free_result($autores);

mysql_free_result($recursos);

mysql_free_result($editoriales);

mysql_free_result($areas);

mysql_free_result($proveedores);
?>

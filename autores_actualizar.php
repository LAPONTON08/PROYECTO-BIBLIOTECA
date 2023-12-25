<?php require_once('Connections/conexionBD.php');  mysql_query("SET NAMES 'UTF8'");?>
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
  $updateSQL = sprintf("UPDATE autor SET nombre_autor=%s, nacionalidad=%s WHERE id_autor=%s",
                       GetSQLValueString($_POST['nombre_autor'], "text"),
                       GetSQLValueString($_POST['nacionalidad'], "text"),
                       GetSQLValueString($_POST['id_autor'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_autor = "-1";
if (isset($_GET['id_autor'])) {
  $colname_autor = $_GET['id_autor'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_autor = sprintf("SELECT * FROM autor WHERE id_autor = %s", GetSQLValueString($colname_autor, "int"));
$autor = mysql_query($query_autor, $conexionBD) or die(mysql_error());
$row_autor = mysql_fetch_assoc($autor);
$totalRows_autor = "-1";
if (isset($_GET['id_autor'])) {
  $totalRows_autor = $_GET['id_autor'];
}

$colname_autor = "-1";
if (isset($_GET['id_autor'])) {
  $colname_autor = $_GET['id_autor'] ;
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_autor = sprintf("SELECT * FROM autor WHERE id_autor = %s", GetSQLValueString($colname_autor, "int"));
$autor = mysql_query($query_autor, $conexionBD) or die(mysql_error());
$row_autor = mysql_fetch_assoc($autor);
$totalRows_autor = mysql_num_rows($autor);$colname_autor = "-1";
if (isset($_GET['id_autor'])) {
  $colname_autor = $_GET['id_autor'];
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_autor = sprintf("SELECT * FROM autor WHERE id_autor = %s", GetSQLValueString($colname_autor, "int"));
$autor = mysql_query($query_autor, $conexionBD) or die(mysql_error());
$row_autor = mysql_fetch_assoc($autor);
$totalRows_autor = mysql_num_rows($autor);

mysql_select_db($database_conexionBD, $conexionBD);
$query_nacionalidades = "SELECT * FROM nacionalidad";
$nacionalidades = mysql_query($query_nacionalidades, $conexionBD) or die(mysql_error());
$row_nacionalidades = mysql_fetch_assoc($nacionalidades);
$totalRows_nacionalidades = mysql_num_rows($nacionalidades);
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
  <table align="left" cellpadding="5" cellspacing="0"  class="form">
    <tr valign="baseline">
      <th colspan="2" 
	   nowrap="nowrap" class="color-textotabla">ACTUALIZAR AUTORES</th>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">C&Oacute;DIGO:</td>
      <td bgcolor="#FEFFEE"><?php echo $row_autor['id_autor']; ?></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">NOMBRE:</td>
      <td bgcolor="#FEFFEE"><input name="nombre_autor" type="text" id="nombre_autor"  value="<?php echo htmlentities($row_autor['nombre_autor'], ENT_COMPAT, 'utf-8'); ?>" size="28"nombre_autor /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">NACIONALIDAD:</td>
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE"><label for="nacionalidad"></label>
        <select style="width:225px" name="nacionalidad" id="nacionalidad">
          <option value="0" <?php if (!(strcmp(0, $row_autor['nacionalidad']))) {echo "selected=\"selected\"";} ?>>Seleccione Nacionalidad</option>
          <?php
do {  
?>
          <option value="<?php echo $row_nacionalidades['id_nacionalidad']?>"<?php if (!(strcmp($row_nacionalidades['id_nacionalidad'], $row_autor['nacionalidad']))) {echo "selected=\"selected\"";} ?>><?php echo $row_nacionalidades['nombre_nacionalidad']?></option>
          <?php
} while ($row_nacionalidades = mysql_fetch_assoc($nacionalidades));
  $rows = mysql_num_rows($nacionalidades);
  if($rows > 0) {
      mysql_data_seek($nacionalidades, 0);
	  $row_nacionalidades = mysql_fetch_assoc($nacionalidades);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE">&nbsp;</td>
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE"><input type="submit" value="Actualizar registro" class="boton" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_autor" value="<?php echo $row_autor['id_autor']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($autor);

mysql_free_result($nacionalidades);
?>

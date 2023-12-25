<?php require('/Connections/conexionBD.php');  mysql_query("SET NAMES 'UTF8'");?>
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
  $insertSQL = sprintf("INSERT INTO autor (nombre_autor, nacionalidad) VALUES (%s, %s)",
                       GetSQLValueString($_POST['nombre_autor'], "text"),
                       GetSQLValueString($_POST['nacionalidad'], "text"));

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
$query_nacionalidades = "SELECT * FROM nacionalidad ORDER BY nacionalidad.nombre_nacionalidad";
$nacionalidades = mysql_query($query_nacionalidades, $conexionBD) or die(mysql_error());
$row_nacionalidades = mysql_fetch_assoc($nacionalidades);
$totalRows_nacionalidades = mysql_num_rows($nacionalidades);
$query_nacionalidades = "SELECT * FROM nacionalidad ORDER BY nacionalidad.nombre_nacionalidad";
$nacionalidades = mysql_query($query_nacionalidades, $conexionBD) or die(mysql_error());
$row_nacionalidades = mysql_fetch_assoc($nacionalidades);
$totalRows_nacionalidades = mysql_num_rows($nacionalidades);
$query_nacionalidades = "SELECT * FROM nacionalidad ORDER BY nacionalidad.nombre_nacionalidad";
$nacionalidades = mysql_query($query_nacionalidades, $conexionBD) or die(mysql_error());
$row_nacionalidades = mysql_fetch_assoc($nacionalidades);
$totalRows_nacionalidades = mysql_num_rows($nacionalidades);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="/biblioteca/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #FFFFFF;
}
</style>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="left" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline" bgcolor="#CCCCCC">
      <th colspan="2" align="center" nowrap="nowrap" bgcolor="#CCCCCC"><span class="color-textotabla"> <strong>REGISTRO DE AUTORES</strong></span></th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" bgcolor="#FEFFEE"><span class="texto_tabla">NOMBRE:
        
      </span></td>
      <td align="left" nowrap="nowrap"><span class="texto_tabla">
        <input name="nombre_autor" type="text"  size="28" required />
      </span></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">NACIONALIDAD:</td>
      <td align="left" nowrap="nowrap"><label for="nacionalidad"></label>
        <select style="width:225px" name="nacionalidad" id="nacionalidad">
          <option value="o">Seleccione nacionalidad</option>
          <?php
do {  
?>
          <option value="<?php echo $row_nacionalidades['id_nacionalidad']?>"><?php echo $row_nacionalidades['nombre_nacionalidad']?></option>
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
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap="nowrap" bgcolor="#FEFFEE" class="texto_tabla">&nbsp;</td>
      <td  nowrap="nowrap">        <input type="submit" class="boton" value="Nuevo registro"  />      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p class="TH" style="text-decoration: line-through; padding: 10px; margin: 20px; font-family: 'MYRIADPRO REGULAR';">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($nacionalidades);
?>

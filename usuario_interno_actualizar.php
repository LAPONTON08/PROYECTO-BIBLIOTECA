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
  $updateSQL = sprintf("UPDATE usuarios SET cod_usuario=%s, nombre=%s, direccion=%s, telefono=%s, correo=%s, id_tipo_usuario=%s, estado_usuario=%s, contrasena=%s WHERE id_usuario=%s",
                       GetSQLValueString($_POST['cod_usuario'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['id_tipo_usuario'], "int"),
                       GetSQLValueString($_POST['estado_usuario'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['id_usuario'], "int"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($updateSQL, $conexionBD) or die(mysql_error());

  $updateGoTo = "/biblioteca/mensaje.php?mensaje=REGISTRO ACTUALIZADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_usuarios = "-1";
if (isset($_GET['id_usuario'])) {
  $colname_usuarios = (get_magic_quotes_gpc()) ? $_GET['id_usuario'] : addslashes($_GET['id_usuario']);
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_usuarios = sprintf("SELECT * FROM usuarios WHERE id_usuario = %s", $colname_usuarios);
$usuarios = mysql_query($query_usuarios, $conexionBD) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_conexionBD, $conexionBD);
$query_tipo_usuario = "SELECT * FROM tipo_usuario";
$tipo_usuario = mysql_query($query_tipo_usuario, $conexionBD) or die(mysql_error());
$row_tipo_usuario = mysql_fetch_assoc($tipo_usuario);
$totalRows_tipo_usuario = mysql_num_rows($tipo_usuario);
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
	padding-top: 2px;
}
</style>
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table border="0" align="center" cellpadding="5" cellspacing="0" class="form">
    <tr valign="baseline">
      <th colspan="2" align="right" nowrap class="color-textotabla">ACTUALIZAR USUARIO </th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>DOCUMENTO:</td>
      <td><input type="text" name="cod_usuario" value="<?php echo $row_usuarios['cod_usuario']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>NOMBRE:</td>
      <td><input type="text" name="nombre" value="<?php echo $row_usuarios['nombre']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>DIRECCI&Oacute;N:</td>
      <td><input type="text" name="direccion" value="<?php echo $row_usuarios['direccion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>TELEFONO:</td>
      <td><input type="text" name="telefono" value="<?php echo $row_usuarios['telefono']; ?>"  size="32"></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>CORREO:</td>
      <td><input type="text" name="correo" value="<?php echo $row_usuarios['correo']; ?>" size="32"></td>
    </tr>
    
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>TIPO DE USUARIO: </td>
      <td><label>
        <select name="id_tipo_usuario" id="id_tipo_usuario">
          <?php
do {  
?>
          <option value="<?php echo $row_tipo_usuario['id_tipo_usuario']?>"<?php if (!(strcmp($row_tipo_usuario['id_tipo_usuario'], $row_usuarios['id_tipo_usuario']))) {echo "selected=\"selected\"";} ?>><?php echo $row_tipo_usuario['nombre_tipo_usuario']?></option>
          <?php
} while ($row_tipo_usuario = mysql_fetch_assoc($tipo_usuario));
  $rows = mysql_num_rows($tipo_usuario);
  if($rows > 0) {
      mysql_data_seek($tipo_usuario, 0);
	  $row_tipo_usuario = mysql_fetch_assoc($tipo_usuario);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>ESTADO:</td>
      <td><label>

        <select name="estado_usuario" id="estado_usuario">
          <option value="ACTIVO" <?php if (!(strcmp("ACTIVO", $row_usuarios['estado_usuario']))) {echo "selected=\"selected\"";} ?>>&Aacute;CTIVO</option>
          <option value="INACTIVO" <?php if (!(strcmp("INACTIVO", $row_usuarios['estado_usuario']))) {echo "selected=\"selected\"";} ?>>IN&Aacute;CTIVO</option>
        </select>
          </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>CONTRASE&Ntilde;A:</td>
      <td>        <input name="contrasena" type="password" value="<?php echo $row_usuarios['contrasena']; ?>"  size="8" maxlength="8" disabled="disabled">&nbsp;&nbsp;</td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>&nbsp;</td>
      <td><input class="boton" type="submit" value="Actualizar registro"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_usuario" value="<?php echo $row_usuarios['id_usuario']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($tipo_usuario);
?>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
   if ( $_POST['contrasena'] == $_POST['confirm_contra']) 
   { 
  $insertSQL = sprintf("INSERT INTO usuarios (cod_usuario, nombre, direccion, telefono, correo, id_tipo_usuario, estado_usuario, contrasena) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['cod_usuario'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['id_tipo_usuario'], "int"),
                       GetSQLValueString($_POST['estado_usuario'], "text"),
                       GetSQLValueString($_POST['contrasena'], "text"));

  mysql_select_db($database_conexionBD, $conexionBD);
  $Result1 = mysql_query($insertSQL, $conexionBD) or die(mysql_error());

  $insertGoTo = "mensaje.php?mensaje=REGISTRO ADICIONADO CON EXITO";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}

 else 
   { 
      echo "<H1><CENTER>Error, confirmar contraseñas</CENTER></H1> "; 
   } 
}
mysql_select_db($database_conexionBD, $conexionBD);
$query_usuarios = "SELECT * FROM usuarios";
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
<link href="CSS/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body,td,th {
	font-family: "myriad Pro";
	font-size: 14px;
	text-align: left;
	padding-top: 2px;
}
h1 {
color:#F5164F;
}

</style>

<script> 
function comprobarclave(){ 
   	$clave1 = document.form1.contrasena.value 
   	$clave2 = document.form1.confirm_contra.value 

   	if ($clave1 == $clave2) 
      {	alert("Contraseña correcta") ;
	  }
   	else 
	boton.disabled=true;
      
		
		return false;
} 
</script> 

</head>

<body 
>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table class="form" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr valign="baseline">
      <th colspan="2" align="right" nowrap class="color-textotabla">NUEVO USUARIO </th>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td nowrap>IDENTIFICACIÓN:</td>
      <td><input name="cod_usuario" type="text" value="<?php if (isset($_POST['cod_usuario'])){echo $_POST['cod_usuario'];}?>" size="10" maxlength="10" required  autocomplete="off" /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>NOMBRE:</td>
      <td><input type="text" name="nombre" value="<?php if (isset($_POST['nombre'])){echo $_POST['nombre'];}?>" size="32" required></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>DIRECCIÓN:</td>
      <td><input type="text" name="direccion" value="<?php if (isset($_POST['direccion'])){echo $_POST['direccion'];}?>" size="32" required /></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>TELÉFONO:</td>
      <td><input name="telefono" type="text" value="<?php if (isset($_POST['telefono'])){echo $_POST['telefono'];}?>" size="20" maxlength="20" required  ></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td  nowrap>CORREO:</td>
      <td><input name="correo" type="texto" id="correo" value="<?php if (isset($_POST['correo'])){echo $_POST['correo'];}?>" size="32" placeholder="ejemplo&#64;hotmail.com" required ></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td nowrap>TIPO DE USUARIO:</td>
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
      <td align="right" nowrap>ESTADO:</td>
      <td><label>

        <select name="estado_usuario" id="estado_usuario">
          <option value="0">Seleccione</option>
          <option value="ACTIVO">&Aacute;CTIVO</option>
        </select>
          </label></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>CONTRASEÑA:</td>
      <td><input name="contrasena" type="password" value="" size="15" maxlength="8" required />        &nbsp;&nbsp;<input name="confirm_contra" type="password" value="" size="15" maxlength="8" placeholder="Repita su contrase&ntilde;a" required></td>
    </tr>
    <tr valign="baseline" bgcolor="#FEFFEE">
      <td align="right" nowrap>&nbsp;</td>
      <td><input name="submit" type="submit" class="boton" value="Insertar registro" "></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($usuarios);

mysql_free_result($tipo_usuario);
?>
